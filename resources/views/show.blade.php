@extends('laravel-docs-manager::app')

@section('content')
<style>
    .prose h1 { @apply text-2xl font-bold text-gray-900 mt-6 mb-4; }
    .prose h2 { @apply text-xl font-semibold text-gray-900 mt-5 mb-3; }
    .prose h3 { @apply text-lg font-medium text-gray-900 mt-4 mb-2; }
    .prose h4 { @apply text-base font-medium text-gray-900 mt-3 mb-2; }
    .prose h5 { @apply text-sm font-medium text-gray-900 mt-3 mb-1; }
    .prose h6 { @apply text-sm font-medium text-gray-600 mt-2 mb-1; }
    .prose p { @apply text-gray-700 mb-4 leading-relaxed; }
    .prose ul { @apply list-disc list-inside mb-4 space-y-1; }
    .prose ol { @apply list-decimal list-inside mb-4 space-y-1; }
    .prose li { @apply text-gray-700; }
    .prose blockquote { @apply border-l-4 border-gray-300 pl-4 italic text-gray-600 mb-4; }
    .prose code { @apply bg-gray-100 px-1 py-0.5 rounded text-sm font-mono text-gray-800; }
    .prose pre { @apply bg-gray-100 p-4 rounded-lg overflow-x-auto mb-4; }
    .prose pre code { @apply bg-transparent p-0; }
    .prose a { @apply text-blue-600 hover:text-blue-800 underline; }
    .prose strong { @apply font-semibold text-gray-900; }
    .prose em { @apply italic; }
    .prose hr { @apply border-gray-300 my-6; }
    .prose table { @apply min-w-full border-collapse mb-4; }
    .prose th { @apply bg-gray-50 border border-gray-300 px-4 py-2 text-left font-medium text-gray-900; }
    .prose td { @apply border border-gray-300 px-4 py-2 text-gray-700; }
</style>

<div class="h-screen flex bg-gray-50">
    <!-- Fixed Sidebar -->
    <div class="w-80 bg-white border-r border-gray-200 flex flex-col">
        <!-- Sidebar Header -->
        <div class="p-6 border-b border-gray-200">
            <div class="flex items-center justify-between mb-2">
                <h1 class="text-xl font-semibold text-gray-900">Laravel Docs Manager</h1>
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
                <div id="rendered-content" class="prose prose-lg max-w-none">
                    <div class="bg-white p-8 rounded-lg border shadow-sm">
                        {!! $content !!}
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
