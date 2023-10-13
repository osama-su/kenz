<?php

namespace Database\Seeders;

use App\HelperClasses\RolesHelper;
use Illuminate\Database\Seeder;

class RolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        RolesHelper::CreateRole('admin', RolesHelper::GetModels('company'));

    }
}
