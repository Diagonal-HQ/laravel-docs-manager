<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laravel Docs Manager</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50">
    <div class="min-h-screen py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6 lg:p-8 bg-white border-b border-gray-200">
                    <h1 class="text-2xl font-medium text-gray-900">
                        Laravel Docs Manager
                    </h1>
                    <p class="mt-6 text-gray-500 leading-relaxed">
                        {{ $message }}
                    </p>
                </div>
                <div class="p-6 lg:p-8">
                    <div class="bg-gray-100 p-4 rounded-lg">
                        <h2 class="text-lg font-semibold text-gray-800 mb-2">
                            Welcome to Docs Manager
                        </h2>
                        <p class="text-gray-600">
                            This package will help you browse and manage your markdown documentation files 
                            directly from your Laravel application. Perfect for development environments!
                        </p>
                        <div class="mt-4 p-3 bg-green-100 rounded border-l-4 border-green-500">
                            <p class="text-green-700">
                                ✅ Package is working! The route is accessible and the controller is responding.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
