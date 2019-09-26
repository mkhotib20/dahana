<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Log;
use Auth;

class LogController extends Controller
{
    public function index()
    {
        $data = array('log' => Log::orderBy('created_at', 'DESC')->get(), 'pwd' => "!@#$4321");
        return view('log')->with($data);
    }
    public static function storeLog($msg)
    {
        try {
            $clientIP = request()->ip();
            Log::create([
                "activity" => $msg,
                "user" => Auth::user()->username." | IP : ".$clientIP,
            ]);
        } catch (\Throwable $th) {
            //throw $th;
        }
    }
}
