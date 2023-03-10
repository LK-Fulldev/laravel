<?php

namespace App\Http\Controllers;

use App\Models\MailHistory;
use App\Models\SendgridOverview;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $countRequests = SendgridOverview::query()->sum('requests');
        $countDelivered = SendgridOverview::query()->sum('delivered');
        $countOpens = SendgridOverview::query()->sum('opens');
        $countErrors = MailHistory::query()->where('status', 0)->count('status');
        return view('master.app', compact('countRequests', 'countDelivered', 'countOpens', 'countErrors'));
    }

    public function fetchMailHistory(Request $request)
    {
        $dataValues = MailHistory::query();
        $dataValues->when($request->input('search.value'), function ($qury) use ($request) {
            $qury->where(function ($q) use ($request) {
                $q->orWhere('status', (($request->input('search.value') == "Success") ? 1 : $request->input('search.value')));
                $q->orWhere('status', (($request->input('search.value') == "Warning") ? 0 : $request->input('search.value')));
                $q->orWhere('email', 'LIKE', "%{$request->input('search.value')}%");
                $q->orWhere('subject', 'LIKE', "%{$request->input('search.value')}%");
            });
        });
        $dataValues->orderBy('id', 'desc');
        $newData = $dataValues->get();
        $customData = [];
        foreach ($newData as $val) {
            $data['email'] = $val->email;
            $data['subject'] = mb_substr($val->subject, 0, 20) . "...";
            $data['description'] = mb_substr($val->description, 0, 30) . "...";
            $data['status'] = ($val->status == 1) ? '<span class="badge bg-success">Success</span>' : '<span class="badge bg-warning">Warning</span>';
            $data['date_time'] = $val->date_time;
            $customData[] = $data;
        }
        return response()->json([
            'draw' => intval($request->input('draw')),
            'recordsTotal' => intval($dataValues->count()),
            'recordsFiltered' => intval($dataValues->count()),
            'data' => $customData
        ]);
    }
}
