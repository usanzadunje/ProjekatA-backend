<?php

namespace App\Http\Controllers\API;

use App\Actions\User\UpdateUser;
use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateUserRequest;
use Illuminate\Http\JsonResponse;

class UserController extends Controller
{
    public function update(UpdateUserRequest $request, UpdateUser $updateUser)
    {
        $updateUser->handle($request->validated());

        return response()->json([
            'success' => 'Successfully updated user profile.',
        ]);
    }
}
