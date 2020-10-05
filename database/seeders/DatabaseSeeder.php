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

        \App\Models\Group::create([ 'name' => 'MDE 2018 Guayaquil P1' ]);
        \App\Models\Group::create([ 'name' => 'MDE 2018 Quito P1' ]);
        \App\Models\Group::create([ 'name' => 'MDE 2018 Guayaquil P2' ]);
        \App\Models\Group::create([ 'name' => 'MDE 2018 Quito P2' ]);
        \App\Models\Group::create([ 'name' => 'MDE 2019 Guayaquil P1' ]);
        \App\Models\Group::create([ 'name' => 'MDE 2019 Quito P1' ]);
        \App\Models\Group::create([ 'name' => 'MDE 2019 Guayaquil P2' ]);
        \App\Models\Group::create([ 'name' => 'MDE 2019 Quito P2' ]);
        \App\Models\Group::create([ 'name' => 'MDE 2020 Guayaquil P1' ]);
        \App\Models\Group::create([ 'name' => 'MDE 2020 Quito P1' ]);
        \App\Models\Group::create([ 'name' => 'MDE 2020 Guayaquil P2' ]);
        \App\Models\Group::create([ 'name' => 'MDE 2020 Quito P2' ]);
        \App\Models\Group::create([ 'name' => 'In-Co Bananeros' ]);
        \App\Models\Group::create([ 'name' => 'In-Co Auacultura' ]);
    }
}
