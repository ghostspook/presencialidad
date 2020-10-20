<?php

namespace App\Http\Controllers;

use App\Models\QrScan;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class AccessReportController extends Controller
{
    function index()
    {
        $date = Carbon::now()->format('yy-m-d');
        return redirect()->route('accessReport_showReport', $date);
    }


    function postQueryCriteria(Request $request)
    {
        $input = $request->all();
        return redirect()->route('accessReport_showReport', $input['date']);
    }

    function showReport($date)
    {
        return view('accessreport.report', [ 'date' => $date ]);
    }

    public function dataTable($date)
    {
        $scans = QrScan::whereDate('created_at', $date);
        return DataTables::of($scans)
            ->addColumn('type', function($s) {
                return $s->authorization->user->trackedAccount->getAccountTypeText();
            })
            ->addColumn('name', function($s) {
                return $s->authorization->user->name;
            })
            ->addColumn('groupname', function($s) {
                if ($s->authorization->user->trackedAccount->group_id) {
                    return $s->authorization->user->trackedAccount->group->name;
                } else {
                    return '-';
                }
            })
            ->addColumn('date_time', function($s) {
                return $s->created_at;
            })
            ->addColumn('time', function($s) {
                return $s->created_at->format('H:i:s');
            })
            ->addColumn('authorized', function($s) {
                return $s->authorized ? 'Autorizado' : 'No autorizado';
            })
            ->make(true);
    }
}
