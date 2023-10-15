<?php

namespace App\Services\Deal;

use App\Contracts\Record;
use App\Services\AccessToken;


class DealRecord implements Record
{
    private object $response;


    public function isCreate(): bool {

        $status =
            $this->response->data[0]->status;

        return $status === 'success';
    }

    public function create(array $zohoCRMForm) {

        $accessToken =
            AccessToken::getInfiniteAccessToken();


        $dealCurl = curl_init();

        $zohoCRM = [
            'data' => [
                [
                    'Account_Name' => $zohoCRMForm['Account_name'],
                    'Deal_Name' => $zohoCRMForm['Deal_name'],
                    'Stage' => $zohoCRMForm['Deal_stage'],
                    'Closing_Date' => date('Y-m-d', strtotime($zohoCRMForm['Deal_closing_date'])),
                ]
            ]
        ];

        curl_setopt_array($dealCurl, [
            CURLOPT_URL => 'https://www.zohoapis.eu/crm/v5/Deals',
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_HTTPHEADER => [
                'Authorization: Zoho-oauthtoken ' . $accessToken
            ],
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POSTFIELDS => json_encode($zohoCRM)
        ]);

        $this->response =
            json_decode(curl_exec($dealCurl));

        curl_close($dealCurl);
    }
}
