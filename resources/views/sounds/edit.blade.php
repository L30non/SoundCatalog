@extends('layouts.app')

@section('content')


@foreach ($sounds as $sound)
    <div class="bg-black min-h-screen text-gray-200">
        <div class="container mx-auto max-w-2xl px-4 py-12">
            <!-- Header -->
            <div class="mb-8">
                <h1 class="text-3xl font-bold text-white mb-2">Edit your sound</h1>
                <p class="text-gray-400">Share your audio with the world</p>
            </div>
            
            <!-- Form -->
            <form action="{{ route('sounds.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                @csrf
                
                <!-- Title -->
                <div>
                    <label for="title" class="block text-sm font-medium text-gray-300 mb-1">Title</label>
                    <input 
                        type="text" 
                        id="title" 
                        name="title" 
                        required
                        placeholder="Enter sound title"
                        class="w-full px-4 py-3 bg-gray-800 border border-gray-700 rounded-md text-white placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent transition-colors"
                        $sounds->title
                    >
                </div>
                
                <!-- Artist -->
                <div>
                    <label for="artist" class="block text-sm font-medium text-gray-300 mb-1">Artist</label>
                    <input 
                        type="text" 
                        id="artist" 
                        name="artist" 
                        required
                        placeholder="Artist name"
                        class="w-full px-4 py-3 bg-gray-800 border border-gray-700 rounded-md text-white placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent transition-colors"
                    >
                </div>
                
                <!-- Two-column layout for Genre and Duration -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Genre -->
                    <div>
                        <label for="genre" class="block text-sm font-medium text-gray-300 mb-1">Genre</label>
                        <input 
                            type="text" 
                            id="genre" 
                            name="genre" 
                            required
                            placeholder="e.g. Rock, Jazz, Ambient"
                            class="w-full px-4 py-3 bg-gray-800 border border-gray-700 rounded-md text-white placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent transition-colors"
                        >
                    </div>
                    
                    <!-- Duration -->
                    <div>
                        <label for="duration" class="block text-sm font-medium text-gray-300 mb-1">Duration</label>
                        <input 
                            type="text" 
                            id="duration" 
                            name="duration" 
                            value="00:00"
                            placeholder="00:00"
                            class="w-full px-4 py-3 bg-gray-800 border border-gray-700 rounded-md text-white placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent transition-colors"
                        >
                    </div>
                </div>
                
                <!-- Description -->
                <div>
                    <label for="description" class="block text-sm font-medium text-gray-300 mb-1">Description</label>
                    <textarea 
                        id="description" 
                        name="description" 
                        rows="3" 
                        placeholder="Add some details about your sound..."
                        class="w-full px-4 py-3 bg-gray-800 border border-gray-700 rounded-md text-white placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent transition-colors resize-none"
                    ></textarea>
                </div>
                
                <!-- Category -->
                <div>
                    <label for="category_id" class="block text-sm font-medium text-gray-300 mb-1">Category</label>
                    <select 
                        id="category_id" 
                        name="category_id" 
                        required
                        class="w-full px-4 py-3 bg-gray-800 border border-gray-700 rounded-md text-white appearance-none focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent transition-colors"
                    >
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                        @endforeach
                    </select>
                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                        <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                            <path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/>
                        </svg>
                    </div>
                </div>
                
                <!-- Upload Files Section -->
                <div class="pt-4 border-t border-gray-800">
                    <h2 class="text-xl font-semibold text-white mb-4">Media Files</h2>
                    
                    <!-- Sound File -->
                    <div class="mb-6">
                        <label for="file_path" class="block text-sm font-medium text-gray-300 mb-2">Sound File</label>
                        <div class="flex items-center justify-center w-full">
                            <label for="file_path" class="flex flex-col items-center justify-center w-full h-32 border-2 border-gray-700 border-dashed rounded-lg cursor-pointer hover:bg-gray-800 transition-colors">
                                <div class="flex flex-col items-center justify-center pt-5 pb-6">
                                    <svg class="w-8 h-8 mb-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zM9 10l12-3"></path>
                                    </svg>
                                    <p class="mb-1 text-sm text-gray-400"><span class="font-semibold">Click to upload</span> or drag and drop</p>
                                    <p class="text-xs text-gray-500">MP3, WAV, or OGG (MAX. 10MB)</p>
                                </div>
                                <input id="file_path" name="file_path" type="file" class="hidden" required />
                            </label>
                        </div>
                    </div>
                    
                    <!-- Cover Image -->
                    <div>
                        <label for="image_path" class="block text-sm font-medium text-gray-300 mb-2">Cover Image</label>
                        <div class="flex items-center justify-center w-full">
                            <label for="image_path" class="flex flex-col items-center justify-center w-full h-32 border-2 border-gray-700 border-dashed rounded-lg cursor-pointer hover:bg-gray-800 transition-colors">
                                <div class="flex flex-col items-center justify-center pt-5 pb-6">
                                    <svg class="w-8 h-8 mb-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                    <p class="mb-1 text-sm text-gray-400"><span class="font-semibold">Click to upload</span> or drag and drop</p>
                                    <p class="text-xs text-gray-500">JPG, PNG or GIF (MAX. 2MB)</p>
                                </div>
                                <input id="image_path" name="image_path" type="file" class="hidden" required />
                            </label>
                        </div>
                    </div>
                </div>
                
                <!-- Submit Button -->
                <div class="pt-6">
                    <button 
                        type="submit" 
                        class="w-full py-3 px-4 bg-green-500 hover:bg-green-600 rounded-full text-white font-medium transition-colors focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500"
                    >
                        Upload Sound
                    </button>
                </div>
            </form>
        </div>
    </div>
@endforeach
@endsection