<?php

namespace Diagonal\LaravelDocsManager\Http\Controllers;

use Diagonal\LaravelDocsManager\LaravelDocsManager;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class DocsController extends Controller
{
    protected LaravelDocsManager $docsManager;

    public function __construct(LaravelDocsManager $docsManager)
    {
        $this->docsManager = $docsManager;
    }

    public function index(Request $request)
    {
        $markdownFiles = $this->docsManager->getMarkdownFiles();

        return view('laravel-docs-manager::index', [
            'message' => 'Browse your markdown documentation files below.',
            'markdownFiles' => $markdownFiles,
            'basePath' => $this->docsManager->basePath(),
            'includeDirectories' => $this->docsManager->getIncludeDirectories(),
        ]);
    }

    public function show(Request $request, string $path)
    {
        $rawContent = $this->docsManager->getMarkdownContent($path);

        if ($rawContent === null) {
            abort(404, 'Documentation file not found.');
        }

        // Only render HTML on backend if Spatie package is not available
        $htmlContent = $this->docsManager->getMarkdownContentAsHtml($path);

        $markdownFiles = $this->docsManager->getMarkdownFiles();

        return view('laravel-docs-manager::show', [
            'content' => $htmlContent,
            'rawContent' => $rawContent,
            'path' => $path,
            'markdownFiles' => $markdownFiles,
        ]);
    }

    public function reload(Request $request)
    {
        $this->docsManager->clearCache();

        return redirect()->route('docs-manager.index')->with('success', 'Files reloaded successfully!');
    }
}
