<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http; // Laravel HTTP İstemcisi
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\RedirectResponse;

class RegisterController extends Controller
{
    // Kayıt formunu göstermek için bir yöntem
    public function showRegistrationForm()
    {
        return view('auth.register'); // Kayıt formunun yer aldığı view dosyası
    }

    public function register(Request $request)
    {
        // Gelen verileri doğrula
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255',
            'password' => 'required|string|min:8|confirmed',
        ]);

         if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
         }

        // Backend API'ye istek gönder
        $backendResponse = Http::post(env('API_URL').'/register', [
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password,
            'password_confirmation' => $request->password_confirmation,
        ]);
        
        if ($backendResponse->successful()) { return redirect('http://localhost:8001/login')->with('success', 'Kayıt başarılı!'); } 
        else { return redirect()->back()->withErrors(['error' => 'Kayıt sırasında bir hata oluştu.'])->withInput(); }
        
            // return redirect('http://localhost:8001/login');
            // Backend yanıtını kontrol et
            // if ($backendResponse->successful()) {

            // return response()->json([
            //     'message' => 'Kayıt başarılı!',
            //     'data' => $backendResponse->json(),
            //     'redirect_url' => route('login') // Login sayfasına yönlendirme URL'si
            // ], 201);
        // }
        

        // Backend hatası varsa, hata mesajını döndür
        // return response()->json([
        //     'error' => 'Backend kaydı sırasında bir hata oluştu.',
        //     'details' => $backendResponse->json()
        // ], $backendResponse->status());     
    }
}
