<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Skill;

class SkillsController extends Controller
{
    public function addSkill(Request $request, $userId)
    {
        $request->validate([
            'skill_name' => 'required|string|max:255',
        ]);

        $user = User::findOrFail($userId);
        $skill = Skill::firstOrCreate(['name' => $request->input('skill_name')]);

        $user->skills()->attach($skill->id);

        return redirect()->back()->with('success', 'Skill added successfully.');
    }

    public function removeSkill($userId, $skillId)
    {
        $user = User::findOrFail($userId);
        $user->skills()->detach($skillId);

        return redirect()->back()->with('success', 'Skill removed successfully.');
    }

    public function listSkills($userId)
    {
        $user = User::findOrFail($userId);
        $skills = $user->skills;

        return view('user.skills', compact('user', 'skills'));
    }
}
