import { Head } from '@inertiajs/react';
import React from 'react';

export default function Index({ message }) {
    return (
        <>
            <Head title="Laravel Docs Manager" />
            <div className="min-h-screen bg-gray-50 py-12">
                <div className="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <div className="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                        <div className="p-6 lg:p-8 bg-white border-b border-gray-200">
                            <h1 className="text-2xl font-medium text-gray-900">
                                Laravel Docs Manager
                            </h1>
                            <p className="mt-6 text-gray-500 leading-relaxed">
                                {message}
                            </p>
                        </div>
                        <div className="p-6 lg:p-8">
                            <div className="bg-gray-100 p-4 rounded-lg">
                                <h2 className="text-lg font-semibold text-gray-800 mb-2">
                                    Welcome to Docs Manager
                                </h2>
                                <p className="text-gray-600">
                                    This package will help you browse and manage your markdown documentation files 
                                    directly from your Laravel application. Perfect for development environments!
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </>
    );
}
