<?php

namespace App\Http\Controllers\API;

use App\Actions\User\UpdateUser;
use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateUserRequest;

class UserController extends Controller
{
    public function update(UpdateUserRequest $request, UpdateUser $updateUser): void
    {
        $updateUser->handle($request->validated());
    }
}
