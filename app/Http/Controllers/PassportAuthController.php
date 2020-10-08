<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Database\QueryException;

class PassportAuthController extends Controller
{
    /**
     * Registration Req
     */
    public function register(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|min:4',
            'email' => 'required|email',
            'password' => 'required|min:8',
        ]);

        try {
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => bcrypt($request->password)
            ]);
     
            $token = $user->createToken('HollidayPackage')->accessToken;
        } catch (QueryException $e) {
            report($e);
            abort(409, 'Invalid email: this email already exists');
            return false;
        }
 
 
        return response()->json(['token' => $token], 200);
    }
 
    /**
     * Login Req
     */
    public function login(Request $request)
    {
        $data = [
            'email' => $request->email,
            'password' => $request->password
        ];
 
        if (auth()->attempt($data)) {
            $token = auth()->user()->createToken('HollidayPackage')->accessToken;
            return response()->json(['token' => $token], 200);
        } else {
            return response()->json(['error' => 'Unauthorised'], 401);
        }
    }
}
