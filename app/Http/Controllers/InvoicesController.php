<?php

namespace App\Http\Controllers;
use App\invoices;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\sections;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\invoices_details;
use App\invoice_attachments;
use App\User;
use App\Notifications\SendInvoice;
use App\Notifications\add_invoice;
use Illuminate\Support\Facades\Notification;
use App\Exports\InvoiceExport;
use Maatwebsite\Excel\Facades\Excel;


class InvoicesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $invoices = invoices::all();
        return view('invoices.invoices',compact('invoices'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $sections = sections::all();
        return view('invoices.add_invoice',compact('sections'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        invoices::create([
        'invoice_number'=>$request->invoice_number,
        'invoice_date'=>$request->invoice_date,
        'due_date'=>$request->due_date,
        'product'=>$request->product,
        'section_id'=>$request->section,
        'Amount_collection'=>$request->Amount_collection,
        'Amount_commission'=>$request->Amount_commission,
        'discount'=>$request->discount,
        'value_tax'=>$request->value_tax,
        'rate_tax'=>$request->rate_tax,
        'total'=>$request->total,
        'status'=>'غير مدفوعه',
        'value_status'=>2,
        'note'=>$request->note,
        'user'=>(Auth::user()->name),
        ]);

        $invoice_id = invoices::latest()->first()->id;
        invoices_details::create([
            'id_invoice'    =>$invoice_id,
            'invoice_number'=>$request->invoice_number,
            'product'       =>$request->product,
            'section'       =>$request->section,
            'Status'        =>'غير مدفوعه',
            'Value_Status'  =>2,
            'note'          =>$request->note,
            'user'          =>(Auth::user()->name),
        ]);
        if($request->hasFile('pic')){
            $invoice_id     = invoices::latest()->first()->id;
            $image          = $request->file('pic');
            $file_name      = $image->getClientOriginalName();
            $invoice_number = $request->invoice_number;
            
            $attachment     = new invoice_attachments();
            $attachment   -> file_name      = $file_name ;
            $attachment   -> invoice_number = $invoice_number;
            $attachment   -> created_by     = (Auth::user()->name);
            $attachment   ->invoice_id      = $invoice_id;
            $attachment ->save();

            //Move Pic
            $imageName  = $request->pic->getClientOriginalName();
            $request->pic->move(public_path('attachments/'.$invoice_number),$imageName);
        }

        // SEND Email Message ...  .. 

        //$user = User::first();
        //$email = Auth::user()->email; 

        //$user->notify(new SendInvoice($invoice_id));

        //Notification::send($user,new SendInvoice($invoice_id)); //--this line like above line^^--
        //******************************************************************************************** */
        // تحت الاشعارات و كيف بدنا نبعتها بالكنترولر
        $user = User::get();
        $invoices = invoices::latest()->first();

    
        Notification::send($user,new add_invoice($invoices));
    //$user->notify(new \App\Notifications\add_invoice($details));
     

        session()->flash('Add','تمت اٍضافة الفاتوره بنجاح');
        return back();

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\invoices  $invoices
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $invoices = invoices::where('id',$id)->first();
        return view('invoices.status_update',compact('invoices'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\invoices  $invoices
     * @return \Illuminate\Http\Response
     */
    public function edit( $id)
    {
        $invoices = Invoices::where('id',$id)->first();
        $sections = sections::all();
        return view('invoices.edit_invoice',compact('invoices','sections'));

        
        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\invoices  $invoices
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $invoices = invoices::findOrFail($request->invoice_id);
        $invoices->update([
            'invoice_number'=>$request->invoice_number,
        'invoice_date'=>$request->invoice_date,
        'due_date'=>$request->due_date,
        'product'=>$request->product,
        'section_id'=>$request->section,
        'Amount_collection'=>$request->Amount_collection,
        'Amount_commission'=>$request->Amount_commission,
        'discount'=>$request->discount,
        'value_tax'=>$request->value_tax,
        'rate_tax'=>$request->rate_tax,
        'total'=>$request->total,
        'status'=>'غير مدفوعه',
        'value_status'=>2,
        'note'=>$request->note,
        'user'=>(Auth::user()->name),
        ]);
        session()->flash('Update','تم تعديل الفاتوره بنجاح');
        return back();
        
    }
    public function status_update($id,Request $request)

    {
        $invoices = invoices::findOrFail($id);
        if($request->status ==='مدفوعه'){
            $invoices->update([
            
                'value_status'=>1,
                'status'=>'مدفوعه',
                'Payment_date'=>$request->payment_date,


                ]);

                invoices_details::create([
                'id_invoice'=>$request->id,
                'invoice_number'=>$request->invoice_number,
                
                'product'=>$request->product,
                'section'=>$request->section,
                
                'Value_Status'=>1,
                'Status'=>'مدفوعه',
                'note'=>$request->note,
                'Payment_Date'=>$request->payment_date,
                'user'=>(Auth::user()->name),
                ]);

        }
        else {
            $invoices->update([
                'value_status'=>3,
                'status'=>'مدفوعه جزئيا',
                'Payment_Date'=>$request->paument_date,

            ]);
            invoices_details::create([
                'id_invoice'=>$request->id,
                'invoice_number'=>$request->invoice_number,
                
                'product'=>$request->product,
                'section'=>$request->section,
                
                'Value_Status'=>3,
                'Status'=>'مدفوعه جزئيا',
                'note'=>$request->note,
                'Payment_Date'=>$request->payment_date,
                'user'=>(Auth::user()->name),
            ]);
        }
        session()->flash('Update','تم تعديل الفاتوره بنجاح');
        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\invoices  $invoices
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $id = $request->invoice_id;
        $invoices = invoices::where('id',$id)->first();
        $attachments = invoice_attachments::where('invoice_id',$id)->first();

        $id_page = $request->id_page;

        if (!$id_page==2){
            
            if(!empty ($attachments->invoice_number)){

                Storage::disk('public_uploads')->delete($attachments->invoice_number.'/'.$attachments->file_name);
            }

            //here remove the attachment from file before delete the all invoice from database عشان لو حذفنا الفاتوره ما رح يقدر يحذف المرفق لانه بالاصل انحذف^^
        
            $invoices->forceDelete();
        session()->flash('delete_invoice');
        return \redirect('invoices');
            

        }
        else{
            $invoices->delete();
            session()->flash('archive_invoice');
            return \redirect('Archive');

    }
    }


    
    public function getproducts($id){
        $products = DB::table('products')->where('section_id',$id)->pluck('product_name','id');
        return json_encode($products);
    }

    public function invoice_paid(){

        $invoices = invoices::where('value_status',1)->get();
        return view('invoices.invoices_paid',compact('invoices'));

    }

    public function invoice_unpaid(){

        $invoices = invoices::where('value_status',2)->get();
        return view('invoices.invoices_unpaid',compact('invoices'));
        
    }

    public function invoice_partial(){
        
        $invoices = invoices::where('value_status',3)->get();
        return view('invoices.invoices_partial',compact('invoices'));
    }

    public function print_invoice($id){
    
        $invoices = invoices::where('id',$id)->first();
        return view('invoices.print_invoice',compact('invoices'));


    }
    public function export() 
    {
        
        return Excel::download(new InvoiceExport, 'فاتوره.xlsx');
    }

    public function MarkAsRead_All(){
        $userUnreadNotification = auth()->user()->unreadNotifications;

        if($userUnreadNotification){
            $userUnreadNotification->markAsRead();
            return back();
        }
    }

    public function MarkAsRead_One(){
        $userUnreadNotification = auth()->user()->unreadNotifications;

        
            $userUnreadNotification->markAsRead();
            
       
    }
}
