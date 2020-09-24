<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class EnrollmentController extends Controller
{
    public function index()
    {
        return view('enroll');
    }

    public function enrollSubmit(Request $request)
    {
        $inputs = $request->all();
        if (array_key_exists('acceptance', $inputs))
        {
            dd('Todo ok');
        }
        else
        {
            return redirect()->back()->withErrors(['acceptance' => 'Debe aceptar los términos y condiciones para poder continuar.']);
        }

    }
}
