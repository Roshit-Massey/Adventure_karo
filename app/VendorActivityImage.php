<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class VendorActivityImage extends Model
{
    use SoftDeletes;
    protected $fillable = [ 'vendor_activity_id','image','original_image_name'];

    public function vendor_activity()
    {
        return $this->belongsTo(VendorActivity::class);
    }
}
