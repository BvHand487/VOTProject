<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Group;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            UserSeeder::class,
            GroupSeeder::class,
        ]);

        $groups = Group::all();

        User::all()->each(function($user) use ($groups) {
            $user->groups()->attach(
                $groups->random(rand(1, $groups->count()))->pluck("id")->toArray()
            );
        });
    }
}
