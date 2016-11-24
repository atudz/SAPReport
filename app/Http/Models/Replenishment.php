<?php

namespace App\Http\Models;

use App\Core\ModelCore;
use Illuminate\Database\Eloquent\SoftDeletes;

class Replenishment extends ModelCore
{
	
	use SoftDeletes;
	
	protected $table = 'replenishment';
	
	protected $fillable = [
			'reference_number',
			'van_code',
			'replenishment_date',
			'replenishment_date',
			'counted',
			'confirmed',
			'last_sr',
			'last_rprr',
			'last_cs',
			'last_dr',
			'last_ddr',
	];
	
	const ACTUAL_COUNT_TYPE = 'actual_count';
	const REPLENISHMENT_TYPE = 'replenishment';
	
	
	/**
	 * This model's relation to details
	 * @return \Illuminate\Database\Eloquent\Relations\HasMany
	 */
	public function items()
	{
		return $this->hasMany('App\Http\Models\ReplenishmentItem','reference_number','reference_number');
	}
}
