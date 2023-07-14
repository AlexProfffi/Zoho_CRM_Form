<?php

namespace App\Http\Controllers;

use Inertia\Inertia;


class WelcomeController extends Controller
{

    public function index() {

        $testString = 'Hello';

        return Inertia::render('Welcome', [
            'testString' => $testString
        ]);
    }
}
