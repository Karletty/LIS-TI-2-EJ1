<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Employee
 * 
 * @property int $employee_id
 * @property string $company_id
 * @property int $user_id
 * 
 * @property UsersDatum $users_datum
 * @property Company $company
 *
 * @package App\Models
 */
class Employee extends Model
{
	protected $table = 'employees';
	protected $primaryKey = 'employee_id';
	public $timestamps = false;

	protected $casts = [
		'user_id' => 'int'
	];

	protected $fillable = [
		'company_id',
		'user_id'
	];

	public function users_datum()
	{
		return $this->belongsTo(UsersDatum::class, 'user_id');
	}

	public function company()
	{
		return $this->belongsTo(Company::class);
	}
}
