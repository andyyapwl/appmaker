<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\User;

class UserProfile extends Model
{
    protected $fillable = ['profile_url', 'mobile'];
	public function user()
	{
		return $this->belongsTo(User::class);
	}
}
