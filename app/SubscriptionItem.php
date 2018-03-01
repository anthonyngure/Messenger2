<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SubscriptionItem extends Model
{
    //
	
	public function clientSubscription()
	{
		return $this->hasOne(ClientSubscription::class);
	}
}
