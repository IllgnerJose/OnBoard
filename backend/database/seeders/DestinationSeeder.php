<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Destination;

class DestinationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $destinations = [
            ["city" => "Cabo Frio", "state" => "Rio de Janeiro", "country" => "Brasil"],
            ["city" => "Rio de Janeiro", "state" => "Rio de Janeiro", "country" => "Brasil"],
            ["city" => "Búzios", "state" => "Rio de Janeiro", "country" => "Brasil"],
            ["city" => "Paraty", "state" => "Rio de Janeiro", "country" => "Brasil"],
            ["city" => "Angra dos Reis", "state" => "Rio de Janeiro", "country" => "Brasil"],
            
            ["city" => "Belo Horizonte", "state" => "Minas Gerais", "country" => "Brasil"],
            ["city" => "Ouro Preto", "state" => "Minas Gerais", "country" => "Brasil"],
            ["city" => "Tiradentes", "state" => "Minas Gerais", "country" => "Brasil"],
            ["city" => "Uberlândia", "state" => "Minas Gerais", "country" => "Brasil"],
            ["city" => "Juiz de Fora", "state" => "Minas Gerais", "country" => "Brasil"],
            
        ];

        foreach ($destinations as $destination) {
            Destination::create($destination);
        }
    }
}