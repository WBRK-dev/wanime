<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use Illuminate\Support\Facades\Auth;
use App\Models\Registrations;
use App\Models\Hit;
use App\Models\User;

class AdminController extends Controller
{
    function registrations() {
        if (!in_array(Auth::user()->email, config('app.admin_email'))) {return back();}

        $registrations = Registrations::select("*")->orderBy('name')->limit(30)->get();
        
        return view("admin.registrations", [
            "registrations" => $registrations
        ]);
    }

    function registrationAction(Request $request) {
        $action = $request->input("ac");
        $id = $request->input("id");

        if ($action === "submit") {
            $user = Registrations::findOrFail($id);
            User::insert([
                "name"=>$user->name,
                "email"=>$user->email,
                "password"=>$user->password,
            ]);
            Registrations::where("id", $id)->delete();
        } else if ($action === "remove") {
            Registrations::where("id", $id)->delete();
        }

        return back();
    }

    function panel(Request $request) {

        $thisWeek = DB::select("select DATE(created_at) as day, count(id) as count from hits where created_at > NOW() - INTERVAL 7 DAY GROUP BY DATE(created_at) ORDER BY DATE(created_at) asc;");
        $thisWeekData = [];

        for ($i=1; $i < 8; $i++) { 
            array_push($thisWeekData, [
                "day"=>date('Y-m-d',strtotime("-". 7 - $i ." days")),
                "count"=>0
            ]);
        }

        foreach ($thisWeek as $day) {
            for ($i=0; $i < count($thisWeekData); $i++) { 
                if ($thisWeekData[$i]["day"] === $day->day) {
                    $thisWeekData[$i]["count"] = $day->count;
                }
            }
        }



        $monthlyHitsRoutes = DB::select("select path, count(path) as count FROM hits where created_at > NOW() - INTERVAL 30 DAY GROUP BY path;");
        $monthlyHitsRoutesData = [
            "/" => 0,
            "/anime" => 0,
            "/search" => 0,
            "/watch" => 0,
            "/watchlist" => 0,
            "/account" => 0,
        ];

        foreach ($monthlyHitsRoutes as $route) {
            $monthlyHitsRoutesData[$route->path] = $route->count;
        }

        $weekUniqueHits = DB::select("select DATE(created_at) as day, ip from hits where created_at > NOW() - INTERVAL 7 DAY GROUP BY DATE(created_at), ip ORDER BY DATE(created_at) asc;");
        $weekUniqueHitsData = [];

        for ($i=1; $i < 8; $i++) { 
            array_push($weekUniqueHitsData, [
                "day"=>date('Y-m-d',strtotime("-". 7 - $i ." days")),
                "count"=>0
            ]);
        }

        foreach ($weekUniqueHits as $hit) {
            for ($i=0; $i < count($weekUniqueHitsData); $i++) { 
                if ($weekUniqueHitsData[$i]["day"] === $hit->day) {
                    $weekUniqueHitsData[$i]["count"] += 1;
                }
            }
        }

        // foreach ($weekUniqueHits as $obj) {
        //     $found = false;
        //     for ($i=0; $i < count($weekUniqueHitsData); $i++) { 
        //         if (isset($weekUniqueHitsData[$i]) && $weekUniqueHitsData[$i]["day"] === $obj->day) {
        //             $weekUniqueHitsData[$i]["count"] += 1;
        //             $found = true;
        //         }
        //     }
        //     if (!$found) {
        //         array_push($weekUniqueHitsData, [
        //             "day"=>$obj->day,
        //             "count"=>1
        //         ]);
        //     }
        // }

        $weekAuthorizedHits = DB::select("select DATE(created_at) as day, authorized, count(id) as count from hits where created_at > NOW() - INTERVAL 7 DAY GROUP BY DATE(created_at), authorized ORDER BY DATE(created_at) asc;");
        $weekAuthorizedHitsData = [];

        for ($i=1; $i < 8; $i++) { 
            array_push($weekAuthorizedHitsData, [
                "day"=>date('Y-m-d',strtotime("-". 7 - $i ." days")),
                "auth"=>0,
                "nonauth"=>0,
            ]);
        }

        foreach ($weekAuthorizedHits as $obj) {
            for ($i=0; $i < count($weekAuthorizedHitsData); $i++) { 
                if ($weekAuthorizedHitsData[$i]["day"] === $obj->day) {
                    $weekAuthorizedHitsData[$i][$obj->authorized ? "auth" : "nonauth"] = $obj->count;
                }
            }
        }
        
        // foreach ($weekAuthorizedHits as $obj) {
        //     $found = false;
        //     for ($i=0; $i < count($weekAuthorizedHitsData); $i++) { 
        //         if (isset($weekAuthorizedHitsData[$i]) && $weekAuthorizedHitsData[$i]["day"] === $obj->day) {
        //             $weekAuthorizedHitsData[$i][$obj->authorized ? "auth" : "nonauth"] = $obj->count;
        //             $found = true;
        //         }
        //     }
        //     if (!$found) {
        //         array_push($weekAuthorizedHitsData, [
        //             "day"=>$obj->day,
        //             $obj->authorized ? "auth" : "nonauth"=>$obj->count,
        //         ]);
        //     }
        // }

        $dayHitsPerHour = DB::select("SELECT HOUR(created_at) as hour, COUNT(id) as count from hits WHERE created_at > NOW() - INTERVAL 24 HOUR GROUP BY HOUR(created_at);");
        $dayHitsPerHourData = [
            ["hour"=>"00","count"=>0],
            ["hour"=>"01","count"=>0],
            ["hour"=>"02","count"=>0],
            ["hour"=>"03","count"=>0],
            ["hour"=>"04","count"=>0],
            ["hour"=>"05","count"=>0],
            ["hour"=>"06","count"=>0],
            ["hour"=>"07","count"=>0],
            ["hour"=>"08","count"=>0],
            ["hour"=>"09","count"=>0],
            ["hour"=>"10","count"=>0],
            ["hour"=>"11","count"=>0],
            ["hour"=>"12","count"=>0],
            ["hour"=>"13","count"=>0],
            ["hour"=>"14","count"=>0],
            ["hour"=>"15","count"=>0],
            ["hour"=>"16","count"=>0],
            ["hour"=>"17","count"=>0],
            ["hour"=>"18","count"=>0],
            ["hour"=>"19","count"=>0],
            ["hour"=>"20","count"=>0],
            ["hour"=>"21","count"=>0],
            ["hour"=>"22","count"=>0],
            ["hour"=>"23","count"=>0],
        ];

        foreach ($dayHitsPerHour as $hit) {
            for ($i=0; $i < count($dayHitsPerHourData); $i++) { 

                $hour = $hit->hour < 10 ? "0" . $hit->hour : $hit->hour;

                if ($dayHitsPerHourData[$i]["hour"] == $hour) {
                    $dayHitsPerHourData[$i]["count"] = $hit->count;
                }
            }
        }

        return view("admin.panel", [
            "week"=> json_encode($thisWeekData),
            "hitperroute"=>json_encode($monthlyHitsRoutesData),
            "uniqueHits"=>json_encode($weekUniqueHitsData),
            "weekAuth"=>json_encode($weekAuthorizedHitsData),
            "hitsperhour"=>json_encode($dayHitsPerHourData),
        ]);
    }
}