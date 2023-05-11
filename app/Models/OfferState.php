<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class OfferState
 * 
 * @property int $offer_state_id
 * @property string $offer_state_description
 * 
 * @property Collection|Offer[] $offers
 *
 * @package App\Models
 */
class OfferState extends Model
{
	protected $table = 'offer_states';
	protected $primaryKey = 'offer_state_id';
	public $timestamps = false;

	protected $fillable = [
		'offer_state_description'
	];

	public function offers()
	{
		return $this->hasMany(Offer::class, 'offer_state_id');
	}
}
