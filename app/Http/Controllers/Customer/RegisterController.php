<?php

namespace App\Http\Controllers\Customer;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password;

class RegisterController extends Controller
{
    public function register(Request $request)
    {

        $data = $request->all();

        $num4 = "00966";
        $lastNumMobile = $num4 . substr($data['mobile'], -9);
        $data['mobile'] = $lastNumMobile;

        Validator::make($data, [
            'name'     => ['required', 'string'],
            'email'    => ['required', 'email', 'unique:users,email'],
            'mobile'   => ['required', 'string', 'min:10'],
            'password' => ['required', Password::min(8)->mixedCase()],
        ])->validate();

        $user = User::create([
            'name'     => $data['name'],
            'email'    => $data['email'],
            'mobile'   => $data['mobile'],
            'password' => Hash::make($data['password']),
        ]);

       $user->assignRole('customer');
        $token = $user->createToken('key')->plainTextToken;
        return response()->json([
            'access_token' => $token
        ]);
    }
}
