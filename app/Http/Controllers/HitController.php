<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Models\Hit;

class HitController extends Controller
{
    function hit(Request $request) {
        $auth = false;
        if (Auth::check()) $auth = true;

        $ip = $request->input("ip");
        $os = $request->input("os");
        $path = $request->input("path");
        $screenx = $request->input("screenx");

        Hit::insert([
            'authorized'=>$auth,
            'ip'=>$ip,
            'os'=>$os,
            'path'=>$path,
            'screenx'=>$screenx
        ]);

        return "success";
    }
}
