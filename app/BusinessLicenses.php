<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BusinessLicenses extends Model
{
    use SoftDeletes;
    public $fillable = ['vendor_id','certificate_of_incorporation','pan_number','pan_image','gst_number','gst_image','other_document_images'];
}
