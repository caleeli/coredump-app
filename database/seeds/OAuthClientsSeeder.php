<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Artisan;

class OAuthClientsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Artisan::call('passport:client', [
            '--personal' => true,
            '--name' => 'app-oauth',
            '--provider' => 'users',
            '--quiet' => true,
        ]);
        Artisan::call('passport:client', [
            '--password' => true,
            '--name' => 'app',
            '--provider' => 'users',
            '--quiet' => true,
        ]);
    }
}
