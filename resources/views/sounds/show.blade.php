@extends('layouts.app')

@section('content')
<div class="bg-gradient-to-b from-gray-900 to-black min-h-screen text-white">
    <div class="container mx-auto p-6">
        <!-- Header with back button -->
        <div class="mb-8">
            <a href="{{ route('sounds.index') }}" class="inline-flex items-center gap-2 text-gray-400 hover:text-white transition duration-300">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z" clip-rule="evenodd" />
                </svg>
                <span class="font-medium">Back to Sound List</span>
            </a>
        </div>

        <!-- Main content area -->
        <div class="flex flex-col lg:flex-row gap-8 items-start">
            <!-- Album art -->
            <div class="lg:w-1/3 w-full">
                <div class="aspect-square shadow-2xl rounded-md overflow-hidden bg-gray-800">
                    <img src="{{ asset('storage/' . $sound->image_path) }}" alt="{{ $sound->title }}" class="w-full h-full object-cover">
                </div>
            </div>

            <!-- Sound details -->
            <div class="lg:w-2/3 w-full">
                <div class="mb-6">
                    <h1 class="text-4xl font-bold mb-1 text-white">{{ $sound->title }}</h1>
                    <p class="text-xl text-gray-400">{{ $sound->artist }}</p>
                </div>

                <!-- Audio player -->
                <div class="mb-8">
                    <audio controls class="w-full h-12 rounded-full bg-gray-800">
                        <source src="{{ asset('storage/' . $sound->file_path) }}" type="audio/mpeg">
                        Your browser does not support the audio element.
                    </audio>
                </div>

                <!-- Description -->
                <div class="bg-gray-800 bg-opacity-40 backdrop-blur-sm rounded-lg p-6">
                    <h2 class="text-lg font-semibold mb-3 text-gray-200">About this sound</h2>
                    <div class="prose prose-invert max-w-none text-gray-300 leading-relaxed">
                        {{ $sound->description }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection