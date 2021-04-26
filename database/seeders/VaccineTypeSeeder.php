<?php

namespace Database\Seeders;

use App\Models\VaccineType;
use Illuminate\Database\Seeder;

class VaccineTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        VaccineType::create(['name' => 'Pfizer-BioNTech', 'shots_required' => 2, 'days_between_shots' => 21]);
        VaccineType::create(['name' => 'Moderna', 'shots_required' => 2, 'days_between_shots' => 28]);
        VaccineType::create(['name' => 'Johnson & Johnson’s Janssen', 'shots_required' => 1, 'days_between_shots' => 0]);
    }
}
