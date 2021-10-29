<?php

namespace App\Http\Controllers\API;

use App\Actions\Owner\Staff\CreateStaffMember;
use App\Actions\Owner\Staff\UpdateStaffMember;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreStaffMemberRequest;
use App\Http\Requests\ToggleActivityStaffRequest;
use App\Http\Requests\UpdateStaffMemberRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Resources\Json\ResourceCollection;

class StaffController extends Controller
{
    public function index(): ResourceCollection
    {
        return UserResource::collection(
            auth()->user()
                ->staff(request('offset'), request('limit'))
        );
    }

    public function activeIndex(): ResourceCollection
    {
        $activeStaff = User::select('fname', 'lname', 'username', 'avatar', 'active')
            ->wherePlace(auth()->user()->isOwner())
            ->whereActive(true)
            ->get();

        return UserResource::collection($activeStaff);
    }

    public function store(StoreStaffMemberRequest $request, CreateStaffMember $createStaffMember): UserResource
    {
        $createdStaff = $createStaffMember->handle($request->validated());

        return new UserResource($createdStaff);
    }

    public function update(User $staff, UpdateStaffMemberRequest $request, UpdateStaffMember $updateStaffMember): void
    {
        $updateStaffMember->handle($staff, $request->validated());
    }

    public function destroy(User $staff): void
    {
        $staff->delete();
    }

    public function toggle(ToggleActivityStaffRequest $request): void
    {
        $validatedData = $request->validated();

        auth()->user()->update([
            'active' => $validatedData['active'],
        ]);
    }

    //public function inactive(): JsonResponse
    //{
    //    auth()->user()->update([
    //        'active' => false,
    //    ]);
    //
    //    return response()->success('Successfully reported yourself as inactive!');
    //}
}
