<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login'); // Giriş formunun view dosyası
    }

    public function login(Request $request)
    {
      $verified = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

         // API'ye POST isteği gönder 
         $response = Http::acceptJson()->post(env('API_URL').'/login', [ 
            'email' => $verified['email'], 
            'password' => $verified['password'], 
        ]); 

        if ($response->successful() && isset($response['token'])) {  
            session(['api_token' => 'Bearer '.$response['token']]); 

            return redirect('/product')->with('success', 'Başarıyla giriş yapıldı!'); 
        } 

        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            return redirect()->intended('product');
        }

        return redirect()->back()->withErrors([
            'email' => 'E-posta veya şifre hatalı. Lütfen tekrar deneyin.',
        ])->withInput();
    }

    public function logout(Request $request) {
        $token = session('api_token'); 
        $user = Http::timeout(1000)->withToken(session('api_token'))->post("http://nginx_api/api/logout");
        if($user->successful())
        {
            session()->forget('api_token');
            return redirect('http://localhost:8001/index');
        }
   
    }
    


}
