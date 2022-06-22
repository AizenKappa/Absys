<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'cin' => "B123456",
            'firstname' => "najil",
            'lastname' => "kamal",
            'email' => 'najil.kamal@ofppt-edu.ma',
            'password' => "anas123",
            'picture_path' => "none",
        ]);

        $path = database_path("absysInsert/sql/insertFile.sql");
        DB::unprepared(file_get_contents($path));
        $this->command->info('Success');
    }
}
