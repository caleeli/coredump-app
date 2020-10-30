<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Broadcast;

class BroadcastServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // @todo: Move to a single middleware
        $headers = getallheaders();
        if (isset($headers['Authorization'])) {
            Broadcast::routes(['middleware' => ['auth:api']]);
        } else {
            Broadcast::routes();
        }

        require base_path('routes/channels.php');
    }
}
