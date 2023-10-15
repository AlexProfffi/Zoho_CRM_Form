<?php

namespace App\Services\Account;

use App\Contracts\Record;
use App\Services\AccessToken;


class AccountRecord implements Record
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


        $accountCurl = curl_init();

        $zohoCRM = [
            'data' => [
                [
                    'Account_Name' => $zohoCRMForm['Account_name'],
                    'Website' => $zohoCRMForm['Account_website'],
                    'Phone' => $zohoCRMForm['Account_phone'],
                ]
            ]
        ];

        curl_setopt_array($accountCurl, [
            CURLOPT_URL => 'https://www.zohoapis.eu/crm/v5/Accounts',
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_HTTPHEADER => [
                'Authorization: Zoho-oauthtoken ' . $accessToken
            ],
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POSTFIELDS => json_encode($zohoCRM)
        ]);

        $this->response =
            json_decode(curl_exec($accountCurl));

        curl_close($accountCurl);
    }
}
