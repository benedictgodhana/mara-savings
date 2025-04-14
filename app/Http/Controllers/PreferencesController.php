<?php

namespace App\Http\Controllers;

use App\Models\UserPreference;
use Illuminate\Http\Request;

class PreferencesController extends Controller
{
    /**
     * Show the user preferences page.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $user = auth()->user();
        $preferences = $user->preferences;

        return view('preferences.index', compact('preferences'));
    }

    /**
     * Update the user's preferences.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request)
    {
        $user = auth()->user();

        // Validate request
        $validated = $request->validate([
            'currency_display' => 'required|string|max:20',
            'date_format' => 'required|string|max:20',
        ]);

        // Get or create user preferences
        $preferences = $user->preferences ?? new UserPreference(['user_id' => $user->id]);

        // Update preferences
        $preferences->update([
            'email_notifications' => $request->has('email_notifications'),
            'sms_notifications' => $request->has('sms_notifications'),
            'marketing_communications' => $request->has('marketing_communications'),
            'currency_display' => $validated['currency_display'],
            'date_format' => $validated['date_format'],
            'dark_mode' => $request->has('dark_mode'),
        ]);

        if (!$user->preferences) {
            $preferences->user_id = $user->id;
            $preferences->save();
        }

        return redirect()->route('profile.show', ['tab' => 'preferences'])
            ->with('success', 'Preferences updated successfully!');
    }

    /**
     * Reset user preferences to defaults.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function reset()
    {
        $user = auth()->user();

        // Define default preferences
        $defaults = [
            'email_notifications' => true,
            'sms_notifications' => false,
            'marketing_communications' => true,
            'currency_display' => 'KES (Kenyan Shilling)',
            'date_format' => 'DD/MM/YYYY',
            'dark_mode' => false,
        ];

        // Update with defaults
        if ($user->preferences) {
            $user->preferences->update($defaults);
        } else {
            $preferences = new UserPreference($defaults);
            $preferences->user_id = $user->id;
            $preferences->save();
        }

        return redirect()->route('profile.show', ['tab' => 'preferences'])
            ->with('success', 'Preferences reset to defaults.');
    }

    /**
     * Toggle a specific preference.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function toggle(Request $request)
    {
        $user = auth()->user();

        $request->validate([
            'preference' => 'required|string|in:email_notifications,sms_notifications,marketing_communications,dark_mode',
        ]);

        $preference = $request->preference;

        // Get or create user preferences
        $preferences = $user->preferences ?? new UserPreference(['user_id' => $user->id]);

        // Toggle the specific preference
        $currentValue = $preferences->$preference ?? false;
        $preferences->$preference = !$currentValue;

        if (!$user->preferences) {
            $preferences->user_id = $user->id;
            $preferences->save();
        } else {
            $preferences->save();
        }

        return response()->json([
            'success' => true,
            'preference' => $preference,
            'value' => $preferences->$preference,
        ]);
    }
}
