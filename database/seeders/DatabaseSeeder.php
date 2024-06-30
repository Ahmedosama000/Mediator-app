<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Carbon\Carbon;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    /**
     * Run the database seeds.
     *
     * @return void
     */
    /*public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
        //\App\Models\Post::factory(120)->create();
    }*/

    public function run()
    {
        DB::table('users_posts')->insert([
            'title' => Str::random(10),
            'content' => Str::random(50),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
    }

}
