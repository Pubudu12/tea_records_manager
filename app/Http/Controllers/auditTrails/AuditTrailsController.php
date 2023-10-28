<?php

namespace App\Http\Controllers\auditTrails;

use App\Http\Controllers\Controller;
use App\Http\Traits\DBOperationsTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AuditTrailsController extends Controller
{
    use DBOperationsTrait;

    public function showUserAuditTrails(){
        $audits = DB::table('audits')
                            ->leftjoin('users', 'users.id', '=', 'audits.user_id')
                            ->select('users.name AS userName','audits.*')
                            ->get();

        return view('audit-trails/audits',['auditTrails'=>$audits]);
    }
}
