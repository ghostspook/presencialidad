<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MandatoryQuarantineController extends Controller
{
    public function index()
    {
        return view('mandatoryquarantine');
    }
}
