<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ExperienceImage extends Model
{
    use SoftDeletes;
    protected $fillable = [ 'experience_id','image','original_image_name','created_at','updated_at'];

    public function experience()
    {
        return $this->belongsTo(Experience::class);
    }
}
