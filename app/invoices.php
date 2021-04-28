<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class invoices extends Model
{
    use SoftDeletes;
    protected $fillable=[
        'invoice_number',
        'invoice_date',
        'due_date',
        'product',
        'section_id',
        'Amount_collection',
        'Amount_commission',
        'discount',
        'value_tax',
        'rate_tax',
        'total',
        'status',
        'value_status',
        'note',
        'Payment_Date',
        'user'

    ];
    protected $dates = ['deleted_at'];
    public function  sections()  //name of the function (name of column).
    {
        return $this->belongsTo('App\sections','section_id'); // after App/"the name of  model relation".
    }
}
