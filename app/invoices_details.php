<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class invoices_details extends Model
{
    protected $fillable = [
        'id_invoice',
        'invoice_number',
        'product',
        'section',
        'Status',
        'Value_Status',
        'note',
        'user',
        'Payment_Date'
    ];
    public function  sections()  //name of the function (name of column).
    {
        return $this->belongsTo('App\sections'); // after App/"the name of  model relation".
    }
}
