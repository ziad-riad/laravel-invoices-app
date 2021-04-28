<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\sections;
use App\invoices;
use Illuminate\Support\Facades\DB;


class Customer_Reports extends Controller
{
    public function cust_index(){
        
        $sections = sections::all();

        return view('reports.customer_report',compact('sections'));
    }
    
    public function search_cust_rep(Request $request){
        //في حالة عدم تحديد تواريخ
        if($request->section && $request->product && $request->start_at == '' && $request->end_at == '' ){
            
        $invoices = invoices::select('*')->where('section_id','=',$request->section, 'and', 'product','=',$request->product )->get();
           
        $sections = sections::all();
            
            return view('reports.customer_report',compact('sections'))->withDetails($invoices);
        }
        //في حالة تحديد تواريخ
        else{
            $start = date($request->start_at);
            $end   =date($request->end_at);
            $invoices = invoices::select('*')->whereBetween('invoice_date',[$start,$end])->where('section_id','=',$request->section,'and','product','=',$request->product)->get();
            $sections = sections::all();
            return view('reports.customer_report',compact('start','end','sections'))->withDetails($invoices);


        }
        
        
    }

    public function get_product($id){
        
        
        $product = DB::table('products')->where('section_id',$id)->pluck('product','id' );
        return json_encode($product);
    }
}
