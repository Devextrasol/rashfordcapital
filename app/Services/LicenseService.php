<?php

namespace App\Services;

use GuzzleHttp\Client;

class LicenseService
{
    /**
     * Register a license
     *
     * @param $purchaseCode
     * @param $email
     * @return mixed
     */
    public function register($purchaseCode, $email)
    {
        $client = new Client(['base_uri' => 'https://financialplugins.com/api/']);
        $response = $client->request('POST', 'licenses/register', [
            'form_params' => [
                'code' => $purchaseCode,
                'email' => $email,
                
                'hash' => config('app.hash')
            ]
        ]);
      /*{"success":true,"message":"3093f1707ecff40805107d508bf80b6697fa6d24"}*/
        return \GuzzleHttp\json_decode($response->getBody()->getContents());
    }

    /**
     * Save registration data
     *
     * @param $data
     */
    public function save($purchaseCode, $email, $hash)
    {
        $dotEnvService = new DotEnvService();
        if ($env = $dotEnvService->load()) {
            $env['PURCHASE_CODE'] = $purchaseCode;
            $env['SECURITY_HASH'] = $hash;
            $env['LICENSEE_EMAIL'] = $email;
            $dotEnvService->save($env);
        }
    }
}
