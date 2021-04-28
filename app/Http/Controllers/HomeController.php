<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\invoices;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $all = invoices::count();
         //نسبة اعداد الفواتير
        $paid     = (invoices::where('value_status',1)->count('total') / $all)*100;
        $partpaid = (invoices::where('value_status',3)->count('total') / $all)*100;
        $unpaid   = (invoices::where('value_status',2)->count('total') / $all)*100;

        //مجموع كل نوع منهم
        $sum_paid   = invoices::where('value_status',1)->sum('total');
        $sum_p_paid = invoices::where('value_status',3)->sum('total');
        $sum_unpaid = invoices::where('value_status',2)->sum('total'); 



        $chartjs = app()->chartjs
        ->name('barChartTest')
        ->type('bar')
        ->size(['width' => 300, 'height' => 200])
        ->labels(['النسبه'])
        ->datasets([

            [
                "label" => "الفواتير  مدفوعه",
                'backgroundColor' => ['#AFFF7B','#AFFF7B'],
                'data' => [round($paid)]
            ],
            [
                "label" => "الفواتير المدفوعه جزئيا",
                'backgroundColor' => ['#FFC78C'],
                'data' => [round($partpaid)]
            ],
            [
                "label" => "الفواتير الغير مدفوعه",
                'backgroundColor' => ['#FCBFBF'],
                'data' => [round($unpaid)]
            ],
            




           /* [
                "label" => "الفواتير الغير مدفوعه",
                'backgroundColor' => ['red'],
                'data' => [20]
            ],
            [
                "label" => "الفواتير المدفوعه",
                'backgroundColor' => ['green'],
                'data' => [40],
            ],
            [
                "label" => "الفواتير المدفوعه جزئيا",
                'backgroundColor' => ['blue'],
                'data' => [20],
            ]*/
            
        ])
        ->options([]);

return view('home', compact('chartjs'));
    }
}
