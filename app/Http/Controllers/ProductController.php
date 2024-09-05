<?php

namespace App\Http\Controllers;

use App\Models\Product as prods;
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
        $request->validate([
            'name' => 'required|min:3|unique:products',
            'price' => 'required|integer',
            'stock' => 'required|integer',
            'category' => 'required|in:food,drink,snack',
            'image' => 'required|image|mimes:png,jpg,jpeg'
        ]);
        $filename = time() . '.' . $request->image->extension();
        $request->image->storeAs('public/products', $filename);
        $data = $request->all();

        $product = new prods;
        $product->name = $request->name;
        $product->description = $request->description;
        $product->price = (int) $request->price;
        $product->stock = (int) $request->stock;
        $product->category = $request->category;
        $product->image = $filename;
        $product->save();
        // dd($product);


        return redirect()->route('product.index')->with('success', 'Product Successfully Created');
    }

    public function edit($id){
        $product = prods::findOrFail($id);
        return view('pages.products.edit', compact('product'));
    }

    public function update(Request $request, $id){
        $data = $request->all();
        $product = prods::findOrFail($id);
        $product->update($data);
        return redirect()->route('product.index')->with('success', 'Product Sucessfully Updated');
    }

    public function destroy($id){
        $product = prods::findOrFail($id);
        $product->delete();
        return redirect()->route('product.index')->with('success', 'Product Successfuly Deleted');
        // aaa
    }
}
