<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Activity extends Model
{
    use SoftDeletes;
    protected $fillable = [ 'title','info','details','image','original_image_name', 'status'];

    public function activity_images()
    {
        return $this->hasMany(ActivityImage::class);
    }

    public function vendor_activities()
    {
        return $this->hasMany(VendorActivity::class);
    }
}
