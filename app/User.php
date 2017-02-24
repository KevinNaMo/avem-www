<?php

namespace Avem;

use Storage;
use Avem\Notifiable as AppNotifiable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable implements AppNotifiable
{
	use Notifiable;

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
		'name', 'surname', 'birthday', 'email', 'password',
	];

	/**
	 * The attributes that should be mutated to dates.
	 *
	 * @var array
	 */
	protected $dates = [
		'created_at', 'updated_at', 'birthday',
	];

	public static function boot()
	{
		parent::boot();

		User::deleting(function($user) {
			$user->setProfileImage(null);
		});
	}

	public function authMethods()
	{
		return $this->morphMany('auth_method');
	}

	public function directNotifications()
	{
		return $this->morphMany('Avem\Notification', 'notifiable');
	}

	public function filedClaims()
	{
		return $this->hasMany('Avem\Claim');
	}

	public function getFullNameAttribute()
	{
		$name = $this->attributes['name'];
		$surname = $this->attributes['surname'];
		return "$name $surname";
	}

	public function getImageUrlAttribute()
	{
		if (!$this->photo)
			return asset('img/user-default-image.svg');
		return Storage::url($this->photo);
	}

	public function getIsActiveAttribute()
	{
		return $this->renewals()->active()->exists();
	}

	public function getNotifiableReceiversAttribute()
	{
		return [$this];
	}

	public function hasPermission($name)
	{
		$this->load('roles.permissions');
		foreach ($this->roles as $role) {
			if ($role->permissions->contains('name', $name))
				return true;
		}
		return false;
	}

	public function inscribedActivities()
	{
		return $this->belongsToMany('Avem\Activity');
	}

	public function mbMember()
	{
		return $this->hasOne('Avem\MbMember', 'id');
	}

	public function notificationReceipts()
	{
		return $this->hasMany('Avem\NotificationReceipt');
	}

	public function ownRoles()
	{
		return $this->belongsToMany('Avem\Role', 'own_user_roles');
	}

	public function setProfileImage($file)
	{
		if ($this->photo) {
			Storage::delete($this->photo);
		}
		if ($file) {
			$this->photo = $file->store('profile', 'public');
			$this->save();
		}
	}

	public function subscribedActivities()
	{
		return $this->morphedByMany('Avem\Activity', 'subscribable');
	}

	public function subscribedActivityTasks()
	{
		return $this->morphedByMany('Avem\ActivityTask', 'subscribable');
	}

	public function renewals()
	{
		return $this->hasMany('Avem\Renewal');
	}

	public function roles()
	{
		return $this->belongsToMany('Avem\Role');
	}

	public function selfInscribedActivities()
	{
		return $this->belongsToMany('Avem\Activity', 'self_inscribed_activity_users');
	}

	public function selfSubscribedActivities()
	{
		return $this->morphedByMany('Avem\Activity', 'subscribable', 'own_subscribables');
	}

	public function selfSubscribedActivityTasks()
	{
		return $this->morphedByMany('Avem\ActivityTask', 'subscribable', 'own_subscribables');
	}

	public function transactions()
	{
		return $this->hasMany('Avem\Transaction');
	}
}
