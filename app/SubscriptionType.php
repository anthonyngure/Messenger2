<?php
	
	namespace App;
	
	use Illuminate\Database\Eloquent\Model;
	
	/**
	 * App\SubscriptionType
	 *
	 * @mixin \Eloquent
	 */
	class SubscriptionType extends Model
	{
		//
		
		/**
		 * @return \Illuminate\Database\Eloquent\Relations\HasMany
		 */
		public function subscriptionItems()
		{
			return $this->hasMany(SubscriptionItem::class);
		}
	}
