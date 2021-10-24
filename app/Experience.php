<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Experience extends Model
{
    use SoftDeletes;
    protected $fillable = [ 'title','info','details','image','original_image_name', 'country_id', 'state_id', 'city_id', 'status'];

    public function country()
    {
        return $this->belongsTo(Country::class);
    }

    public function state()
    {
        return $this->belongsTo(State::class);
    }

    public function city()
    {
        return $this->belongsTo(City::class);
    }

    public function experience_images()
    {
        return $this->hasMany(ExperienceImage::class);
    }
}
