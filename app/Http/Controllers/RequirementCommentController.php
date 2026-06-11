<?php

namespace App\Http\Controllers;

use App\Models\Requirement;
use App\Models\RequirementComment;
use Illuminate\Http\Request;

class RequirementCommentController extends Controller
{
    public function store(Request $request, Requirement $requirement)
    {
        $request->validate([
            'body' => ['required', 'string', 'max:20000'],
        ]);

        $comment = RequirementComment::create([
            'requirement_id' => $requirement->id,
            'user_id' => $request->user()->id,
            'body' => $request->string('body')->toString(),
        ]);

        return back()->with('success', 'Komentar tersimpan.');
    }
}
