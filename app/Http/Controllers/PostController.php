<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use Illuminate\Support\Facades\Validator;

class PostController extends Controller
{
    public function create(Request $request)
    {
        $validated = Validator::make($request->all(), [
            'website_id' => ['required', 'integer', 'exists:websites,id'],
            'title' => ['required', 'string', 'max:255'],
            'description' => ['required','string','max:3000'],
        ])->validated();

        Post::create($validated);
        
        return response()->json(['message' => 'Post created successfully'], 201);

    }
}
