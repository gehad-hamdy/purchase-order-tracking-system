<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;

    protected $fillable = [
      'invoice_number',
      'supplier_name',
      'currency',
      'amount',
      'invoice_date',
      'financial_account_id'
    ];
}
