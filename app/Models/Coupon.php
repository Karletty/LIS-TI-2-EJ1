<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Coupon
 * 
 * @property string $coupon_id
 * @property string $client_dui
 * @property int $offer_id
 * @property int $coupon_state_id
 * 
 * @property Client $client
 * @property Offer $offer
 * @property CouponState $coupon_state
 *
 * @package App\Models
 */
class Coupon extends Model
{
	protected $table = 'coupons';
	protected $primaryKey = 'coupon_id';
	public $incrementing = false;
	public $timestamps = false;

	protected $casts = [
		'offer_id' => 'int',
		'coupon_state_id' => 'int'
	];

	protected $fillable = [
		'client_dui',
		'offer_id',
		'coupon_state_id'
	];

	public function client()
	{
		return $this->belongsTo(Client::class, 'client_dui');
	}

	public function offer()
	{
		return $this->belongsTo(Offer::class);
	}

	public function coupon_state()
	{
		return $this->belongsTo(CouponState::class);
	}
}
