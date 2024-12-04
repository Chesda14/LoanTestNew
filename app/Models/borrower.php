<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class borrower extends Model
{
    use HasFactory;

    protected $table="borrower";
    protected $fillable = [
        'firstname',
        'lastname',
        'genderId',
        'contact',
        'address',
        'email',
        'taxid'
        ];
}
