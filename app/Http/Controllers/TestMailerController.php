<?php

namespace App\Http\Controllers;

use SendGrid;

use Exception;
use GuzzleHttp\Client;
use App\Helper\MailHelper;
use Illuminate\Http\Request;
use App\Mail\TestMailSendGrid;
use App\Models\SendgridOverview;
use Illuminate\Auth\Events\Failed;
use Illuminate\Support\Facades\Http;

class TestMailerController extends Controller
{
    public function CallRestSendgrid(Request $request)
    {
        $getCurrentOverview = SendgridOverview::query();
        $getCurrentOverview->orderBy('date_current', 'desc');
        $getCurrentOverview = $getCurrentOverview->first();

        $startDate = "2023-01-01";
        $endDate = "2023-12-01";

        if ($getCurrentOverview) {
            $startDate = $getCurrentOverview->date_current;
            $endDate = date('Y-m-d');
        }

        $sg = new SendGrid(config('services.sg.key'));
        $queryParams = json_encode([
            "start_date" => $startDate,
            "end_date" => $endDate,
            "aggregated_by" => "day"
        ]);

        try {
            $response = $sg->client->stats()->get(null, json_decode($queryParams));
            $resutl = json_decode($response->body());
            foreach ($resutl as $value) {
                print_r($value);
                exit;
                foreach ($value->stats as $subValue) {
                    try {
                        // Insert Data Form Sendgrid
                        $metricsConvertData = json_decode(json_encode($subValue->metrics), true);
                        SendgridOverview::create($metricsConvertData + ['date_current' => $value->date]);
                    } catch (\Exception $e) {
                        echo "\n[Error] Get Data form stats" . $e->getMessage() . 'Linel:' . $e->getLine();
                    }
                }
            }
            return response()->json([
                'status' => true,
                'message' => "Success"
            ]);
        } catch (Exception $ex) {
            return response()->json([
                'status' => false,
                'message' => 'Caught exception: ' .  $ex->getMessage()
            ]);
        }
    }

    public function CallRestMailtrap(Request $request)
    {
        $client = new Client([
            'base_uri' => 'https://mailtrap.io',
            'headers' => [
                'Api-Token' => '7130386734f45a'
            ]
        ]);

        $response = $client->get("/api/v1/inboxs/2126112/statistics");

        $statistics = json_decode($response->getBody(), true);

        print_r($statistics);
        exit;

    }
}
