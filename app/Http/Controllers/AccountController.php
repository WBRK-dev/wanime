<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class AccountController extends Controller
{
    function account() {
        
        if (!Auth::check()) {return view("account.login");}

        $user_initials = explode(" ", Auth::user()->name);
        $user_initials = strtoupper($user_initials[0][0]) . ((count($user_initials) > 1) ? strtoupper($user_initials[1][0]) : "");

        return view("account.account", [
            "user_initials" => $user_initials
        ]);
    }

    function settings() {

        $user = Auth::user();

        $privacy = [
            "visibility" => $user->visible_to_public,
            "save_episode_progress" => $user->save_episode_progress,
            "public_reviews" => $user->public_reviews,
        ];

        return view("account.settings.settings", [
            "privacy" => $privacy
        ]);
    }

    function update(string $setting, Request $request) {

        $value = $request->input("value");
        
        $keys = ["visible_to_public", "save_episode_progress", "public_reviews"];
        $values = [
            "visible_to_public" => ["private", "global"],
            "save_episode_progress" => ["never", "in_watching", "always"],
            "public_reviews" => ["private", "public"],
        ];

        if (!in_array($setting, $keys) || !in_array($value, $values[$setting])) {
            return "failed";
        }

        User::where('id', Auth::user()->id)->update([$setting => $value]);

        return "success";
    }
}