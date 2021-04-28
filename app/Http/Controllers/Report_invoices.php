<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\invoices;
use Illuminate\Support\Facades\DB;
use App\sections;

class Report_invoices extends Controller
{

    public function index(){

        return view('reports.invoices_reports');
    }

    public function search(Request $request){

        $rdio = $request->rdio;

        //في حالة البحث بنوع الفاتوره
        if($rdio ==1){
            
            //في حالة عدم تحديد تاريخ
            if($request->type =='الكل'){
                $type = $request->type ;
                $invoices = invoices::get();
                
                return view('reports.invoices_reports',compact('type'))->withDetails($invoices);
            

            }
            elseif($request->type && $request->start_at == '' && $request->end_at ==''){
                $invoices = invoices::select('*')->where('status','=',$request->type)->get();
                $type = $request->type;
                return view('reports.invoices_reports',compact('type'))->withDetails($invoices);

                

            }
            //في حالة تحديد تاريخ
            else{
                $start_at = date($request->start_at);
                $end_at   = date($request->end_at);
                $type = $request->type;
                $invoices  = invoices::select('*')->whereBetween('invoice_date',[$start_at,$end_at])->where('status','=',$type , 'OR','status','!=',$type);
                return view('reports.invoices_reports',compact('type','start_at','end_at'))->withDetails($invoices);

            }

        }
///////////////////////////////////////////////////////////////////////////////////////
// في حالة البحث برقم الفاتوره 
        else{
            $invoices = invoices::where('invoice_number',$request->invoice_number)->get();
            
            return view('reports.invoices_reports')->withDetails($invoices);


        }

    }
    public function cust_index(){
        $sections = sections::all();

        return view('reports.customer_report',compact('sections'));
    }
    public function search_cust_rep(Request $request){

        if($request->sec && $request->start_at == '' && $request->end_at == '' ){
            
            $invoices = invoices::select('*')->where('section_id','=',$request->section, 'and', 'product','=',$request->product )->get();
            $sec      = $request->sec;
            
            return view('reports.customer_report',compact('sec'))->withDetails($invoices);
        }
        
        
    }

    public function get_product($id){
        
        
        $product = DB::table('products')->where('section_id',$id)->pluck('product_name','id' );
        return json_encode($product);
    }
}
