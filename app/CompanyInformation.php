<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CompanyInformation extends Model
{
    use SoftDeletes;
    protected $table = 'company_informations';

    protected $fillable = ['vendor_id', 'company_name','legal_company_name' ,'country_id', 'state_id', 'city', 'postal_code', 'registered_address', 'registered_address_2', 'contact_number', 'company_website','hear_about_us','terms_condition','bank_name', 'acc_no', 'acc_holder_name', 'ifsc'];

    protected $appends = ['country', 'state'];

    public function getCountryAttribute()
    {
    	$country = Country::where('id', $this->country_id)->first();
    	if($country) {
    		return $country->name;
    	}
    }

    public function getStateAttribute()
    {
    	$state = State::where('id', $this->state_id)->first();
    	if($state) {
    		return $state->name;
    	}
    }

    public function users()
    {
        return $this->belongsTo(User::class, 'id', 'vendor_id');
    }
}
