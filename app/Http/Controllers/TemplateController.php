<?php

namespace App\Http\Controllers;

class TemplateController extends Controller
{
    public function beranda()
    {
        return view('layouts.template');
    }
}
