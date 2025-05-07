<?php

namespace App\Http\Controllers;

use App\Models\Listing;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class IndexController extends Controller
{
    public function index()
    {
        // return "Index";
        // dd(Auth::user());
        return inertia('Index/Index', [
            'message' => 'Hello Index'
        ]);
    }

    public function show()
    {
        // return "Show";
        return inertia('Index/Show');
    }
}
