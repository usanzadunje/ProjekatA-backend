<?php

namespace App\Http\Controllers\API;

use App\Actions\User\UpdateUser;
use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateUserRequest;
use Illuminate\Http\JsonResponse;

class UserController extends Controller
{
    public function update(UpdateUserRequest $request, UpdateUser $updateUser): JsonResponse
    {
        $updateUser->handle($request->validated());

        return response()->success('Successfully updated users profile.');
    }
}
