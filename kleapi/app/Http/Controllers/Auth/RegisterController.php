<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\JsonResponse;

class RegisterController extends Controller
{
    // Kayıt formunu göstermek için bir yöntem

    // Kullanıcı kayıt işlemini gerçekleştirmek için bir yöntem
    public function register(Request $request): JsonResponse
    {
        // Gelen veriyi doğrula
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        // Kullanıcıyı oluştur
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        return response()->json(['message' => 'Kayıt başarıyla oluşturuldu!'], 201);

    
    }
}
