<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    protected $fillable = [ 'sort_name','name','phone_code'];

    public function states()
    {
        return $this->hasMany(State::class);
    }
}
