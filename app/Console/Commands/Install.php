<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class Install extends Config
{
    /**
     * The name and signature of the console command.
     *
     *
     * @var string
     */
    protected $signature = 'app:install';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Install the application';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        parent::handle();
        if (config('database.default') === 'sqlite'
            && !file_exists(config('database.connections.sqlite.database'))) {
            file_put_contents(config('database.connections.sqlite.database'), '');
        }
        Artisan::call('migrate:fresh', ['--seed' => true]);
    }
}
