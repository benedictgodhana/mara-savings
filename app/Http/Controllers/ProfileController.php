<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }


    /**
 * Complete the user profile.
 *
 * @param  \Illuminate\Http\Request  $request
 * @return \Illuminate\Http\Response
 */
public function completeProfile(Request $request)
{
    $user = auth()->user();

    $request->validate([
        'name' => 'required|string|max:255',
        'phone_number' => 'required|string|max:20',
        'national_id' => 'required|string|max:20|unique:users,national_id,' . $user->id,
        'address' => 'required|string|max:255',
        'date_of_birth' => 'required|date|before:today',
        'occupation' => 'required|string|max:255',
        'income_range' => 'required|string|max:20',
        'profile_photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
    ]);

    // Handle profile photo upload
    $profilePhotoPath = $user->profile_photo_path;
    if ($request->hasFile('profile_photo')) {
        // Store the new profile photo
        $profilePhotoPath = $request->file('profile_photo')->store('profile-photos', 'public');

        // Delete the old profile photo if it exists
        if ($user->profile_photo_path && Storage::disk('public')->exists($user->profile_photo_path)) {
            Storage::disk('public')->delete($user->profile_photo_path);
        }
    }

    $user->update([
        'name' => $request->name,
        'phone_number' => $request->phone_number,
        'national_id' => $request->national_id,
        'address' => $request->address,
        'date_of_birth' => $request->date_of_birth,
        'occupation' => $request->occupation,
        'income_range' => $request->income_range,
        'profile_photo_path' => $profilePhotoPath,
        'profile_completed' => true,
    ]);

    return redirect()->back()->with('success', 'Profile updated successfully!');
}
/**
 * Skip the profile completion for now.
 *
 * @return \Illuminate\Http\Response
 */
public function skipProfileCompletion()
{
    // Set a session variable to hide the profile completion prompt for this session
    session(['skip_profile_completion' => true]);

    return redirect()->back();
}
}
