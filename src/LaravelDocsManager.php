<?php

namespace Diagonal\LaravelDocsManager;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\File;
use League\CommonMark\CommonMarkConverter;

class LaravelDocsManager
{
    public function enabled(): bool
    {
        return config('docs-manager.enabled', app()->environment('local'));
    }

    public function routePrefix(): string
    {
        return config('docs-manager.route_prefix', 'docs');
    }

    public function middleware(): array
    {
        return config('docs-manager.middleware', ['web']);
    }

    public function basePath(): string
    {
        return config('docs-manager.base_path', base_path());
    }

    public function getIncludeDirectories(): array
    {
        return config('docs-manager.include_directories', ['docs']);
    }

    public function getExcludeDirectories(): array
    {
        return config('docs-manager.exclude_directories', ['vendor', 'node_modules', '.git']);
    }

    public function getExcludeFiles(): array
    {
        return config('docs-manager.exclude_files', []);
    }

    public function getMarkdownFiles(): Collection
    {
        // Check cache first
        $cacheKey = 'docs-manager.markdown-files.'.md5($this->basePath());

        return cache()->remember($cacheKey, 300, function () { // Cache for 5 minutes
            return $this->scanForMarkdownFiles();
        });
    }

    public function clearCache(): void
    {
        $cacheKey = 'docs-manager.markdown-files.'.md5($this->basePath());
        cache()->forget($cacheKey);
    }

    protected function scanForMarkdownFiles(): Collection
    {
        $basePath = $this->basePath();
        $excludeDirectories = $this->getExcludeDirectories();
        $excludeFiles = $this->getExcludeFiles();

        $allFiles = collect();

        // Use a more efficient recursive scan that skips excluded directories upfront
        $this->scanDirectory($basePath, $basePath, $excludeDirectories, $excludeFiles, $allFiles);

        return $allFiles
            ->map(function ($file) use ($basePath) {
                $relativePath = str_replace($basePath.DIRECTORY_SEPARATOR, '', $file->getPathname());

                return [
                    'name' => pathinfo($file->getFilename(), PATHINFO_FILENAME),
                    'filename' => $file->getFilename(),
                    'path' => $relativePath,
                    'full_path' => $file->getPathname(),
                    'directory' => dirname($relativePath) === '.' ? '' : dirname($relativePath),
                    'size' => $file->getSize(),
                    'modified' => $file->getMTime(),
                ];
            })
            ->sortBy('path');
    }

    protected function scanDirectory(string $directory, string $basePath, array $excludeDirectories, array $excludeFiles, Collection $allFiles): void
    {
        if (! File::isDirectory($directory)) {
            return;
        }

        try {
            $items = File::glob($directory.'/*');

            foreach ($items as $item) {
                $relativePath = str_replace($basePath.DIRECTORY_SEPARATOR, '', $item);

                if (File::isDirectory($item)) {
                    // Skip excluded directories early
                    $dirName = basename($item);
                    $shouldSkip = false;

                    foreach ($excludeDirectories as $excludeDir) {
                        if ($relativePath === $excludeDir ||
                            str_starts_with($relativePath, $excludeDir.DIRECTORY_SEPARATOR) ||
                            $dirName === $excludeDir) {
                            $shouldSkip = true;
                            break;
                        }
                    }

                    if (! $shouldSkip) {
                        // Recursively scan subdirectory
                        $this->scanDirectory($item, $basePath, $excludeDirectories, $excludeFiles, $allFiles);
                    }
                } else {
                    // Check if it's a markdown file
                    $extension = strtolower(pathinfo($item, PATHINFO_EXTENSION));
                    if (in_array($extension, ['md', 'markdown'])) {
                        $filename = basename($item);

                        // Skip if file matches excluded patterns
                        if (! $this->isFileExcluded($filename, $excludeFiles)) {
                            $allFiles->push(new \SplFileInfo($item));
                        }
                    }
                }
            }
        } catch (\Exception $e) {
            // Skip directories that can't be read (permissions, etc.)
            return;
        }
    }

    public function getMarkdownContent(string $relativePath): ?string
    {
        $fullPath = $this->basePath().DIRECTORY_SEPARATOR.$relativePath;

        if (! File::exists($fullPath) || ! $this->isPathSafe($relativePath)) {
            return null;
        }

        return File::get($fullPath);
    }

    public function getMarkdownContentAsHtml(string $relativePath): ?string
    {
        $content = $this->getMarkdownContent($relativePath);

        if ($content === null) {
            return null;
        }

        // Use CommonMark for backend rendering (Spatie component handles frontend rendering)
        $converter = new CommonMarkConverter([
            'html_input' => 'strip',
            'allow_unsafe_links' => false,
        ]);

        return $converter->convert($content)->getContent();
    }

    public function hasEnhancedMarkdownSupport(): bool
    {
        return class_exists(\Spatie\LaravelMarkdown\MarkdownRenderer::class);
    }

    protected function isFileExcluded(string $filename, array $excludePatterns): bool
    {
        foreach ($excludePatterns as $pattern) {
            if (fnmatch($pattern, $filename)) {
                return true;
            }
        }

        return false;
    }

    protected function isPathSafe(string $path): bool
    {
        $realBasePath = realpath($this->basePath());
        $realFilePath = realpath($this->basePath().DIRECTORY_SEPARATOR.$path);

        return $realFilePath && str_starts_with($realFilePath, $realBasePath);
    }
}
