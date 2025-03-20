@extends('layouts.app')

@section('content')
    <div class="bg-black min-h-screen text-gray-200">
        <div class="container mx-auto px-4 py-8 max-w-6xl">
            <!-- Header with Search -->
            <div class="mb-8">
                <form class="relative mb-6" action="{{route('sounds.index')}}" method="GET">
                    <div class="flex items-center bg-gray-800 rounded-full overflow-hidden pr-2">
                        <input 
                            class="w-full py-3 px-5 bg-gray-800 text-gray-200 placeholder-gray-400 focus:outline-none" 
                            type="text" 
                            name="title" 
                            placeholder="Search for sounds" 
                            value="{{request('title')}}"
                        />
                        <input type="hidden" name="filter" value="{{request('filter')}}" />
                        <button class="p-2 text-gray-400 hover:text-white transition-colors" type="submit">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                        </button>
                        <a href="{{route('sounds.index')}}" class="ml-2 text-sm text-gray-400 hover:text-white transition-colors">
                            Clear
                        </a>
                    </div>
                </form>

                <!-- Category Pills -->
                <div class="flex flex-wrap gap-2 mb-6">
                    @php
                        $filters = [
                            '' => 'All',
                            'nature' =>  'Nature',
                            'city' => 'City',
                            'animals' => 'Animals',
                            'music' => 'Music',
                            'fire' => 'Fire',
                            'car' => 'Car',
                        ];  
                    @endphp
                    @foreach ($filters as $key => $label)
                        <a 
                            class="{{ request('filter') == $key 
                                ? 'bg-green-500 text-white' 
                                : 'bg-gray-800 text-gray-300 hover:bg-gray-700' }} 
                                rounded-full px-4 py-2 text-sm font-medium transition-colors"
                            href="{{ route('sounds.index', ['filter' => $key, 'title'=>request('title')]) }}"
                        >
                            {{ $label }}
                        </a>
                    @endforeach
                </div>
                
                <!-- Add New Sound Button -->
                @can('create-sound')
                    <a href="{{route('sounds.create')}}" class="inline-flex items-center px-4 py-2 bg-green-500 hover:bg-green-600 rounded-full text-white font-medium transition-colors">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                        </svg>
                        Add New Sound
                    </a>
                @endcan
            </div>
            
            <!-- Table Header -->
            <div class="grid grid-cols-12 gap-4 border-b border-gray-800 pb-2 px-4 mb-2 text-gray-400 text-sm">
                <div class="col-span-5">TITLE</div>
                <div class="col-span-4">ARTIST</div>
                <div class="col-span-3 text-right">DURATION</div>
            </div>
            
            <!-- Sounds List -->
            @foreach ($sounds as $sound)
                <div class="group grid grid-cols-12 gap-4 items-center hover:bg-gray-800 rounded-md p-4 transition-colors">
                    <div class="col-span-5">
                        <div class="flex items-center">
                            <!-- Play Button -->
                            <button 
                                onclick="playAudio('audio-{{ $sound->id }}', 'play-icon-{{ $sound->id }}')"
                                class="flex-shrink-0 w-10 h-10 rounded-full bg-gray-700 group-hover:bg-green-500 mr-4 flex items-center justify-center transition-colors"
                            >
                                <i id="play-icon-{{ $sound->id }}" class="fa-solid fa-play text-white"></i>
                            </button>
                            <audio id="audio-{{ $sound->id }}" src="{{ asset('storage/' . $sound->file_path) }}"></audio>
                            
                            <div>
                                <h3 class="font-medium text-white text-base">{{ $sound->title }}</h3>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-span-4">
                        <span class="text-sm">{{ $sound->artist }}</span>
                    </div>
                    
                    <div class="col-span-3 flex items-center justify-end space-x-4">
                        <!-- Duration -->
                        <span id="duration-{{ $sound->id }}" class="text-sm">
                            {{ gmdate('i:s', (int) $sound->duration) }}
                        </span>
                        
                        <!-- Action Icons - Always visible, no opacity transition -->
                        <div class="flex space-x-3">
                            <a href="{{ route('sounds.download', ['id' => $sound->id]) }}" class="text-gray-400 hover:text-white transition-colors" title="Download">
                                <i class="fa-solid fa-download"></i>
                            </a>
                            <a href="{{route('sounds.show', $sound->id)}}" class="text-gray-400 hover:text-white transition-colors" title="View Details">
                                <i class="fa-solid fa-expand"></i>
                            </a>
                            
                            @can('manage-sound', $sound)
                                <div class="relative">
                                    <button 
                                        onclick="toggleDropdown('dropdown-{{ $sound->id }}')"
                                        class="text-gray-400 hover:text-white transition-colors" 
                                        title="More options"
                                    >
                                        <i class="fa-solid fa-ellipsis"></i>
                                    </button>
                                    
                                    <!-- Dropdown Menu -->
                                    <div id="dropdown-{{ $sound->id }}" class="absolute right-0 mt-2 w-48 bg-gray-900 rounded-md shadow-lg overflow-hidden z-10 hidden">
                                        <a href="{{ route('sounds.edit', $sound->id) }}" class="block px-4 py-2 text-sm text-gray-200 hover:bg-gray-800 transition-colors">
                                            <i class="fa-solid fa-edit mr-2"></i> Edit
                                        </a>
                                        <form action="{{ route('sounds.destroy', $sound->id) }}" method="POST" class="block">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="w-full text-left px-4 py-2 text-sm text-red-400 hover:bg-gray-800 transition-colors">
                                                <i class="fa-solid fa-trash mr-2"></i> Delete
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            @endcan
                        </div>
                    </div>
                </div>
            @endforeach
            
            <!-- Empty State -->
            @if(count($sounds) === 0)
                <div class="flex flex-col items-center justify-center py-16 text-gray-500">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zM9 10l12-3" />
                    </svg>
                    <p class="text-lg">No sounds found</p>
                    <p class="text-sm">Try adjusting your search or filters</p>
                </div>
            @endif
        </div>
    </div>
@endsection

@push('scripts')
<script>
    // Close all dropdowns when clicking outside of them
    document.addEventListener('click', function(event) {
        const dropdowns = document.querySelectorAll('[id^="dropdown-"]');
        dropdowns.forEach(dropdown => {
            if (!event.target.closest('button[onclick^="toggleDropdown"]')) {
                dropdown.classList.add('hidden');
            }
        });
    });

    // Toggle dropdown visibility
    function toggleDropdown(dropdownId) {
        event.stopPropagation(); // Prevent the document click handler from immediately closing the dropdown
        const dropdown = document.getElementById(dropdownId);
        
        // Close all other dropdowns
        const dropdowns = document.querySelectorAll('[id^="dropdown-"]');
        dropdowns.forEach(otherDropdown => {
            if (otherDropdown.id !== dropdownId) {
                otherDropdown.classList.add('hidden');
            }
        });
        
        // Toggle the clicked dropdown
        dropdown.classList.toggle('hidden');
    }
</script>
@endpush