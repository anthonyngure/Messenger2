<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Client
 *
 * @property int $id
 * @property string $name
 * @property string $logo
 * @property string $email
 * @property string $phone
 * @property float $latitude
 * @property float $longitude
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Client whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Client whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Client whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Client whereLatitude($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Client whereLogo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Client whereLongitude($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Client whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Client wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Client whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property string $primary_color
 * @property string $accent_color
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Delivery[] $deliveries
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Client whereAccentColor($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Client wherePrimaryColor($value)
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Subscription[] $subscriptions
 */
class Client extends Model
{
    //
	
	/**
	 * @return \Illuminate\Database\Eloquent\Relations\HasMany
	 */
	public function deliveries()
	{
		return $this->hasMany(Delivery::class);
	}
	
	public function subscriptions()
	{
		return $this->hasManyThrough(Subscription::class, ClientSubscription::class);
	}
}
