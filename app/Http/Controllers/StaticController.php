<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;

class StaticController extends Controller
{
    public function Welcome(): Factory|View|Application
    {
        return view('welcome');
    }

    public function Home(): Factory|View|Application
    {
        return view('home');
    }
}
