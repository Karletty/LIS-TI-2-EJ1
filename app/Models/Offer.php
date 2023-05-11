<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Offer
 * 
 * @property int $offer_id
 * @property string $title
 * @property int $limit_qty
 * @property string $offer_description
 * @property string|null $details
 * @property Carbon $start_date
 * @property Carbon $end_date
 * @property float $original_price
 * @property float $offer_price
 * @property string $company_id
 * @property int $offer_state_id
 * @property string|null $justification
 * @property Carbon $deadline_date
 * @property int $available_qty
 * 
 * @property Company $company
 * @property OfferState $offer_state
 * @property Collection|Coupon[] $coupons
 *
 * @package App\Models
 */
class Offer extends Model
{
	protected $table = 'offers';
	protected $primaryKey = 'offer_id';
	public $timestamps = false;

	protected $casts = [
		'limit_qty' => 'int',
		'start_date' => 'datetime',
		'end_date' => 'datetime',
		'original_price' => 'float',
		'offer_price' => 'float',
		'offer_state_id' => 'int',
		'deadline_date' => 'datetime',
		'available_qty' => 'int'
	];

	protected $fillable = [
		'title',
		'limit_qty',
		'offer_description',
		'details',
		'start_date',
		'end_date',
		'original_price',
		'offer_price',
		'company_id',
		'offer_state_id',
		'justification',
		'deadline_date',
		'available_qty'
	];

	public function company()
	{
		return $this->belongsTo(Company::class);
	}

	public function offer_state()
	{
		return $this->belongsTo(OfferState::class);
	}

	public function coupons()
	{
		return $this->hasMany(Coupon::class)->onDelete('cascade');
	}
}
