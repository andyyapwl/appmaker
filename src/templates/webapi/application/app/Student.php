<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class Student extends Model
{
    use LogsActivity;
    

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'students';

    /**
    * The database primary key value.
    *
    * @var string
    */
    protected $primaryKey = 'id';

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['title', 'gender', 'identificationNo','preferred_contact_number','class_name','profile_pic_url','dob','user_id','nationality_id','race_id','school_id'];

    public function nationality()
    {
        return $this->belongsTo('App\Nationality');
    }
    public function race()
    {
        return $this->belongsTo('App\Race');
    }
    public function user()
    {
        return $this->belongsTo('App\User');
    }
    public function school()
    {
        return $this->belongsTo('App\School');
    }
    

    /**
     * Change activity log event description
     *
     * @param string $eventName
     *
     * @return string
     */
    public function getDescriptionForEvent($eventName)
    {
        return __CLASS__ . " model has been {$eventName}";
    }
}
