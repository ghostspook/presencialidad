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

        // Account types
        \App\Models\AccountType::create([ 'name' => 'Alumno', 'default_days_authorization_valid' => 1]);
        \App\Models\AccountType::create([ 'name' => 'Profesor', 'default_days_authorization_valid' => 7]);
        \App\Models\AccountType::create([ 'name' => 'Administrativo', 'default_days_authorization_valid' => 7]);

        // Tracked accounts
        \App\Models\TrackedAccount::create([ 'email' => 'rcastillo@ide.edu.ec', 'account_type_id' => 3]);
        \App\Models\TrackedAccount::create([ 'email' => 'dsusaeta@ide.edu.ec', 'account_type_id' => 2]);
        \App\Models\TrackedAccount::create([ 'email' => 'rmoncayo@ide.edu.ec', 'account_type_id' => 2]);
        \App\Models\TrackedAccount::create([ 'email' => 'avillasis@ide.edu.ec', 'account_type_id' => 2]);
        \App\Models\TrackedAccount::create([ 'email' => 'cnoboa@ide.edu.ec', 'account_type_id' => 3]);
        \App\Models\TrackedAccount::create([ 'email' => 'mtriana@ide.edu.ec', 'account_type_id' => 3]);
        \App\Models\TrackedAccount::create([ 'email' => 'mbustamante@ide.edu.ec', 'account_type_id' => 3]);
        \App\Models\TrackedAccount::create([ 'email' => 'chacay@ide.edu.ec', 'account_type_id' => 3]);
        \App\Models\TrackedAccount::create([ 'email' => 'hcadena@ide.edu.ec', 'account_type_id' => 3]);
        \App\Models\TrackedAccount::create([ 'email' => 'screspo@ide.edu.ec', 'account_type_id' => 3]);

    }
}
