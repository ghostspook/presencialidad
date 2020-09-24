<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        \App\Models\AccountType::create([ 'name' => 'Alumno', 'default_days_authorization_valid' => 1]);
        \App\Models\AccountType::create([ 'name' => 'Profesor', 'default_days_authorization_valid' => 7]);
        \App\Models\AccountType::create([ 'name' => 'Administrativo', 'default_days_authorization_valid' => 7]);
    }
}
