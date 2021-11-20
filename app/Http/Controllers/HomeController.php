<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Carbon\Carbon;
use DB;
Use Redirect;
use Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $jlhbmn = DB::table('md_bmn')->count();
        $jlhpeminjaman = DB::table('td_peminjaman_header')->count();
        $jlhruangan = DB::table('md_ruangan')->count();
        $jlhpegawai = DB::table('md_pegawai')->count();

        $data = [
          'jlhbmn' => $jlhbmn,
          'jlhpeminjaman' => $jlhpeminjaman,
          'jlhruangan' => $jlhruangan,
          'jlhpegawai' => $jlhpegawai,
        ];
        
        return view('home', compact('data'));
    }
}
