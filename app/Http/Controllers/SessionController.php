<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Models\User;

class SessionController extends Controller
{	
     /**
     * Store credentials in session after login.
     *
     * @param  Request  $request
     * @return Response
     */	 
    public function login(Request $request)
    {
        // validate incoming request 
        $this->validate($request, [
            'location' => 'required|string',
            'phone' => 'required|string',
            'password' => 'required|string',
        ]);

        $location = $request->input('location');               // set location variable
        $user = User::where('location', $location)->first();   // find user

        // validate user
        if (isset($user) && (Hash::check($request->input('password'), $user->password)))
        {
            app('session')->put('location', $location);
            app('session')->put('location_id', $user->id);
            app('session')->put('phone', $request->input('phone'));
            return redirect('/client/check-in');
        }

        return redirect('/');
    }
}