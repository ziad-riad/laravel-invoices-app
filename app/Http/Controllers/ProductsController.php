<?php

namespace App\Http\Controllers;

use App\products;
use App\sections;
use Illuminate\Http\Request;

class ProductsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $sections = sections::all();
        $products = products::all();

        return view('products.products',compact('sections','products'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'product_name'=>'required',
            'description'=>'required',
        ],[
            'product_name.required'=>'يرجى اٍدخال اٍسم المنتج',
            'description.required'=>'يرجى اٍدخال الوصف',
        ]);
        products::create([
        'product_name'=>$request->product_name,
        'description'=>$request->description,
        'section_id'=>$request->section_id,
        ]);
        return redirect('products');

        session()->flash('add','تمت اٍضافة المنتج بنجاح');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\products  $products
     * @return \Illuminate\Http\Response
     */
    public function show(products $products)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\products  $products
     * @return \Illuminate\Http\Response
     */
    public function edit(products $products)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\products  $products
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $id = sections::where('section',$request->section)->first()->id;

        $products = products::findOrFail($request->pro_id);
        $products->update([
            'product_name'=>$request->product_name,
            'description'=>$request->description,
            'section_id'=>$id,
        ]);
        session()->flash('edit','تم تعديل المنتج بنجاح');
        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\products  $products
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $products = products::findOrFail($request->pro_id);
        $products->delete();
        session()->flash('delete','تم حذف المنتج');
        return back();
    }
}
