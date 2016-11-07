<?php

namespace App\Http\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Core\ModelCore;

class User extends ModelCore implements AuthenticatableContract, CanResetPasswordContract {
	
	use Authenticatable, CanResetPassword, SoftDeletes;
	
	/**
	 * The table name
	 * @var $table
	 */
	protected $table = 'user';
	/**
	 * Let laravel set the created_at and updated_at value
	 * @var $timesamps
	 */

	protected $dates = ['deleted_at'];
	
	/**
	 * The attributes that should be hidden for arrays.
	 *
	 * @var array
	 */
	protected $hidden = ['password'];
	
	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	//protected $fillable = ['name', 'email', 'password'];
	
	/**
	 * Get user's primary phone
	 * @return \Illuminate\Database\Eloquent\Relations\HasMany
	 */
	public function primaryPhone()
	{
		return $this->hasOne('App\Http\Models\UserPhone', 'user_id')->where('primary','=','1');
	}
	

	/**
	 * This model's relation to area
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function area()
	{
		return $this->belongsTo('App\Http\Models\AppArea','location_assignment_code','area_code');
	}
	
	/**
	 * User's relation to user_group table
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function group()
	{
		return $this->belongsTo('App\Http\Models\UserGroup', 'user_group_id');
	}

	/**
	 * User's releation to contact_us table.
	 * @return \Illuminate\Database\Eloquent\Relations\HasMany
	 */
	public function contacts()
	{
		return $this->hasMany('App\Http\Models\ContactUs', 'user_id');
	}

	/**
	 * User's releation to contact_us table.
	 * @return \Illuminate\Database\Eloquent\Relations\HasMany
	 */
	public function logs()
	{
		return $this->hasMany('App\Http\Models\ContactUs', 'updated_by', 'id');
	}

	/**
	 * Query scope for filtering admin users
	 * @param unknown $query
	 */
	public function scopeAdmin($query)
	{
		 $id = \DB::table('user_group')->where(['name'=>'admin'])->value('id');
		 return $query->where('user_group_pk_id', '=', $id);
	}

	/**
	 * Query scope for filtering auditor users
	 * @param unknown $query
	 */
	public function scopeAuditor($query)
	{
		$id = \DB::table('user_group')->where(['name'=>'auditor'])->value('id');
		return $query->where('user_group_id', '=', $id);
	}

	/**
	 * Add  new Attribute column FullName.
	 * @return string
     */
	public function getFullNameAttribute()
	{
		return $this->firstname . " " . $this->lastname;
	}
	
	/**
	 * Overrides parent magic get to create a custom attribute
	 *
	 * @return string
	 */
	public function __get($key)
	{
		
		switch($key)
		{
			case 'fullname':
				return $this->attributes['firstname'] . ' ' .$this->attributes['lastname'] ;
			case 'formal_name':
				return $this->attributes['lastname'] . ', '. $this->attributes['firstname'];
			case 'gender_value':
				if($this->gender == 1)
				{
					return 'Male';
				}
				elseif($this->gender == 2)
				{
					return 'Female';
				}
				else
				{
					return '';
				}
		}
		
		return parent::__get($key);
	}
}
