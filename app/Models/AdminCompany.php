<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class AdminCompany
 * 
 * @property int $admin_companies_id
 * @property string $company_id
 * @property int $user_id
 * 
 * @property UsersDatum $users_datum
 * @property Company $company
 *
 * @package App\Models
 */
class AdminCompany extends Model
{
	protected $table = 'admin_companies';
	protected $primaryKey = 'admin_companies_id';
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
