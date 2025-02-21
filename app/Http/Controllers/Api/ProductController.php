<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models as models;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if(auth('sanctum')->check()){
            $product = models\Product::orderBy('id', 'desc')->get();
            return response()->json([
                'success' => true,
                'message' => 'List Data Product',
                'data' => $product
            ], 200);

        }else{
            return response()->json([
                'success' => false,
                'message' => 'No Authenticate'
            ], 400);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request ->validate([
            'name' => 'required|min:3|unique:products',
            'price' => 'required|integer',
            'stock' => 'required|integer',
            'category' => 'required|in:food,drink,snack',
            'image' => 'required|image|mimes:png,jpg,jpeg'
        ]);
        $filename = time() . ',' . $request->image->extension();
        $request->image->storeAs('public/products', $filename);
        $product = models\Product::create([
            'name' => $request->name,
            'price' => (int)$request->price,
            'stock' => (int)$request->stock,
            'category' => $request->category,
            'image' => $filename,
            'is_favorite' => $request->is_favorite
        ]);
        if($product){
            return response()->json([
                'success' => true,
                'message' => 'Product Created',
                'data' => $product
            ], 201);
        }else{
            return response()->json([
                'success' => false,
                'message' => 'Product failed to Save'
            ], 409);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
