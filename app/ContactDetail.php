<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ContactDetail extends Model
{
    use SoftDeletes;
    public $fillable = ['vendor_id', 'title_id', 'name', 'designation', 'email', 'primary_contact_number', 'secondary_contact_number'];
}
