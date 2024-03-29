<?php

namespace Database\Seeders;

use App\Models\Duration;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Absysyear;
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
        Absysyear::create([
            'year' => '2021-2022',
            'current' => true
        ]);

        User::create([
            'cin' => "B123456",
            'firstname' => "najil",
            'lastname' => "kamal",
            'email' => 'najil.kamal@ofppt-edu.ma',
            'year' => 1,
            'password' => "anas123",
            'role' => "admin"
        ]);
        
        Duration::create([
            'title'=>"Toute la Journée",
            "h_debut"=>"08:30:00",
            "h_fin"=>"18:30:00",
            "active" => "on"
        ]);

        Duration::create([
            'title'=>"La matinée",
            "h_debut"=>"08:30:00",
            "h_fin"=>"13:30:00",
            "active" => "on"
        ]);
        Duration::create([
            'title'=>"L'après-midi",
            "h_debut"=>"13:30:00",
            "h_fin"=>"18:30:00",
            "active" => "on"
        ]);
        

        Duration::create([
            'title'=>"La Première Séance",
            "h_debut"=>"08:30:00",
            "h_fin"=>"11:00:00",
            "active" => "on"
        ]);
        Duration::create([
            'title'=>"La Deuxième Séance",
            "h_debut"=>"11:00:00",
            "h_fin"=>"13:30:00",
            "active" => "on"
        ]);
        Duration::create([
            'title'=>"La Troisième Séance",
            "h_debut"=>"13:30:00",
            "h_fin"=>"16:00:00",
            "active" => "on"
        ]);
        Duration::create([
            'title'=>"La Quatrième Séance",
            "h_debut"=>"16:00:00",
            "h_fin"=>"18:30:00",
            "active" => "on"
        ]);
        


        Duration::create([
            'title'=>"Toute la Journée",
            "h_debut"=>"08:30:00",
            "h_fin"=>"16:30:00",
            "active" => "off"
        ]);

        Duration::create([
            'title'=>"La matinée",
            "h_debut"=>"08:30:00",
            "h_fin"=>"12:30:00",
            "active" => "off"
        ]);
        Duration::create([
            'title'=>"L'après-midi",
            "h_debut"=>"12:30:00",
            "h_fin"=>"16:30:00",
            "active" => "off"
        ]);
        

        Duration::create([
            'title'=>"La Première Séance",
            "h_debut"=>"08:30:00",
            "h_fin"=>"10:30:00",
            "active" => "off"
        ]);
        Duration::create([
            'title'=>"La Deuxième Séance",
            "h_debut"=>"10:30:00",
            "h_fin"=>"12:30:00",
            "active" => "off"
        ]);
        Duration::create([
            'title'=>"La Troisième Séance",
            "h_debut"=>"12:30:00",
            "h_fin"=>"14:30:00",
            "active" => "off"
        ]);
        Duration::create([
            'title'=>"La Quatrième Séance",
            "h_debut"=>"14:30:00",
            "h_fin"=>"16:30:00",
            "active" => "off"
        ]);



/*         $path = database_path("sql/data.sql");
        DB::unprepared(file_get_contents($path)); */
        $this->command->info('Success');
    }
}
