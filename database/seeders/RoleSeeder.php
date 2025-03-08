<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = [
            ['name' => 'customer'],
            ['name' => 'business_admin'],
            ['name' => 'employee'],
            ['name' => 'developer'],
        ];

        DB::table('roles')->insert($roles);
    }
}