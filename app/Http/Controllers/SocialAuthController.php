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
use Laravel\Fortify\Contracts\LoginResponse;
use Laravel\Socialite\Facades\Socialite;
use Symfony\Component\HttpFoundation\RedirectResponse;

class SocialAuthController extends Controller
{
    /*
     * Provider finished and is returning response
    */
    public function providerResponse(Request $request)
    {
        $providerUser = $request->only(['fname', 'lname', 'email', 'avatar', 'provider_id']);

        $user = (new SocialAuthService())->createOrGetUser($providerUser);

        Auth::login($user);

        return app(LoginResponse::class);
    }
}
