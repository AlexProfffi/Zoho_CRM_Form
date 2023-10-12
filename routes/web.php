<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ZohoCRMFormController;



// -------- Zoho CRM Form ----------

Route::get('/', function () {

    return redirect()->route('zoho_crm_form');
});


Route::get('/zoho_crm_form', [ZohoCRMFormController::class, 'create'])
    ->name('zoho_crm_form');


