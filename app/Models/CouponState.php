<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class CouponState
 * 
 * @property int $coupon_state_id
 * @property string $state_name
 * 
 * @property Collection|Coupon[] $coupons
 *
 * @package App\Models
 */
class CouponState extends Model
{
	protected $table = 'coupon_states';
	protected $primaryKey = 'coupon_state_id';
	public $timestamps = false;

	protected $fillable = [
		'state_name'
	];

	public function coupons()
	{
		return $this->hasMany(Coupon::class);
	}
}
