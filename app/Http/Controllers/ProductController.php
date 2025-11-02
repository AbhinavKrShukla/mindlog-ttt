<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Models\productss;
use App\Models\Product;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = auth()->user();
        $products = Product::where('user_id',$user->id)->get();
       return view('index', ['products' => $products]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('/home');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
       $validated = $request->validate([
            'title' => 'required|string|max:255',
            'notes' => 'nullable|string',
            'date'  => 'required|date',
        ]);

        $user=auth()->user();
        $product = new Product();
        $product->title = $request->title;
        $product->notes = $request->notes;
        $product->date = $request->date;
        
        $product->user_id = $user->id;
        $product->save();

        return redirect()->route('dashboard')->with('success', 'Product added successfully!');

    }

    /**
     * Display the specified resource.
     */
    public function show($id)
{
     $user=auth()->user();
    $product = Product::where('id',$id)->where('user_id',auth()->id())->findOrFail($id);
    return view('show', ['product' => $product]);

}


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);
         $product->notes = $request->notes;
         $product->save();
         return redirect()->route('dashboard');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
{
    $product = Product::findOrFail($id);
    $product->delete();

    return redirect()->route('dashboard')
                     ->with('success', 'Product deleted successfully!');
}

}
