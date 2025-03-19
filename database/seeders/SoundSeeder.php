<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use \App\Models\Sound;
use \App\Models\Category;


class SoundSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = Category::all();

        $sounds = [
            [
                'title' => 'Kaboom - Roaming Thunder, Lighting Strike at Sea',
                'artist' => 'Artist Studios',
                'duration' => '00:12 / 00:12',
                'category_id' => $categories->where('name', 'Nature')->first()->id,
                'genre' => 'Nature'
            ],
            [
                'title' => 'Air Motion - Thick Short Whoosh',
                'artist' => 'CB Sounddesign',
                'duration' => '00:02 / 00:02',
                'category_id' => $categories->where('name', 'City')->first()->id,
                'genre' => 'City'
            ],
            [
                'title' => 'Downers & Falls - Long Airy Downer',
                'artist' => 'Artist Foley',
                'duration' => '00:08 / 00:08',
                'category_id' => $categories->where('name', 'Fire')->first()->id,
                'genre' => 'Fire'
            ],
            [
                'title' => 'Toony Tunes - Knife Hit and Wobble',
                'artist' => 'Artist Origina',
                'duration' => '00:07 / 00:07',
                'category_id' => $categories->where('name', 'Animals')->first()->id,
                'genre' => 'Animals'
            ],
            [
                'title' => "Cry For Me - The Weeknd",
                'artist' => 'The Weeknd',
                'duration' => '00:48 / 00:48',
                'category_id' => $categories->where('name', 'Music')->first()->id,
                'genre' => 'Music'
            ],
            [
                'title' => "V12 Engine - Ferrari ",
                'artist' => 'Artist Productions',
                'duration' => '00:12 / 00:12',
                'category_id' => $categories->where('name', 'Nature')->first()->id,
                'genre' => 'Car'
            ],
            
        ];

        foreach ($sounds as $sound) {
            Sound::create($sound);
        }
    }
}
