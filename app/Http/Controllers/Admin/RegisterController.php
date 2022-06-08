<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Rules\PhoneNumber;
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
        // $num4 = "00966";
        // $lastNumMobile = $num4 . substr($data['mobile'], -9);
        // $data['mobile'] = $lastNumMobile;
        //I can use 'regex:/(01)[0-9]{9}/'
        Validator::make($data, [
            'name'     => ['required', 'string'],
            'email'    => ['required', 'email', 'unique:users,email'],
            'mobile'   => ['required',new PhoneNumber],
            'password' => ['required', Password::min(8)->mixedCase()],
        ])->validate();

        $user = User::create([
            'name'     => $data['name'],
            'email'    => $data['email'],
            'mobile'   => $data['mobile'],
            'password' => Hash::make($data['password']),
        ]);

        $user->assignRole('admin');

        $token = $user->createToken('key')->plainTextToken;
        return response()->json([
            'access_token' => $token
        ]);
    }

}
