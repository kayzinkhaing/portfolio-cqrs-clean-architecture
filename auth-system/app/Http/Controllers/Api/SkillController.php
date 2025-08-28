<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreSkillRequest;
use App\Http\Requests\UpdateSkillRequest;
use App\Http\Resources\SkillResource;
use App\Models\Skill;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SkillController extends Controller
{
    /**
     * Display a listing of skills.
     */
    public function index()
    {
        // Load skill with its category
        $skills = Skill::with('category')->get();
        return SkillResource::collection($skills);
    }

    /**
     * Store a newly created skill.
     */
    public function store(StoreSkillRequest $request)
    {
        $data = $request->validated();

        // Handle icon file upload
        if ($request->hasFile('icon')) {
            $data['icon'] = $request->file('icon')->store('skills', 'public');
        }

        $skill = Skill::create($data);

        return new SkillResource($skill);
    }

    /**
     * Display the specified skill.
     */
    public function show(Skill $skill)
    {
        $skill->load('category');
        return new SkillResource($skill);
    }

    /**
     * Update the specified skill.
     */
    public function update(UpdateSkillRequest $request, Skill $skill)
    {
        $data = $request->validated();

        // Handle icon update
        if ($request->hasFile('icon')) {
            // Delete old icon if exists
            if ($skill->icon) {
                Storage::disk('public')->delete($skill->icon);
            }
            // Store new icon
            $data['icon'] = $request->file('icon')->store('skills', 'public');
        }

        $skill->update($data);

        return new SkillResource($skill);
    }

    /**
     * Remove the specified skill.
     */
    public function destroy(Skill $skill)
    {
        // Delete icon file if exists
        if ($skill->icon) {
            Storage::disk('public')->delete($skill->icon);
        }

        $skill->delete();

        return response()->json([
            'success' => true,
            'message' => 'Skill deleted successfully'
        ]);
    }
}
