<?php

namespace App\Http\Controllers;

use App\sections;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SectionsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $sections = sections::all();
        return view('sections.sections',compact('sections'));
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
            'section' => 'required|unique:sections|max:255',
            'description' => 'required',
        ],[
            'section.required' => 'يرجى اٍدخال القسم',
        'section.unique' => 'تم اٍدخال القسم مسبقا',
        'description.required' => 'يرجى اٍدخال الوصف',
        ]);
    
            sections::create([
            'section'=>$request->section,
            'description'=>$request->description,
            'created_by'=>(Auth::user()->name)
            ]);

            session()->flash('Add','تمت اضافة القسم بنجاح');
            return redirect('/sections');
        
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\sections  $sections
     * @return \Illuminate\Http\Response
     */
    public function show(sections $sections)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\sections  $sections
     * @return \Illuminate\Http\Response
     */
    public function edit(sections $sections)
    {
        //
        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\sections  $sections
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        //
        $id = $request->id;
        
        $this->validate($request,[
            'section'=>'required|unique:sections,section,'.$id,
            'description'=>'required',
        ],[
            'section.required' => 'يرجى اٍدخال القسم',
            'section.unique' => 'تم اٍدخال القسم مسبقا',
            'description.required' => 'يرجى اٍدخال الوصف',

        ]);
        
        $sections = sections::find($id);
        $sections->update([
        'section'=>$request->section,
        'description'=>$request->description,
        ]);
        session()->flash('edit','تم تعديل القسم بنجاح');
        return redirect('/sections');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\sections  $sections
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $id = $request->id;
        $sections = sections::find($id);
        $sections->delete();
        session()->flash('delete','تم حذف القسم ');
        return redirect('/sections');

    }
}
