<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Employee
 * 
 * @property int $id
 * @property int $user_id
 * @property string|null $company_id
 * 
 * @property Company|null $company
 * @property User $user
 *
 * @package App\Models
 */
class Employee extends Model
{
	protected $table = 'employees';
	public $timestamps = false;

	protected $casts = [
		'user_id' => 'int'
	];

	protected $fillable = [
		'user_id',
		'company_id'
	];

	public function company()
	{
		return $this->belongsTo(Company::class);
	}

	public function user()
	{
		return $this->belongsTo(User::class);
	}
}
