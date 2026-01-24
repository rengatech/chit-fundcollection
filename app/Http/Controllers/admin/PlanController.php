<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PlanController extends Controller
{
    public function index()
    {
        $plans = Plan::all();<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Plan; // <-- Import the Plan model

class PlanController extends Controller
{
  public function index() {
    $plans = Plan::all(); // or whatever data you need
    return view('Home', compact('plans'));
}

}

return view('Home')->with('plans', $plans);
    }
}

