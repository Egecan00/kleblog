<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http; // Http sınıfını ekleyin
use Illuminate\Support\Facades\Log;
use Illuminate\Pagination\LengthAwarePaginator;

class ProductController extends Controller
{
    
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $token = session('api_token');
        

        if (!$token) {
            return redirect('/index')->with('error', 'Lütfen giriş yapınız.');
        }

        $page = $request->input('page', 1);
        $perPage = 10; // Sayfa başına ürün sayısı

        $products = Http::withToken($token)
        ->get(env('API_URL') . '/product/',[
        'page' => $page,
        'per_page' => $perPage
        ])
        ->json();

        $paginator = new LengthAwarePaginator(
            $products['data'],  //API'den gelen ürün verilerinin listesi. JSON yanıtındaki data anahtarına karşılık gelen verileri alır.
            $products['total'],  //toplam ürün sayısını belirtir. Sayfalama işlemi için toplam ürün sayısını bilmek önemlidir.
            $perPage,   //Sayfa başına gösterilecek ürün sayısını belirtir. Bu örnekte, her sayfada 10 ürün gösteriliyor.
            $page,  //Mevcut sayfa numarasını belirtir. Gelen istekten alınan page parametresine dayanarak belirlenir.
            ['path' => LengthAwarePaginator::resolveCurrentPath()]  //sayfalama bağlantılarının doğru URL'yi oluşturmasını sağlar. resolveCurrentPath metodu, geçerli URL yolunu otomatik olarak çözer.
        );
          
        return view('product.index', [ 'products' => $paginator, ]);
        // $products = Http::get(env('API_URL').'/product',)->json(); 
        return view('product.index', [
            'products' => $products['data'] 
        ]);   

      
        
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

        $token = session('api_token');

        if (!$token) {
            return redirect('/index')->with('error', 'Lütfen giriş yapınız.');
        }

         return view('product.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $token = session('api_token');

        if (!$token) {
            return redirect('/index')->with('error', 'Lütfen giriş yapınız.');
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string|max:255',
            'price' => 'required|numeric|digits_between:1,10|min:1',

        ], [
            'price.digits_between' => '8 haneden daha fazla rakam giremezsiniz.',  
            'price.min' => 'Sıfır giremezsiniz.Lütfen geçerli bir değer girin.',
        ]);


        $response = Http::withToken($token)
        ->post(env('API_URL').'/product/', [
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
        ]);
        return redirect('/product')->with('status','Ürün başarılı bir şekilde oluşturuldu');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $token = session('api_token');

        if (!$token) {
            return redirect('/index')->with('error', 'Lütfen giriş yapınız.');
        }


        $response = Http::withToken($token)
        ->get(env('API_URL').'/product/'. $id);
        
         // Eğer yanıt başarılıysa (HTTP 200)
         if ($response->successful()) {
            $product = $response->json();
            return view('product.show', [
                'products' => $product['data'] 
            ]);   
            // return view('product.show', compact('product'));
        }
        
         // Eğer bir hata oluşursa
         return redirect()->back()->withErrors('Ürün bilgisi alınamadı.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $token = session('api_token');

        if (!$token) {
            return redirect('/index')->with('error', 'Lütfen giriş yapınız.');
        }

        $response = Http::withToken($token)
        ->get(env('API_URL') . '/product/'. $id);
        
         // Eğer yanıt başarılıysa (HTTP 200)
         if ($response->successful()) {
            $product = $response->json();
           
            return view('product.edit', [
                'products' => $product['data'] 
            ]);   
        }
        return back()->withErrors(['error' => 'Ürün bulunamadı']);
        // return view('product.edit', compact('product'));
    }

    /**
     * Update the specified resource in storage.
     */
    
    public function update(Request $request,$id)
    {
        
        $token = session('api_token');

        if (!$token) {
            return redirect('/index')->with('error', 'Lütfen giriş yapınız.');
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string|max:255',
            'price' => 'required|numeric|digits_between:1,10|min:1',
        ], [
            'price.digits_between' => '8 haneden daha fazla rakam giremezsiniz.',
            'price.min' => 'Sıfır giremezsiniz.Lütfen geçerli bir değer girin.',
        ]);

        $response = Http::withToken($token)
        ->put(env('API_URL').'/product/'. $id, [
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
        ]);
       


        // $response = Http::withToken($token)
        // ->put(env('API_URL').'/product/'. $id)
        // ->json();

        // return response()->json(['message' => 'Ürün başarıyla güncellendi!' ], 200); //'product' => $product
       // return response()->json(['error' => 'Ürün güncellenemedi'], 422);
         return redirect('/product')->with('status','Ürün başarılı bir şekilde değiştirildi');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $token = session('api_token');

        if (!$token) 
        { 
            return redirect('/login')->with('error', 'Lütfen giriş yapınız.'); 
        }

        $response = Http::withToken($token)->delete(env('API_URL') . '/product/' . $id);

        if ($response->successful()) {
            return redirect()->route('product.index')->with('message', 'Ürün başarıyla silindi.');
        }

        return back()->withErrors(['error' => 'Ürün silinemedi.']);

        // $product->delete();
        // return redirect('/product')->with('status','Ürün başarıyla silindi');
    }
}
