<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;


class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();
        // Assuming you have methods or models to fetch analytics, activities, etc.
        $activities = $user->activities()->latest()->take(10)->get();
        $analytics = $user->calculateAnalytics();

        return response()->json([
            'user' => $user,
            'activities' => $activities,
            'analytics' => $analytics,
        ]);
    }

    public function updateProfile(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $request->user()->id,
        ]);

        $user = $request->user();
        $user->update($request->all());

        return response()->json(['message' => 'Profile updated successfully']);
    }

    public function changePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|string|min:8|confirmed',
        ]);

        $user = $request->user();
        if (!\Hash::check($request->current_password, $user->password)) {
            return response()->json(['message' => 'Current password is incorrect'], 401);
        }

        $user->password = \Hash::make($request->new_password);
        $user->save();

        return response()->json(['message' => 'Password changed successfully']);
    }
}
