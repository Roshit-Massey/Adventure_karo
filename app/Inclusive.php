<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Inclusive extends Model
{
    use SoftDeletes;
    protected $fillable = [ 'title','status' ];
}
