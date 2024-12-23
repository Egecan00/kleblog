<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Resources\ProductResource;
use Illuminate\Support\Facades\Validator;


class ProductController extends Controller
{
    /**
     * Display a listing of the resource.   
     */
            public function index(Request $request) // Request parametresi eklendi
        {
            if (!$request->bearerToken()) {
                return redirect()->route('index'); // Token yoksa login sayfasına yönlendir
            }

            
            $products = Product::paginate(10); 
            
            if ($products->isEmpty()) {
                return response()->json(['message' => 'Kayıt mevcut değil'], 200);
            }
            
            return($products);

            

                
        // return view([
        //     'products' => $products
        // ]);  

       
        }
    
    

    /**
     * Show the form for creating a new resource.
     */
    

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        
       
        

        $validator= Validator::make($request->all(),[
            'name' => 'required|string|max:255',
            'description' => 'required|string|max:255',
            'price' => 'required|numeric|digits_between:1,10|min:1',
        ]);


        if($validator->fails())
        {
            return response()->json([
                'message'=>'Tüm alanlar zorunludur!!!',
                'error'=>$validator->messages(),

            ],422);
        }

        // $request->validate([
        //     'name' => 'required|string|max:255',
        //     'description' => 'required|string|max:255',
        //     'price' => 'required|numeric|digits_between:1,10|min:1',

        // ], [
        //     'price.digits_between' => '8 haneden daha fazla rakam giremezsiniz.',  
        //     'price.min' => 'Sıfır giremezsiniz.Lütfen geçerli bir değer girin.',
        // ]);

      $product = Product::create([
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
        ]);

        return response()->json([
            'message'=>'Ürün başarılı bir şekilde oluşturuldu',
            'data'=>new ProductResource ($product)
        ],200);

       // return redirect('/product')->with('status','Ürün başarılı bir şekilde oluşturuldu');
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        return new ProductResource($product);   
        // return view('product.show', compact('product'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        // return view('product.edit', compact('product'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string|max:255',
            'price' => 'required|numeric|digits_between:1,10|min:1',
        ], [
            'price.digits_between' => '8 haneden daha fazla rakam giremezsiniz.',
            'price.min' => 'Sıfır giremezsiniz.Lütfen geçerli bir değer girin.',
        ]);

        $product->update([
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
        ]);

        return response()->json([
            'message' => 'Ürün başarıyla güncellendi',
            'data' => new ProductResource($product)
        ], 200);

        return redirect('/product')->with('status','Ürün başarılı bir şekilde değiştirildi');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(product $product)
    {
        $product->delete();
        return response()->json(['message' => 'Ürün başarıyla silindi'], 200);
        // return redirect('/product')->with('status','Ürün başarıyla silindi');
    }
}
