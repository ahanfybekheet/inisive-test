<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Website;
class WebsiteController extends Controller
{
    public function show() {
        // want to paginate the following query
        $websites = Website::paginate(10);

        return response()->json($websites);

    }

}
