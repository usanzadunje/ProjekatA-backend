<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;
use App\Models\CafeUser;
use App\Models\User;
use App\Services\SocialAuthService;
use App\Services\StoreAvatarService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Laravel\Socialite\Facades\Socialite;
use Symfony\Component\HttpFoundation\RedirectResponse;

class SocialAuthController extends Controller
{
    /*
     * Redirecting to auth service provider
    */
    public function redirectToProvider(string $driver): RedirectResponse
    {
        return Socialite::driver($driver)->stateless()->redirect();
    }

    /*
     * Provider finished and is returning response
    */
    public function providerResponse(string $driver)
    {
        $user = (new SocialAuthService())->createOrGetUser(Socialite::driver($driver)->stateless()->user());

        Auth::login($user);

        return auth()->user();
    }
}
