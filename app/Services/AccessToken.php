<?php

namespace App\Services;

class AccessToken
{
    public static function getInfiniteAccessToken() {

        $endTime = session('endTime');

        if(now() >= $endTime) {

            self::getAccessToken();

            $endTime = now()->addMinutes(59);
            session(['endTime' => $endTime]);
        }

        return session('accessToken');
    }


    public static function getAccessToken() {

        $accessTokenCurl = curl_init();

        curl_setopt_array( $accessTokenCurl, [
            CURLOPT_URL => 'https://accounts.zoho.eu/oauth/v2/token',
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POSTFIELDS => [
                'refresh_token' => '1000.9bac16954cb1d4f56f5ad56de8f71b58.f25a739bd9438d0c3fdbc1c1c876da7c',
                'client_id' => '1000.IPNZX68YEBGHQ8EXZRPEHL50V8L81L',
                'client_secret' => '37dbd6d354bbd3a72299470424c698f4aee76bbec1',
                'grant_type' => 'refresh_token'
            ]
        ]);

        $accessToken =
            json_decode(curl_exec($accessTokenCurl))->access_token;

        session(['accessToken' => $accessToken]);

        curl_close($accessTokenCurl);
    }
}
