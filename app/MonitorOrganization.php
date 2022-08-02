<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MonitorOrganization extends Model {
	public function organization() {
		return $this->belongsTo(Organizations::class, 'organization_id', 'organization_id');
	}

	public function monitor() {
		return $this->hasOne(Monitors::class, 'monitor_id', 'monitor_id');
	}
}
