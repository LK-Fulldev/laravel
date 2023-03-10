<?php

namespace App\Http\Controllers;

use Exception;
use SendGrid;
use GuzzleHttp\Client;
use App\Helper\MailHelper;
use App\Mail\TestMailSendGrid;
use App\Models\SendgridOverview;
use Illuminate\Http\Request;

class EmailController extends Controller
{
    public function CallRestApiMailer(Request $request)
    {
        try {
            $subject = $request->input('subject');
            $description = $request->input('description');
            MailHelper::sendMail($request, new TestMailSendGrid($subject, $description));
            return [
                'status' => true,
                'message' => "Your mail has been sent successfully."
            ];
        } catch (Exception $e) {
            return [
                'status' => false,
                'message' => $e->getMessage(),
                'line' => $e->getLine(),
            ];
        }
    }

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
}
