@extends('layouts.app')

@section('content')
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
                <p class="text-sm text-gray-400">{{ $sound->artist }}</p>
            </div>
        </div>
    </div>
    
    <div class="col-span-4">
        @if(isset($sound->name))
        <span class="text-sm text-gray-400">{{ $sound->name }}</span>
        @endif
    </div>
    
    <div class="col-span-3 flex items-center justify-end space-x-4">
        <!-- Duration -->
        <span id="duration-{{ $sound->id }}" class="text-sm text-gray-400">
            {{ gmdate('i:s', (int) $sound->duration) }}
        </span>
        
        <!-- Action Icons - Always visible -->
        <div class="flex space-x-3">
            <a href="{{ route('sounds.download', ['id' => $sound->id]) }}" class="text-gray-400 hover:text-white transition-colors" title="Download">
                <i class="fa-solid fa-download"></i>
            </a>
            <a href="{{route('sounds.show', $sound->id)}}" class="text-gray-400 hover:text-white transition-colors" title="View Details">
                <i class="fa-solid fa-expand"></i>
            </a>
            
            <!-- Admin Actions Dropdown -->
            @if(isset($sound->name))
            <div class="relative">
                <button 
                    onclick="toggleDropdown('admin-dropdown-{{ $sound->id }}')"
                    class="text-gray-400 hover:text-white transition-colors" 
                    title="Admin Actions"
                >
                    <i class="fa-solid fa-ellipsis"></i>
                </button>
                
                <!-- Dropdown Menu -->
                <div id="admin-dropdown-{{ $sound->id }}" class="absolute right-0 mt-2 w-48 bg-gray-900 rounded-md shadow-lg overflow-hidden z-10 hidden">
                    <form action="{{ route('admin.sounds.approve', $sound->id) }}" method="GET" class="block">
                        @csrf
                        <button type="submit" class="w-full text-left px-4 py-2 text-sm text-green-400 hover:bg-gray-800 transition-colors">
                            <i class="fa-solid fa-check mr-2"></i> Approve
                        </button>
                    </form>
                    <form action="{{ route('sounds.destroy', $sound->id) }}" method="POST" class="block">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="w-full text-left px-4 py-2 text-sm text-red-400 hover:bg-gray-800 transition-colors">
                            <i class="fa-solid fa-times mr-2"></i> Deny
                        </button>
                    </form>
                </div>
            </div>
            @endif
            
            <!-- Regular User Dropdown (if needed) -->
            @if(!isset($sound->name))
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
                    <a href="{{ route('admin.sounds.approve', $sound->id) }}" class="block px-4 py-2 text-sm text-gray-200 hover:bg-gray-800 transition-colors">
                        <i class="fa-solid fa-thumbs-up mr-2"></i> Approve
                    </a>
                    <form action="{{ route('sounds.destroy', $sound->id) }}" method="POST" class="block">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="w-full text-left px-4 py-2 text-sm text-red-400 hover:bg-gray-800 transition-colors">
                            <i class="fa-solid fa-thumbs-down mr-2"></i> Deny
                        </button>
                    </form>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>
@endforeach
@endsection

@push('scripts')
<script>
    // Close all dropdowns when clicking outside of them
    document.addEventListener('click', function(event) {
        const dropdowns = document.querySelectorAll('[id^="dropdown-"], [id^="admin-dropdown-"]');
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
        const dropdowns = document.querySelectorAll('[id^="dropdown-"], [id^="admin-dropdown-"]');
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