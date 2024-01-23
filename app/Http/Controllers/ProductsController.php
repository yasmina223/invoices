<?php

namespace App\Http\Controllers;

use App\Models\Products;
use App\Models\Section;
use Illuminate\Http\Request;

class ProductsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()

    {
        $sections=Section::all();
        $products=Products::all();
        return view('products.products',compact('sections','products'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
       //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
     {
        $this->validate($request,[
            'product_name'=> 'required|unique:products|max:255',
            'section_id'=>'required',
            'description' => 'required'],[
                'product_name.required'=>'يرجي ادخال المنتج',
                'product_name.unique'=>'المنتج مسجل مسبقا',
                'description.required'=>'يرجي ادخال البيان',

        ]);

       Products::create([
         'product_name'=>$request->product_name,
         'section_id'=>$request->section_id,
         'description'=>$request->description,
       ]);
       session()->flash('Add','تم اضافه البيانات بنجاح');
       return redirect('/products');
    }

    /**
     * Display the specified resource.
     */
    public function show(Products $products)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Products $products)
    {

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $id=Section::where('section_name',$request->section_name)->first()->id;
        $products=Products::findorFail($request->id);

        $products->update([
             'product_name'=>$request->product_name,
             'description'=>$request->description,
             'section_id'=>$id,
        ]);
        session()->flash('edit','تم تعديل البيانات بنجاح');
        return redirect('/products');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        // $products=Products::findorFail($request->id);
        $id=$request->id;
       Products::destroy($id);
       session()->flash('','تم حذف المنتج بنجاح');
        return redirect('/products');
    }
}
