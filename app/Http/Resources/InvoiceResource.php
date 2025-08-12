<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class InvoiceResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'=>$this->id,
            'customer_id'=>$this->customer_id,
            'user_id'=>$this->user_id,
            'invoice_date'=>$this->invoice_date,
            'total_amount'=>$this->total_amount,
            'status'=>$this->status
        ];
    }
}
