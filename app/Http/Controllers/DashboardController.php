<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        return view('questions.index'); // Ganti 'dashboard' dengan nama view Anda
    }
}
