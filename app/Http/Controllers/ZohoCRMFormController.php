<?php

namespace App\Http\Controllers;

use App\Services\Account\AccountRecord;
use App\Services\Deal\DealRecord;
use Illuminate\Http\Request;
use Inertia\Inertia;



class ZohoCRMFormController extends Controller
{

    public function __construct(
        public AccountRecord $accountRecord,
        public DealRecord $dealRecord,
    ){}


    public function create() {

        $message =
            session()->only(['success', 'account_error', 'deal_error']);


        return Inertia::render('ZohoCRMForm', [
            'message' => $message
        ]);
    }


    public function store(Request $request) {

        $zohoCRMForm = $request->all();


        $this->accountRecord->create($zohoCRMForm);

        if($this->accountRecord->isCreate()) {

            $this->dealRecord->create($zohoCRMForm);

            if($this->dealRecord->isCreate()) {
                return back()->with('success', 'The Account And Deal Created Successfully');
            }
            else
                return back()->with('deal_error', 'The Deal Was Not Created');
        }
        else
            return back()->with('account_error', 'The Account Was Not Created');

    }
}
