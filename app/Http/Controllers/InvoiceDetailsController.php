<?php

namespace App\Http\Controllers;

use App\Models\InvoiceDetails;
use App\Models\InvoiceAttachments;
use App\Models\invoices;
use Illuminate\Support\Facades\Storage;

use Illuminate\Http\Request;

class InvoiceDetailsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

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
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(InvoiceDetails $invoiceDetails)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {

        $invoices = invoices::where('id',$id)->first();
        $details  = InvoiceDetails::where('id_Invoice',$id)->get();
        $attachments=InvoiceAttachments::where('invoice_id',$id)->get();

       return view('invoices.invoice_details',compact('invoices','details','attachments'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, InvoiceDetails $invoiceDetails)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $invoices = InvoiceAttachments::findOrFail($request->id_file);
        $invoices->delete(); //هيحذفه م الداتا بيز
        Storage::disk('public_uploads')->delete($request->invoice_number.'/'.$request->file_name); //هيحذفه م ن الملفات
        session()->flash('delete', 'تم حذف المرفق بنجاح');
        return back();
    }


    public function get_file($invoice_number,$file_name)

    {
        $contents= Storage::disk('public_uploads')->path($invoice_number.'/'.$file_name);
        return response()->download( $contents);
    }



    public function open_file($invoice_number,$file_name)

    {
        $files = Storage::disk('public_uploads')->path($invoice_number.'/'.$file_name);
        return response()->file($files);
    }
}
