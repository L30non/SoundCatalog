<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased bg-black">
        <div class="min-h-screen">
            @include('layouts.navigation')

            <!-- Page Content -->
            <main>
                @yield('content')
            </main>
        </div>
        <script>
            let currentlyPlaying = null;
        
            function playAudio(audioId, iconId, durationId) {
                const audioElement = document.getElementById(audioId);
                const playIcon = document.getElementById(iconId);
                const durationElement = document.getElementById(durationId);
        
                if (!audioElement) {
                    console.error("Audio element not found:", audioId);
                    return;
                }
        
                // Stop any currently playing audio
                if (currentlyPlaying && currentlyPlaying !== audioElement) {
                    currentlyPlaying.pause();
                    currentlyPlaying.currentTime = 0; // Reset to start
                    updateDurationCountdown(currentlyPlaying, document.getElementById('duration-' + currentlyPlaying.id.split('-')[1]));
                    
                    const previousIcon = document.querySelector('.fa-pause');
                    if (previousIcon) {
                        previousIcon.classList.remove('fa-pause');
                        previousIcon.classList.add('fa-play');
                    }
                }
        
                if (audioElement.paused) {
                    audioElement.play();
                    playIcon.classList.remove('fa-play');
                    playIcon.classList.add('fa-pause');
                    currentlyPlaying = audioElement;
                    updateDurationCountdown(audioElement, durationElement);
                } else {
                    audioElement.pause();
                    playIcon.classList.remove('fa-pause');
                    playIcon.classList.add('fa-play');
                    currentlyPlaying = null;
                }
            }
        
            function updateDurationCountdown(audioElement, durationElement) {
                const update = () => {
                    if (audioElement.ended) {
                        durationElement.textContent = formatTime(0); // Reset when finished
                        return;
                    }
                    const remainingTime = audioElement.duration - audioElement.currentTime;
                    durationElement.textContent = formatTime(remainingTime);
                    if (!audioElement.paused && !audioElement.ended) {
                        requestAnimationFrame(update);
                    }
                };
                requestAnimationFrame(update);
            }
        
            function formatTime(seconds) {
                if (isNaN(seconds) || seconds < 0) return '0:00'; 
                const minutes = Math.floor(seconds / 60);
                const secs = Math.floor(seconds % 60);
                return `${minutes}:${secs < 10 ? '0' : ''}${secs}`;
            }
        
            document.addEventListener('DOMContentLoaded', function() {
                document.querySelectorAll('audio[id^="audio-"]').forEach(audio => {
                    const audioId = audio.id;
                    const durationId = 'duration-' + audioId.split('-')[1];
                    const durationElement = document.getElementById(durationId);
        
                    if (!audio || !durationElement) return;
                    durationElement.textContent = formatTime(audio.duration);
                    // Set duration once metadata is loaded
                    audio.addEventListener('loadedmetadata', function() {
                        durationElement.textContent = formatTime(audio.duration);
                    });

       
                    audio.addEventListener('timeupdate', function() {
                        const remainingTime = audio.duration - audio.currentTime;
                        durationElement.textContent = formatTime(remainingTime);
                    });
                });
            });
        </script>
        @stack('scripts')
    </body>
</html>
