<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Section;
use App\Models\invoices;

class ReportController extends Controller
{
    public function index(){
        $sections = Section::all();
      return view('reports.customers_reports',compact('sections'));
    }

    public function Search_customers(Request $request){

    // في حالة البحث بدون التاريخ

    if ($request->Section && $request->product && $request->start_at =='' && $request->end_at=='') {


        $invoices = invoices::select('*')->where('section_id','=',$request->Section)->where('product','=',$request->product)->get();
        $sections = Section::all();
         return view('reports.customers_reportS',compact('sections'))->withDetails($invoices);


       }


    // في حالة البحث بتاريخ

       else {

         $start_at = date($request->start_at);
         $end_at = date($request->end_at);

        $invoices = invoices::whereBetween('invoice_Date',[$start_at,$end_at])->where('section_id','=',$request->Section)->where('product','=',$request->product)->get();
         $sections = Section::all();
         return view('reports.customers_report',compact('sections'))->withDetails($invoices);


       }



      }
    }

