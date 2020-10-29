<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class LoginOAuthController extends Controller
{
    protected $redirectTo = '/home#/';

    /**
     * Get OAuth login providers
     *
     * @param integer $columns
     *
     * @return array
     */
    public static function oauthProviders($columns = 1, $includeProviderUrl = false)
    {
        $providers = [];
        $i = -1;
        foreach (config('services') as $key => $provider) {
            if (isset($provider['client_id'])
                && isset($provider['client_secret'])
                && isset($provider['redirect'])
            ) {
                $provider['key'] = $key;
                if ($includeProviderUrl) {
                    $provider['url'] = self::getLinkToProvider($key);
                }
                if ($columns > 1) {
                    if (!isset($providers[$i]) || count($providers[$i]) === $columns) {
                        $i++;
                        $providers[$i] = [];
                    }
                    $providers[$i][] = $provider;
                } else {
                    $providers[] = $provider;
                }
            }
        }
        return $providers;
    }

    /**
     * Redirect the user to the GitHub authentication page.
     *
     * @return \Illuminate\Http\Response
     */
    public function redirectToProvider($provider)
    {
        return Socialite::driver($provider)->stateless()->redirect();
    }

    private static function getLinkToProvider($provider)
    {
        $url = Socialite::driver($provider)->stateless()->redirect()->getTargetUrl();
        return $url;
    }

    /**
     * Obtain the user information from GitHub.
     *
     * @return \Illuminate\Http\Response
     */
    public function handleProviderCallback(Request $request, $provider)
    {
        try {
            $providerUser = Socialite::driver($provider)->stateless()->user();
            $user = User::where('provider', $provider)
            ->where('provider_id', $providerUser->getId())
            ->first();
            if ($user) {
                Auth::login($user);
            } else {
                $user = User::create([
                    'name' => $providerUser->getName(),
                    'email' => $providerUser->getEmail(),
                    'avatar' => ['url' => $providerUser->getAvatar()],
                    'role' => 'user',
                    'provider' => $provider,
                    'provider_id' => $providerUser->getId(),
                ]);
                Auth::login($user);
            }
        } catch (\Throwable $tt) {
            dump($tt->getMessage());
        }
        return view('auth.logged_in', [
            'response' => [
                'token' => $user->createToken('app')->accessToken,
                'user' => [
                    'attributes' => $user->toArray(),
                ],
                'broadcaster' => [
                    'broadcaster' => 'socket.io',
                    'host' => env('BROADCASTER_HOST'),
                    'key' => env('BROADCASTER_KEY'),
                ],
                'menus' => $user->allMenus(),
            ],
            'redirectTo' => $this->redirectTo,
        ]);
    }

    public function userinfo()
    {
        $user = Auth::user();
        return response()->json([
            'user' => [
                'attributes' => $user->toArray(),
            ],
            'broadcaster' => [
                'broadcaster' => 'socket.io',
                'host' => env('BROADCASTER_HOST'),
                'key' => env('BROADCASTER_KEY'),
            ],
            'menus' => $user->allMenus(),
        ]);
    }
}
