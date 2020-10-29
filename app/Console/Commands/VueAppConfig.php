<?php

namespace App\Console\Commands;

use App\Http\Controllers\Auth\LoginOAuthController;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class VueAppConfig extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'vue-app:config';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Prepare configuration for vue-app';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        // Client used to login with external oauth
        $clientExternal = DB::table('oauth_clients')->select()->where('name', 'app-oauth')->first();
        if (!$clientExternal) {
            Artisan::call('passport:client', [
                '--personal' => true,
                '--name' => 'app-oauth',
                '--provider' => 'users',
                '--quiet' => true,
            ]);
        }
        // Client used to login by password
        $client = DB::table('oauth_clients')->select()->where('name', 'app')->first();
        if (!$client) {
            Artisan::call('passport:client', [
                '--password' => true,
                '--name' => 'app',
                '--provider' => 'users',
                '--quiet' => true,
            ]);
            $client = DB::table('oauth_clients')->select()->where('name', 'app')->first();
        }
        $before = [];
        foreach (config('plugins.javascript_before') as $javascript) {
            $before[] = env('VUE_APP_SERVER_URL') . "{$javascript}?" . filemtime(public_path($javascript));
        }
        $scripts = [];
        foreach (config('plugins.javascript') as $javascript) {
            $scripts[] = env('VUE_APP_SERVER_URL') . "{$javascript}?" . filemtime(public_path($javascript));
        }
        $styles = [];
        foreach (config('plugins.css') as $css) {
            $styles[] = env('VUE_APP_SERVER_URL') . "{$css}?" . filemtime(public_path($css));
        }
        $config = [
            'translations' => Cache::get('translations'),
            'locale' => app()->getLocale(),
            'providers' => LoginOAuthController::oauthProviders(1, true),
            'styles' => $styles,
            'before' => $before,
            'scripts' => $scripts,
            'client_id' => $client->id,
            'client_secret' => $client->secret,
        ];
        echo json_encode($config);
        return 0;
    }
}
