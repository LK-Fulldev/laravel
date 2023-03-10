<?php

namespace App\Http\Controllers;

use App\Models\MailHistory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TestConnectController extends Controller
{
    public function index(Request $request)
    {
        $mailHistory = MailHistory::query()->get();
        print_r($mailHistory);
        exit;

    }
}
