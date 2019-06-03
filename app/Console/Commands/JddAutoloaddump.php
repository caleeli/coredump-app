<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Foundation\PackageManifest;
use Illuminate\Support\Facades\Artisan;

class JddAutoloaddump extends Command
{
    /**
     * The name and signature of the console command.
     *
     *
     * @var string
     */
    protected $signature = 'jdd:autoloaddump';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update the installed jdd packages';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle(PackageManifest $manifest)
    {
        $manifest->build();
        dump(array_keys($manifest->manifest));
    }
}
