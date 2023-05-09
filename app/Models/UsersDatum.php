<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class UsersDatum
 * 
 * @property int $user_id
 * @property string $first_name
 * @property string $last_name
 * @property string $pass
 * @property string $email
 * @property int $type_id
 * 
 * @property UserType $user_type
 * @property Collection|Client[] $clients
 * @property Collection|Employee[] $employees
 *
 * @package App\Models
 */
class UsersDatum extends Model
{
	protected $table = 'users_data';
	protected $primaryKey = 'user_id';
	public $timestamps = false;

	protected $casts = [
		'type_id' => 'int'
	];

	protected $fillable = [
		'first_name',
		'last_name',
		'pass',
		'email',
		'type_id'
	];

	public function user_type()
	{
		return $this->belongsTo(UserType::class, 'type_id');
	}

	public function clients()
	{
		return $this->hasMany(Client::class, 'user_id');
	}

	public function employees()
	{
		return $this->hasMany(Employee::class, 'user_id');
	}
}
