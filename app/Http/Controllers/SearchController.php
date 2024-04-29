<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class SearchController extends Controller
{
    function home(Request $request) {

        try {
            $response = Http::get($_ENV["API_URL"]."/anime/search?q=". $request->query("search") ."&page=" . $request->query("page") ?? 1);
        } catch (\Throwable $th) {
            return view("error.500");
        }

        if ($response->tooManyRequests()) {
            return view("error.429");
        }

        if ($response->failed()) {
            return view("error.500");
        }

        $results = $response->json();

        $totalPages = $results["totalPages"];
        $currentPage = $results["currentPage"];
        $pages = [
            "prevAll" => ["active" => false, "page" => 1],
            "prev" => ["active" => false, "page" => 1],
            "pages" => [],
            "next" => ["active" => false, "page" => 1],
            "nextAll" => ["active" => false, "page" => 1],
            "url" => "",
            "active" => false
        ];
        if ($results["totalPages"] > 1) {
            $pages["active"] = true;
            $pages["url"] = config("app.url") . "/search?search=" . $request->query("search");
    
            $beginPage = ($currentPage > 3) ? $currentPage - 2 : 1;
            for ($i=$beginPage; $i < $currentPage + 3; $i++) {
                if ($i > $totalPages) break;
                if ($i === $currentPage) array_push($pages["pages"], ["page" => $i, "current" => true]);
                else array_push($pages["pages"], ["page" => $i, "current" => false]);
            }
    
            if ($currentPage > 2) $pages["prevAll"]["active"] = true;
            if ($currentPage > 1) {
                $pages["prev"]["active"] = true;
                $pages["prev"]["page"] = $currentPage - 1;
            }
            
            if ($currentPage < $totalPages) {
                $pages["next"]["active"] = true;
                $pages["next"]["page"] = $currentPage + 1;
            }
            if ($currentPage < $totalPages - 1) {
                $pages["nextAll"]["active"] = true;
                $pages["nextAll"]["page"] = $totalPages;
            }
        }

        return view("search", [
            "results" => $results,
            "pages" => $pages
        ]);
    }
}
