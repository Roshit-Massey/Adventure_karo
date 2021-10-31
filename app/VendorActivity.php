<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class VendorActivity extends Model
{
    use SoftDeletes;
    protected $fillable = ['vendor_id','activity_id','inclusives','exclusives','days', 'start_time', 'end_time', 'info'];

    public function vendor_activity_images()
    {
        return $this->hasMany(VendorActivityImage::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'id', 'vendor_id');
    }

    public function activity()
    {
        return $this->belongsTo(Activity::class);
    }
}
