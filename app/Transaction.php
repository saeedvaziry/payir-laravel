<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
  protected $table = 'transactions';

  public $fillable = [
    'transaction_id', 'amount', 'token', 'card_number', 'status', 'verify_status'
  ];
}