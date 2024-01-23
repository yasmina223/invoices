<?php

namespace App\Http\Controllers;

use App\Models\InvoiceAttachments;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
class InvoiceAttachmentsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
        $this->validate($request, [

            'file_name' => 'mimes:pdf,jpeg,png,jpg',

            ], [
                'file_name.mimes' => 'صيغة المرفق يجب ان تكون   pdf, jpeg , png , jpg',
            ]);

            $image = $request->file('file_name');
            $file_name = $image->getClientOriginalName();
            $attachments =  new InvoiceAttachments();
            $attachments->file_name = $file_name;
            $attachments->invoice_number = $request->invoice_number;
            $attachments->invoice_id = $request->invoice_id;
            $attachments->Created_by = Auth::user()->name;
            $attachments->save();

             // move pic
        $imageName = $request->file_name->getClientOriginalName();
        $request->file_name->move(public_path('Attachments/'. $request->invoice_number), $imageName);

        session()->flash('Add', 'تم اضافة المرفق بنجاح');
        return back();
    }

    /**
     * Display the specified resource.
     */
    public function show(InvoiceAttachments $invoiceAttachments)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(InvoiceAttachments $invoiceAttachments)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, InvoiceAttachments $invoiceAttachments)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(InvoiceAttachments $invoiceAttachments)
    {
        //
    }
}
