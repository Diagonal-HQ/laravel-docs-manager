<?php

namespace Diagonal\LaravelDocsManager\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Inertia\Inertia;

class DocsController extends Controller
{
    public function index(Request $request)
    {
        // Check if Inertia is available
        if (class_exists(\Inertia\Inertia::class) && $request->header('X-Inertia')) {
            return Inertia::render('DocsManager/Index', [
                'message' => 'Hello World from Laravel Docs Manager!',
            ]);
        }

        // Fallback to Blade view for testing
        return view('docs-manager::index', [
            'message' => 'Hello World from Laravel Docs Manager! (Blade fallback for testing)',
        ]);
    }
}
