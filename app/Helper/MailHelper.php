<?php

namespace App\Helper;

use App\Models\MailHistory;
use Swift_TransportException;
use App\Mail\TestMailSendGrid;
use Exception;
use Illuminate\Support\Facades\Mail;

class MailHelper
{
    public function sendMail($request, $body)
    {
        try {
            Mail::to($request->email)->send($body);
            $mailHisttory = new MailHistory;
            $mailHisttory->email = $request->email;
            $mailHisttory->subject = $request->input('subject');
            $mailHisttory->description = $request->input('description');
            $mailHisttory->status = 1;
            $mailHisttory->email_providers = 'mailtrap';
            $mailHisttory->save();

            return [
                'status' => true,
                'message' => "Your mail has been sent successfully."
            ];
        } catch (Swift_TransportException $e) {

            $mailHisttory = new MailHistory;
            $mailHisttory->email = $request->email;
            $mailHisttory->subject = $request->input('subject');
            $mailHisttory->description = $request->input('description');
            $mailHisttory->status = 0;
            $mailHisttory->email_providers = 'mailtrap';
            $mailHisttory->logs = $e->getMessage();
            $mailHisttory->save();

            try {
                Mail::mailer('sendgrid')->to($request->email)->send($body);
                $mailHisttory = new MailHistory;
                $mailHisttory->email = $request->email;
                $mailHisttory->subject = $request->input('subject');
                $mailHisttory->description = $request->input('description');
                $mailHisttory->status = 1;
                $mailHisttory->email_providers = 'sendgrid';
                $mailHisttory->save();

                return [
                    'status' => true,
                    'message' => "Your mail has been sent successfully."
                ];
            } catch (\Exception $e) {
                $mailHisttory = new MailHistory;
                $mailHisttory->email = $request->email;
                $mailHisttory->subject = $request->input('subject');
                $mailHisttory->description = $request->input('description');
                $mailHisttory->status = 0;
                $mailHisttory->email_providers = 'sendgrid';
                $mailHisttory->logs = $e->getMessage();
                $mailHisttory->save();

                return [
                    'status' => false,
                    'message' => $e->getMessage()
                ];
            }
        }
    }
}
