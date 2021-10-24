<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ActivityImage extends Model
{
    use SoftDeletes;
    protected $fillable = [ 'activity_id','image','original_image_name','created_at', 'updated_at'];

    public function activity()
    {
        return $this->belongsTo(Activity::class);
    }
}
