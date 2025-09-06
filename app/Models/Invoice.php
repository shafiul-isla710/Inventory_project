<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    protected $fillable = ['customer_id', 'user_id', 'invoice_number', 'invoice_date', 'total_amount', 'notes', 'status','order_id'];

    public function InvoiceDetails()
    {
        return $this->hasMany(InvoiceDetails::class);
    }
}
