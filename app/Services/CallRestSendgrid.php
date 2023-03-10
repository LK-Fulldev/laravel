<?php

namespace App\Services;

use Exception;
use GuzzleHttp\Client;

class CallRestSendgrid
{
    private function callRestGet($function, $params)
    {
        $requestContent = [
            'headers' => ['X-API-Key' => config('services.sg.key')],
            'query' => $params
        ];

        $client = new \GuzzleHttp\Client();

        try {
            $client = new Client(['verify' => false]);
            $response = $client->request('GET', config('services.sg.url') . $function, $requestContent);
            $result = json_decode($response->getBody()->getContents());

            return response()->json([
                'status' => true,
                'result' => $result,
            ]);
        } catch (Exception $e) {
            return response()->json([
                'status' => false,
                'result' => $e->getMessage(),
            ]);
        }
    }
}
