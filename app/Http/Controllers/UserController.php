<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Hashing\BcryptHasher;

class UserController extends Controller
{
    /**
     * Authenticate a user using username password password.
     *
     * @return \Illuminate\Http\Response
     */
    public function authenticate(Request $request)
    {
        $user = \App\Models\User::where('username', $request->username)->first();
        if (!$user) return response()->json(['error' => 'not found'], 404);

        if(!(new BcryptHasher)->check($request->password, $user->password))
            return response()->json(['error' => 'bad request'], 400);

        $tokenInstance = new \App\Util\AuthToken;
        return response()->json(['token' => $tokenInstance->create([])], 200);
    }
}
