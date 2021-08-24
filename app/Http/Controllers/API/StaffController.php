<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Table;
use Illuminate\Http\JsonResponse;

class StaffController extends Controller
{
    public function toggle(Table $table) : JsonResponse
    {
        $table->toggleAvailability();

        return response()->success('Successfully changed place availability!');
    }
}
