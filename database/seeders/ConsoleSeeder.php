<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Console;

class ConsoleSeeder extends Seeder
{
    public function run(): void
    {
        $consoles = [
            'NES', 'SNES', 'Game Boy', 'PS1', 'PS2', 'PS3', 'PS4', 'PS5',
            'Xbox', 'Xbox 360', 'Xbox One', 'Xbox Series X'
        ];

        foreach ($consoles as $console) {
            Console::create(['name' => $console]);
        }
    }
}
