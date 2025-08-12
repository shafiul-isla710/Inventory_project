<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InvoiceDetails extends Model
{
    protected $fillable = ['invoice_id', 'product_id','total_amount', 'quantity', 'amount'];

    public function Invoice()
    {
        return $this->belongsTo(Invoice::class);
    }
}
