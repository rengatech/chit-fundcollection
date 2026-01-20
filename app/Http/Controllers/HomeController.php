<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        // Define your plans
        $plans = [
            ['amount' => 300, 'months' => 10, 'total' => 3000],
            ['amount' => 400, 'months' => 10, 'total' => 4000],
            ['amount' => 500, 'months' => 10, 'total' => 5000],
            ['amount' => 750, 'months' => 12, 'total' => 9000],
            ['amount' => 1250, 'months' => 12, 'total' => 15000],
        ];

        // Pass $plans to the view
        return view('Home', compact('plans'));
    }
}
