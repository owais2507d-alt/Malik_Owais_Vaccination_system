<?php

namespace Database\Seeders;

use App\Models\Vaccine;
use Illuminate\Database\Seeder;

class VaccineSeeder extends Seeder
{
    public function run(): void
    {
        $vaccines = ['Covaxin', 'Covishield', 'Sputnik V', 'Pfizer', 'Moderna'];

        foreach ($vaccines as $name) {
            Vaccine::create([
                'vaccine_name' => $name,
                'status' => 'available',
            ]);
        }
    }
}
