@extends('laravel-docs-manager::app')

@section('content')
<style>
    /* Completely reset and override Tailwind for markdown content */
    .markdown-content {
        /* Reset Tailwind's normalize and use browser defaults */
        all: revert;
        
        /* Base typography */
        font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
        font-size: 16px;
        line-height: 1.6;
        color: #374151;
        max-width: none;
    }
    
    .markdown-content h1 {
        font-size: 2.25em;
        font-weight: 700;
        margin-top: 0;
        margin-bottom: 1rem;
        color: #111827;
        border-bottom: 1px solid #e5e7eb;
        padding-bottom: 0.5rem;
    }
    
    .markdown-content h2 {
        font-size: 1.875em;
        font-weight: 600;
        margin-top: 2rem;
        margin-bottom: 1rem;
        color: #111827;
    }
    
    .markdown-content h3 {
        font-size: 1.5em;
        font-weight: 600;
        margin-top: 1.5rem;
        margin-bottom: 0.75rem;
        color: #111827;
    }
    
    .markdown-content h4 {
        font-size: 1.25em;
        font-weight: 600;
        margin-top: 1.25rem;
        margin-bottom: 0.5rem;
        color: #111827;
    }
    
    .markdown-content h5 {
        font-size: 1.125em;
        font-weight: 600;
        margin-top: 1rem;
        margin-bottom: 0.5rem;
        color: #111827;
    }
    
    .markdown-content h6 {
        font-size: 1em;
        font-weight: 600;
        margin-top: 1rem;
        margin-bottom: 0.5rem;
        color: #6b7280;
    }
    
    .markdown-content p {
        margin-bottom: 1rem;
        line-height: 1.7;
    }
    
    .markdown-content ul {
        list-style-type: disc;
        margin-left: 2rem;
        margin-bottom: 1rem;
        padding-left: 0;
    }
    
    .markdown-content ol {
        list-style-type: decimal;
        margin-left: 2rem;
        margin-bottom: 1rem;
        padding-left: 0;
    }
    
    .markdown-content li {
        margin-bottom: 0.25rem;
        line-height: 1.6;
    }
    
    .markdown-content li ul,
    .markdown-content li ol {
        margin-top: 0.5rem;
        margin-bottom: 0.5rem;
    }
    
    .markdown-content blockquote {
        border-left: 4px solid #3b82f6;
        padding-left: 1rem;
        margin: 1rem 0;
        font-style: italic;
        color: #6b7280;
        background-color: #f8fafc;
        padding-top: 0.5rem;
        padding-bottom: 0.5rem;
    }
    
    .markdown-content code {
        background-color: #f3f4f6;
        padding: 0.125rem 0.25rem;
        border-radius: 0.25rem;
        font-family: ui-monospace, SFMono-Regular, "SF Mono", Consolas, "Liberation Mono", Menlo, monospace;
        font-size: 0.875em;
        color: #1f2937;
    }
    
    .markdown-content pre {
        background-color: #1f2937;
        color: #f9fafb;
        padding: 1rem;
        border-radius: 0.5rem;
        overflow-x: auto;
        margin: 1rem 0;
        font-family: ui-monospace, SFMono-Regular, "SF Mono", Consolas, "Liberation Mono", Menlo, monospace;
        font-size: 0.875em;
        line-height: 1.5;
    }
    
    .markdown-content pre code {
        background-color: transparent;
        padding: 0;
        color: inherit;
        font-size: inherit;
    }
    
    .markdown-content a {
        color: #2563eb;
        text-decoration: underline;
    }
    
    .markdown-content a:hover {
        color: #1d4ed8;
    }
    
    .markdown-content strong,
    .markdown-content b {
        font-weight: 600;
        color: #111827;
    }
    
    .markdown-content em,
    .markdown-content i {
        font-style: italic;
    }
    
    .markdown-content hr {
        border: none;
        border-top: 1px solid #d1d5db;
        margin: 2rem 0;
    }
    
    .markdown-content table {
        width: 100%;
        border-collapse: collapse;
        margin: 1rem 0;
    }
    
    .markdown-content th {
        background-color: #f9fafb;
        border: 1px solid #d1d5db;
        padding: 0.75rem 1rem;
        text-align: left;
        font-weight: 600;
        color: #111827;
    }
    
    .markdown-content td {
        border: 1px solid #d1d5db;
        padding: 0.75rem 1rem;
        color: #374151;
    }
    
    /* Ensure first element doesn't have excessive top margin */
    .markdown-content > *:first-child {
        margin-top: 0;
    }
    
    /* Ensure last element doesn't have excessive bottom margin */
    .markdown-content > *:last-child {
        margin-bottom: 0;
    }
</style>

<div class="h-screen flex bg-gray-50">
    <!-- Fixed Sidebar -->
    <div class="w-80 bg-white border-r border-gray-200 flex flex-col">
        <!-- Sidebar Header -->
        <div class="p-6 border-b border-gray-200">
            <div class="flex items-center justify-between mb-2">
                <h1 class="text-xl font-semibold text-gray-900">Docs Manager</h1>
                <div class="flex items-center space-x-2">
                    <form method="POST" action="{{ route('docs-manager.reload') }}" class="inline">
                        @csrf
                        <button type="submit" 
                                class="inline-flex items-center px-2 py-1 bg-blue-600 hover:bg-blue-700 text-white text-xs font-medium rounded transition-colors duration-150"
                                title="Reload files from disk">
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                            </svg>
                        </button>
                    </form>
                    <a href="{{ route('docs-manager.index') }}" 
                       class="text-gray-400 hover:text-gray-600 transition-colors"
                       title="Back to overview">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2H5a2 2 0 00-2-2z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 5a2 2 0 012-2h4a2 2 0 012 2v4H8V5z"></path>
                        </svg>
                    </a>
                </div>
            </div>
            <p class="text-sm text-gray-500">{{ $markdownFiles->count() }} files found</p>
        </div>
        
        <!-- Scrollable File List -->
        <div class="flex-1 overflow-y-auto p-4">
            <h3 class="text-sm font-medium text-gray-700 mb-3 uppercase tracking-wide">Documentation Files</h3>
                    
            @if($markdownFiles->count() > 0)
                <div class="space-y-1">
                    @php
                        $groupedFiles = $markdownFiles->groupBy('directory');
                    @endphp
                    
                    @foreach($groupedFiles as $directory => $files)
                        @if($directory !== '')
                            <div class="mb-4">
                                <h4 class="text-xs font-semibold text-gray-500 mb-2 flex items-center uppercase tracking-wider">
                                    <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M2 6a2 2 0 012-2h5l2 2h5a2 2 0 012 2v6a2 2 0 01-2 2H4a2 2 0 01-2-2V6z"></path>
                                    </svg>
                                    {{ $directory }}
                                </h4>
                                <div class="ml-4 space-y-1">
                                    @foreach($files as $file)
                                        <a href="{{ route('docs-manager.show', $file['path']) }}" 
                                           class="block px-3 py-2 text-sm rounded-md transition-colors duration-150 group {{ $file['path'] === $path ? 'bg-blue-100 text-blue-900 font-medium' : 'text-gray-700 hover:bg-gray-100 hover:text-gray-900' }}">
                                            <div class="flex items-center">
                                                <svg class="w-4 h-4 mr-2 {{ $file['path'] === $path ? 'text-blue-500' : 'text-gray-400 group-hover:text-gray-600' }}" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4zm2 6a1 1 0 011-1h6a1 1 0 110 2H7a1 1 0 01-1-1zm1 3a1 1 0 100 2h6a1 1 0 100-2H7z" clip-rule="evenodd"></path>
                                                </svg>
                                                <span class="truncate">{{ $file['name'] }}</span>
                                            </div>
                                        </a>
                                    @endforeach
                                </div>
                            </div>
                        @else
                            @foreach($files as $file)
                                <a href="{{ route('docs-manager.show', $file['path']) }}" 
                                   class="block px-3 py-2 text-sm rounded-md transition-colors duration-150 group {{ $file['path'] === $path ? 'bg-blue-100 text-blue-900 font-medium' : 'text-gray-700 hover:bg-gray-100 hover:text-gray-900' }}">
                                    <div class="flex items-center">
                                        <svg class="w-4 h-4 mr-2 {{ $file['path'] === $path ? 'text-blue-500' : 'text-gray-400 group-hover:text-gray-600' }}" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4zm2 6a1 1 0 011-1h6a1 1 0 110 2H7a1 1 0 01-1-1zm1 3a1 1 0 100 2h6a1 1 0 100-2H7z" clip-rule="evenodd"></path>
                                        </svg>
                                        <span class="truncate">{{ $file['name'] }}</span>
                                    </div>
                                </a>
                            @endforeach
                        @endif
                    @endforeach
                </div>
            @endif
        </div>
    </div>
    
    <!-- Main Content Area -->
    <div class="flex-1 flex flex-col overflow-hidden">
        <!-- Main Content Header -->
        <div class="bg-white border-b border-gray-200 px-8 py-6">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-2xl font-semibold text-gray-900">{{ basename($path, '.md') }}</h1>
                    <p class="text-gray-500 text-sm mt-1">{{ $path }}</p>
                </div>
                <div class="flex space-x-2">
                    <button onclick="showRendered()" id="rendered-tab" class="px-4 py-2 text-sm font-medium text-blue-600 bg-blue-50 border border-blue-200 rounded-md">
                        Rendered
                    </button>
                    <button onclick="showRaw()" id="raw-tab" class="px-4 py-2 text-sm font-medium text-gray-600 bg-white border border-gray-300 rounded-md hover:bg-gray-50">
                        Raw Markdown
                    </button>
                </div>
            </div>
        </div>
        
        <!-- Main Content Body -->
        <div class="flex-1 overflow-y-auto bg-gray-50">
            <div class="p-8">
                <div id="rendered-content">
                    <div class="bg-white p-8 rounded-lg border shadow-sm">
                        <div class="markdown-content">
                                {!! $content !!}
                        </div>
                    </div>
                </div>
                
                <div id="raw-content" class="hidden">
                    <div class="bg-white p-8 rounded-lg border shadow-sm">
                        <pre class="whitespace-pre-wrap text-sm text-gray-800 font-mono leading-relaxed">{{ $rawContent }}</pre>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function showRendered() {
    document.getElementById('rendered-content').classList.remove('hidden');
    document.getElementById('raw-content').classList.add('hidden');
    
    document.getElementById('rendered-tab').className = 'px-4 py-2 text-sm font-medium text-blue-600 bg-blue-50 border border-blue-200 rounded-md';
    document.getElementById('raw-tab').className = 'px-4 py-2 text-sm font-medium text-gray-600 bg-white border border-gray-300 rounded-md hover:bg-gray-50';
}

function showRaw() {
    document.getElementById('rendered-content').classList.add('hidden');
    document.getElementById('raw-content').classList.remove('hidden');
    
    document.getElementById('raw-tab').className = 'px-4 py-2 text-sm font-medium text-blue-600 bg-blue-50 border border-blue-200 rounded-md';
    document.getElementById('rendered-tab').className = 'px-4 py-2 text-sm font-medium text-gray-600 bg-white border border-gray-300 rounded-md hover:bg-gray-50';
}
</script>
@endsection
