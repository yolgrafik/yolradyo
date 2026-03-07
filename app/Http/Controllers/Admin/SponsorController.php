<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

class SponsorController extends Controller
{
    public function index()
    {
        return view('admin.sponsors.index');
    }

    public function create()
    {
        return view('admin.sponsors.create');
    }
}
