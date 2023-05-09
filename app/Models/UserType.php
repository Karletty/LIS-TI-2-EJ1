<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class UserType
 * 
 * @property int $type_id
 * @property string $type_name
 * 
 * @property Collection|UsersDatum[] $users_data
 *
 * @package App\Models
 */
class UserType extends Model
{
	protected $table = 'user_types';
	protected $primaryKey = 'type_id';
	public $timestamps = false;

	protected $fillable = [
		'type_name'
	];

	public function users_data()
	{
		return $this->hasMany(UsersDatum::class, 'type_id');
	}
}
