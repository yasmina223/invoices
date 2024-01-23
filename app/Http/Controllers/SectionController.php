<?php

namespace App\Http\Controllers;

use App\Models\Section;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SectionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $sections=Section::all();
       return view('sections.section',compact('sections'));
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
    public function store(Request $request,)
    {
        $request->validate([
            'section_name' => 'required|unique:sections|max:255',
            'description' => 'required'],[
                'section_name.required'=>'يرجي ادخال القسم',
                'section_name.unique'=>'اسم القسم مسجل مسبقا',
                'description.required'=>'يرجي ادخال البيان',

        ]);

            Section::create([

                'section_name'=>$request->section_name,
                'description'=>$request->description,
                'created_by'=>(Auth::user()->name)
            ]);
            session()->flash('Add','تم اضافه البيانات بنجاح');
            return redirect('/sections');

    }


    /**
     * Display the specified resource.
     */
    public function show(Section $section)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Section $section)
    {
        $sections=Section::all();
        return view('sections.section',compact('sections'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request,$id)
    {
        $id = $request->id;
        $this->validate($request, [

            'section_name' => 'required|max:255|unique:sections,section_name,'.$id,
            'description' => 'required',
        ],[

            'section_name.required' =>'يرجي ادخال اسم القسم',
            'section_name.unique' =>'اسم القسم مسجل مسبقا',
            'description.required' =>'يرجي ادخال البيان',

        ]);

        $sections=Section::find($id);
        $sections->update([
            'section_name'=>$request->section_name,
            'description'=>$request->description,

        ]);

        session()->flash('edit','تم التعديل بنجاح');
        return redirect('/sections');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)

    {
    $id = $request->id;
    Section::destroy($id);
    session()->flash('delete','تم حذف القسم بنجاح');
    return redirect('/sections');
   }
}
