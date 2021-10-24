<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductInformation extends Model
{
    use SoftDeletes;
    public $fillable = ['vendor_id', 'country_of_operation', 'pan_number', 'product_type', 'company_brief_description', 'language_ids'];
}
