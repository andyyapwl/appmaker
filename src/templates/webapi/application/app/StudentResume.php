<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StudentResume extends Model
{
    public function student()
   {
     return $this->belongsTo(Student::class);
   }
   
    public function status()
   {
     return $this->belongsTo(ResumeStatus::class);
   }
   
    
}
