<?php

namespace App\Http\Controllers;

use App\Models\Group;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class GroupController extends Controller
{
    public function create(Request $request): \Illuminate\Http\RedirectResponse
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'members' => 'array'
        ]);

        $groupData = [
            'name' => $request->name,
            'description' => $request->description,
            'created_by' => Auth::id()
        ];

        // Handle image upload
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('group-images', 'public');
            $groupData['image'] = $imagePath;
        }

        $group = Group::create($groupData);

        // Add creator as admin
        $group->members()->attach(Auth::id(), ['role' => 'admin']);

        // Add other members
        if ($request->members) {
            $uniqueMembers = array_unique($request->members);
            foreach ($uniqueMembers as $memberId) {
                $group->members()->attach($memberId, ['role' => 'member']);
            }
        }

        return redirect()->back()->with('success', 'Group created successfully!');
    }

    public function addMember(Group $group, Request $request): \Illuminate\Http\RedirectResponse
    {
        $request->validate([
            'user_id' => 'required|exists:users,id'
        ]);

        if (!$group->isAdmin(Auth::user())) {
            flash()->error('Only admins can add members. ');
            return redirect()->route('groups');
        }

        if (!$group->members()->where('user_id', $request->user_id)->exists()) {
            $group->members()->attach($request->user_id, ['role' => 'member']);
        }

        flash()->success('Member added successfully.');

        return redirect()->route('groups');
    }

    public function removeMember(Group $group, User $user): \Illuminate\Http\RedirectResponse
    {
        if (!$group->isAdmin(Auth::user()) && Auth::id() !== $user->id) {
            flash()->error('Only admins can remove members. ');
            return redirect()->route('groups');
        }

        if ($group->isAdmin($user) && $group->members()->where('role', 'admin')->count() <= 1) {
            flash()->error('Cannot remove the last admin');
            return redirect()->route('groups');
        }
        $group->members()->detach($user->id);

        flash()->success('Member removed successfully.');

        return redirect()->route('groups');
    }

    public function update(Group $group, Request $request): \Illuminate\Http\RedirectResponse
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'group_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        if (!$group->isAdmin(Auth::user())) {
            flash()->error('Only admins can update group details.');
            return redirect()->route('groups');
        }

        $updateData = [
            'name' => $request->name,
            'description' => $request->description
        ];

        if ($request->hasFile('group_image')) {
            if ($group->image) {
                Storage::disk('public')->delete($group->image);
            }
            $imagePath = $request->file('group_image')->store('group-images', 'public');
            $updateData['image'] = $imagePath;
        }

        $group->update($updateData);

        flash()->success('Group updated successfully.');

        return redirect()->route('groups');
    }

    public function destroy(Group $group): \Illuminate\Http\RedirectResponse
    {
        if (!$group->isAdmin(Auth::user())) {
            flash()->error('Only admins can delete groups.');
            return redirect()->route('groups');
        }

        if ($group->image) {
            Storage::disk('public')->delete($group->image);
        }

        $group->delete();

        flash()->success('Group deleted successfully.');

        return redirect()->route('groups');
    }
}
