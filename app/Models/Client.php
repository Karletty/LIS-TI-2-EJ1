<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Client
 * 
 * @property string $dui
 * @property string $phone
 * @property string|null $address
 * @property string $token
 * @property int $user_id
 * @property bool $verified
 * 
 * @property UsersDatum $users_datum
 * @property Collection|Coupon[] $coupons
 *
 * @package App\Models
 */
class Client extends Model
{
	protected $table = 'clients';
	protected $primaryKey = 'dui';
	public $incrementing = false;
	public $timestamps = false;

	protected $casts = [
		'user_id' => 'int',
		'verified' => 'bool'
	];

	protected $hidden = [
		'token'
	];

	protected $fillable = [
		'phone',
		'address',
		'token',
		'user_id',
		'verified'
	];

	public function users_datum()
	{
		return $this->belongsTo(UsersDatum::class, 'user_id');
	}

	public function coupons()
	{
		return $this->hasMany(Coupon::class, 'client_dui')->onDelete('cascade');
	}
}
