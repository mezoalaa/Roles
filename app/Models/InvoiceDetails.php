<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class InvoiceDetails extends Model
{
    use HasFactory;
    protected $fillable = [
        'lineNo',
        'product_name',
        'unitfk',
        'pricedecimal',
        'quantity',
        'total',
        'expiredate',
    ];

    public function unit(){
        return $this->belongsTo(unit::class);
    }
}
