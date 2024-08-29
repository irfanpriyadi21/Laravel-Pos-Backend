<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request){
        $product = \App\Models\Product::paginate(10);
        return view('pages.products.index', compact('products'));
    }

    public function create(){
        return view('pages.products.create');
    }

    public function store(Request $request){
        $data = $request->all();
        \App\Models\Product::creatre($data);
        return redirect()->route('product.index')->with('success', 'Product Successfully Created');
    }

    public function edit($id){
        $product = \App\Models\Product::findOrFail($id);
        return view('pages.product.edit', compact('product'));
    }

    public function update(Request $request, $id){
        $data = $request->all();
        $product = \App\Models\Product::findOrFail($id);
        $product->update($data);
        return redirect()->route('product.index')->with('success', 'Product Sucessfully Updated');
    }

    public function destroy($id){
        $product = \App\Models\Product::findOrFail($id);
        $product->delete();
        return redirect()->route('product.index')->with('success', 'Product Successfuly Deleted');
    }
}
