<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserEditProfileController extends Controller
{
    public function editProfile(Request $request, $user_id){


        $user = User::find($user_id);
        dd(Auth::user()->user_id);
        if (!$user || $user->user_id != auth()->user()->user_id) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        return response()->json(['user' => $user]);
    }


}
