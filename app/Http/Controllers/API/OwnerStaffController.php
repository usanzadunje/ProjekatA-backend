<?php

namespace App\Http\Controllers\API;

use App\Actions\Owner\Place\UpdatePlaceInfo;
use App\Actions\Owner\Place\UploadPlaceImages;
use App\Actions\Owner\Staff\CreateStaffMember;
use App\Actions\Owner\Staff\UpdateStaffMember;
use App\Http\Controllers\Controller;
use App\Http\Requests\CreateStaffMemberRequest;
use App\Http\Requests\UpdatePlaceRequest;
use App\Http\Requests\UpdateStaffMemberRequest;
use App\Http\Requests\UploadPlaceImagesRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Validation\UnauthorizedException;

class OwnerStaffController extends Controller
{

}
