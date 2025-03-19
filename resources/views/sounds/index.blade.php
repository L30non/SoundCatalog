@extends('layouts.app')

@section('content')
    
    <div class="container mt-5 mx-auto">
        {{-- <h1 class="mb-4 text-2xl font-bold">Sounds</h1> --}}
        <form class="mb-4 flex items-center justify-center space-x-2" action="{{route('sounds.index')}}" method="GET">
            <input class="border-3 bg-white rounded-lg h-10 w-full border-black focus:ring" type="text" name="title" placeholder="Search by Title" value=""/>
            <input type="hidden" name="filter" value="{{request('filter')}}" />
            <button class="btn border-3 text-white" type="submit">Search</button>
            <a class="btn text-white" href="{{route('sounds.index')}}">Clear</a>
        </form>

        <div class="mb-4 flex space-x-2 rounded-md bg-gray-900 p-2">
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
                <a class=" {{ request('filter') == $key ? 
                    'flex w-full items-center justify-center rounded-md px-4 py-2 text-center text-lg font-medium bg-white text-black no-underline' 
                    :'bg-black text-white shadow-sm flex w-full items-center justify-center rounded-md px-4 py-2 text-center text-sm font-medium no-underline' }}"
                     href="{{ route('sounds.index', ['filter' => $key,'title'=>request('title')]) }}">
                    {{ $label }}
                </a>
            @endforeach
            

        </div>

        <a class="btn mb-6" href="{{route('sounds.create')}}"><i class="fa-solid fa-plus " style="color: #ffffff;"> Add New Sound</i></a>

        @foreach ($sounds as $sound)
            <div class="sound-item mt-4 p-3 border w-full rounded">
                <div class="flex flex-inline justify-between align-items-center">
                    <div class="text-white">
                        <h5 class="mb-1">{{ $sound->title }}</h5>
                        <p class="mb-0 ">{{ $sound->artist }}</p>
                    </div>
                    <div class="  text-white mt-3  ">
                        <span id="duration-{{ $sound->id }}">
                            {{ gmdate('i:s', (int) $sound->duration) }}
                        </span>
                        <i id="play-icon-{{ $sound->id }}" class="fa-solid fa-play mx-7" 
                           onclick="playAudio('audio-{{ $sound->id }}', 'play-icon-{{ $sound->id }}')"></i>
                        <audio id="audio-{{ $sound->id }}" src="{{ asset('storage/' . $sound->file_path) }}"></audio> 
                        <a href="{{ route('sounds.download', ['id' => $sound->id]) }}" class="fa-solid fa-download mr-7"></a> 
                        <a href="{{route('sounds.show',$sound->id)}}"><i class="fa-solid fa-expand"></i></a>                     
                    </div>
                </div>
                @can('manage-sound', $sound)
                    <div class="flex space-x-2">
                        <a href="{{ route('sounds.edit', $sound->id) }}" class="btn btn-primary">Edit</a>
                        <form action="{{ route('sounds.destroy', $sound->id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Delete</button>
                        </form>
                    </div>
                @endcan
            </div>
        @endforeach
    </div>
@endsection

