<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Company
 * 
 * @property string $company_id
 * @property string $company_name
 * @property string $address
 * @property string $contact_name
 * @property string $phone
 * @property string $email
 * @property float $commission_percentage
 * @property int $category_id
 * 
 * @property Category $category
 * @property Collection|AdminCompany[] $admin_companies
 * @property Collection|Employee[] $employees
 * @property Collection|Offer[] $offers
 *
 * @package App\Models
 */
class Company extends Model
{
	protected $table = 'companies';
	protected $primaryKey = 'company_id';
	public $incrementing = false;
	public $timestamps = false;

	protected $casts = [
		'commission_percentage' => 'float',
		'category_id' => 'int'
	];

	protected $fillable = [
            'company_id',
		'company_name',
		'address',
		'contact_name',
		'phone',
		'email',
		'commission_percentage',
		'category_id'
	];

	public function category()
	{
		return $this->belongsTo(Category::class);
	}

	public function admin_companies()
	{
		return $this->hasMany(AdminCompany::class);
	}

	public function employees()
	{
		return $this->hasMany(Employee::class);
	}

	public function offers()
	{
		return $this->hasMany(Offer::class);
	}
}
