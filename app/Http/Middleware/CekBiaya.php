<?php

namespace App\Http\Middleware;

use Closure;
use App\Limit;

use Session;
class CekBiaya
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $db = new \App\Http\Controllers\DashboardController();
        $limit = Limit::find(1)->lim_nom;
        $biaya_total = $db->getBiayaTotal();

        if ($biaya_total>=$limit) {
            Session::flash('error','Limit telah mencapai batas bulanan');
            return redirect('perjalanan')->with('error','Limit telah mencapai batas bulanan, anda tidak dapat menambahkan perjalanan');
        }
        return $next($request);
    }
}
