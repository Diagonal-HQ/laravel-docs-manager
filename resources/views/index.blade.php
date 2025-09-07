@extends('laravel-docs-manager::app')

@section('content')
<div class="h-screen flex bg-gray-50">
    <!-- Fixed Sidebar -->
    <div class="w-80 bg-white border-r border-gray-200 flex flex-col">
        <!-- Sidebar Header -->
        <div class="p-6 border-b border-gray-200">
            <div class="flex items-center justify-between mb-2">
                <h1 class="text-xl font-semibold text-gray-900">Laravel Docs Manager</h1>
                <form method="POST" action="{{ route('docs-manager.reload') }}" class="inline">
                    @csrf
                    <button type="submit" 
                            class="inline-flex items-center px-3 py-1.5 bg-blue-600 hover:bg-blue-700 text-white text-xs font-medium rounded-md transition-colors duration-150"
                            title="Reload files from disk">
                        <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                        </svg>
                        Reload Files
                    </button>
                </form>
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
                                           class="block px-3 py-2 text-sm text-gray-700 hover:bg-gray-100 hover:text-gray-900 rounded-md transition-colors duration-150 group">
                                            <div class="flex items-center">
                                                <svg class="w-4 h-4 mr-2 text-gray-400 group-hover:text-gray-600" fill="currentColor" viewBox="0 0 20 20">
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
                                   class="block px-3 py-2 text-sm text-gray-700 hover:bg-gray-100 hover:text-gray-900 rounded-md transition-colors duration-150 group">
                                    <div class="flex items-center">
                                        <svg class="w-4 h-4 mr-2 text-gray-400 group-hover:text-gray-600" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4zm2 6a1 1 0 011-1h6a1 1 0 110 2H7a1 1 0 01-1-1zm1 3a1 1 0 100 2h6a1 1 0 100-2H7z" clip-rule="evenodd"></path>
                                        </svg>
                                        <span class="truncate">{{ $file['name'] }}</span>
                                    </div>
                                </a>
                            @endforeach
                        @endif
                    @endforeach
                </div>
            @else
                <div class="text-center py-12">
                    <svg class="w-16 h-16 mx-auto text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    <p class="text-gray-500 text-sm font-medium mb-2">No markdown files found</p>
                    <p class="text-gray-400 text-xs">
                        Add .md files to your project directories
                    </p>
                </div>
            @endif
        </div>
    </div>
    
    <!-- Main Content Area -->
    <div class="flex-1 flex flex-col overflow-hidden">
        <!-- Main Content Header -->
        <div class="bg-white border-b border-gray-200 px-8 py-6">
            <h1 class="text-2xl font-semibold text-gray-900">Welcome to Laravel Docs Manager</h1>
            <p class="text-gray-600 mt-2">{{ $message }}</p>
            
            @if(session('success'))
                <div class="mt-4 bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-md">
                    <div class="flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                        </svg>
                        {{ session('success') }}
                    </div>
                </div>
            @endif
        </div>
        
        <!-- Main Content Body -->
        <div class="flex-1 overflow-y-auto bg-gray-50">
            <div class="p-8">
                <div class="max-w-4xl">
                    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-8">
                        <div class="text-center mb-8">
                            <svg class="w-16 h-16 mx-auto text-blue-500 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                            <h2 class="text-xl font-semibold text-gray-900 mb-2">Project Documentation Browser</h2>
                            <p class="text-gray-600 max-w-2xl mx-auto">
                                This tool automatically discovers and displays all markdown files throughout your Laravel project. 
                                It scans major directories like app/, database/, tests/, and more while excluding vendor/ and other build directories.
                            </p>
                        </div>
                        
                        @if($markdownFiles->count() > 0)
                            <div class="grid md:grid-cols-2 gap-6 mb-8">
                                <div class="bg-blue-50 p-6 rounded-lg">
                                    <h3 class="font-semibold text-blue-900 mb-2">📊 Statistics</h3>
                                    <div class="space-y-2 text-sm">
                                        <div class="flex justify-between">
                                            <span class="text-blue-700">Total Files:</span>
                                            <span class="font-medium text-blue-900">{{ $markdownFiles->count() }}</span>
                                        </div>
                                        <div class="flex justify-between">
                                            <span class="text-blue-700">Directories:</span>
                                            <span class="font-medium text-blue-900">{{ $markdownFiles->pluck('directory')->filter()->unique()->count() }}</span>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="bg-green-50 p-6 rounded-lg">
                                    <h3 class="font-semibold text-green-900 mb-2">🚀 Quick Start</h3>
                                    <p class="text-sm text-green-700 mb-3">Select any file from the sidebar to start browsing your documentation.</p>
                                    <p class="text-xs text-green-600">Files are organized by directory for easy navigation.</p>
                                </div>
                            </div>
                        @else
                            <div class="bg-amber-50 border border-amber-200 p-6 rounded-lg">
                                <h3 class="font-semibold text-amber-900 mb-3">🔍 No Files Found</h3>
                                <p class="text-amber-800 mb-4">
                                    This package scans your entire Laravel project for markdown files. Create .md files in any of these directories to get started:
                                </p>
                                <div class="grid grid-cols-3 gap-2">
                                    @foreach($includeDirectories as $dir)
                                        <code class="bg-amber-100 text-amber-800 px-2 py-1 rounded text-xs font-mono">{{ $dir === '' ? 'root/' : $dir . '/' }}</code>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                        
                        <div class="border-t border-gray-200 pt-6">
                            <h3 class="font-semibold text-gray-900 mb-3">✨ Features</h3>
                            <div class="grid md:grid-cols-2 gap-4 text-sm text-gray-600">
                                <div class="flex items-start">
                                    <svg class="w-4 h-4 mt-0.5 mr-2 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                    </svg>
                                    <span>Automatic file discovery</span>
                                </div>
                                <div class="flex items-start">
                                    <svg class="w-4 h-4 mt-0.5 mr-2 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                    </svg>
                                    <span>Rendered markdown display</span>
                                </div>
                                <div class="flex items-start">
                                    <svg class="w-4 h-4 mt-0.5 mr-2 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                    </svg>
                                    <span>Directory-based organization</span>
                                </div>
                                <div class="flex items-start">
                                    <svg class="w-4 h-4 mt-0.5 mr-2 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                    </svg>
                                    <span>Raw markdown view toggle</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
