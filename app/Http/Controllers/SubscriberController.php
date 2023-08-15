<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Subscriber;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class SubscriberController extends Controller
{

    public function create(Request $request)
    {

        $validated = Validator::make($request->all(), [
            'website_id' => ['required', 'integer', 'exists:websites,id'],
            'email' => ['required', 'email', 'max:255', Rule::unique('subscribers', 'email')->where('website_id', $request->input('website_id'))],
        ])->validated();

        Subscriber::create($validated);
        return response()->json(['message' => 'Subscribed successfully'], 201);

    }
}
