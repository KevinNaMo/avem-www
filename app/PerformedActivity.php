<?php

namespace Avem;

use Auth;
use Illuminate\Database\Eloquent\Model;

class PerformedActivity extends Model
{
	public function activity()
	{
		return $this->belongsTo('Avem\Activity');
	}

	public function activityTicket()
	{
		return $this->hasOne('Avem\ActivityTicket');
	}

	public function transaction()
	{
		return $this->morphOne('Avem\Transaction');
	}

	public function user()
	{
		return $this->belongsTo('Avem\User');
	}

	public function witnessPeriod()
	{
		return $this->belongsTo('Avem\ChargePeriod', 'charge_period_id');
	}
}
