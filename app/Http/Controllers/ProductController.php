<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    public function index(Request $request){
        $products = DB::table('products')
        ->when($request->input('name'), function($query, $name){
            return $query->where('name', 'like', '%'.$name.'%');
        })
        ->orderBy('id', 'desc')
        ->paginate(10);
        return view('pages.products.index', compact('products'));
    }

    public function create(){
        return view('pages.products.create');
    }

    public function store(Request $request){
        $data = $request->all();
        \App\Models\Product::create($data);
        return redirect()->route('product.index')->with('success', 'Product Successfully Created');
    }

    public function edit($id){
        $product = \App\Models\Product::findOrFail($id);
        return view('pages.products.edit', compact('product'));
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
        // aaa
    }
}
