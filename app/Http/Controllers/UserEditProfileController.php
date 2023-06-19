<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateUserProfileRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserEditProfileController extends Controller
{
    public function editProfile(Request $request, $user_id){


        $user = User::find($user_id);
        //dd(Auth::user()->user_id);
        if (!$user || $user->user_id != auth()->user()->user_id) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        return response()->json(['user' => $user]);
    }
    public function updateProfile(UpdateUserProfileRequest $request)
    {
        $user = Auth::user();
        // dd($user);
        $user_id = $user->user_id;
        //dd($request);
        $u1 = User::find($user_id);
        // if ($request->hasFile('avatar')) {
        //     $avatar = $request->file('avatar');
        //     $filename = time() . '.' . $avatar->getClientOriginalExtension();
        //     $avatar->storeAs('public/avatars', $filename);
        //     $u1->avatar = 'storage/avatars/' . $filename;
        // }

        if ($request->hasFile('avatar')) {
            $avatar = $request->file('avatar');
            $filename = $avatar->getClientOriginalName(); // get original file name
            $avatar->storeAs('public/avatars', $filename); // store the file with original name
            $u1->avatar = 'storage/avatars/' . $filename;
        }

        $u1->fill($request->post());
        $u1->save();


        return response()->json(['message' => 'Profile updated successfully!']);
        // dd($request);
    }
    public function updatePassword(Request $request)
    {
        //$user = User::find(Auth::user()->user_id);
      //dd($user);
        $request->validate([
            'old_password' => [
                'required',
                function ($attribute, $value, $fail) use ($request) {
                    $user = User::find(Auth::user()->user_id);

                    if (!$user || !Hash::check($value, $user->password)) {
                        $fail('The old password is incorrect.');
                    }
                   // dd($user);
                }
            ],
            'password' => 'required|string|min:8|different:old_password',
            'confirm_password' => 'required|same:password'
        ]);
        //dd($request);
        $user_id = Auth::user()->user_id;
        $user = User::find($user_id);

        if (!$user) {
            return response()->json(['error' => 'User not found.'], 404);
        }

        $user->password = Hash::make($request->input('password'));
        $user->save();

        return response()->json(['success' => true]);
    }


}
