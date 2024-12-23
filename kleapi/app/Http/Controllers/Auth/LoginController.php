<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Http; // Doğru Http sınıfını ekleyin
use App\Models\User;


class LoginController extends Controller
{

    public function login(Request $request): JsonResponse
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        $user= User::where('email',$request->email)->first();

        if(!$user || !Hash::check($request->password,$user->password)){
            return response()->json([
                'message'=>'Sağlanan kimlik bilgileri yanlış'
            ],401);
        }

        $token=$user->createToken($user->name.'Auth-Token')->plainTextToken;

         // Token'ı oturuma kaydet
         session(['api_token' => $token]);

        return response()->json([
            'message'=>'Giriş Başarılı',
            'token_type'=> 'Bearer',
            'token'=>$token
        ],200);

        session(['api_token' => $token]);



        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
           return redirect()->intended('product');
        }

       return redirect()->back()->withErrors([
            'email' => 'E-posta veya şifre hatalı. Lütfen tekrar deneyin.',
        ])->withInput();

            

    }

    public function logout(Request $request) {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
    
        // Çıkış yaptıktan sonra yönlendirme
        return redirect('http://localhost:8001/index');
    }
    


}
