<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TermCondition extends Model
{
    use SoftDeletes;
    public $fillable = ['vendor_id', 'terms_conditions', 'terms_conditions_checkbox'];
}
