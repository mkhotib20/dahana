<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session;
use App\User;
use Redirect,Response;
use App\Http\Controllers\LogController;

class UserMgmt extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = User::where('role', '!=', '0')->get();
        return view('main.user', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $id = $request->id;
        $old = User::find($id);
        User::updateOrCreate(['id' => $id],
                    ['name' => $request->name, 'username' => $request->username, 'password' => bcrypt($request->password), 'role' => $request->role]);
        Session::flash('sukses','Menyimpan data berhasil');
        if ($id!="") {
            $msg = "Perubahan data user ".$old;
        }
        else{
            $msg = "Penambahan data user ".$request->username;
        }
        LogController::storeLog($msg);
        return redirect()->route('manajemen-user.index')->with('success', 'Post tersimpan');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $where = array('id' => $id);
        $driver  = User::where($where)->first();
 
        return Response::json($driver);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $usr = User::find($id);
        $msg = "Hapus data user Data : ".$usr;
        $usr->delete();
        Session::flash('sukses','Data Terhapus');
        LogController::storeLog($msg);
        return redirect()->route('manajemen-user.index')->with('success', 'Post tersimpan');
    }
}
