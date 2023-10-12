<?php

namespace App\Http\Controllers;

use Inertia\Inertia;


class ZohoCRMFormController extends Controller
{

    public function create() {


        return Inertia::render('ZohoCRMForm');
    }
}
