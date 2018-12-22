<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ResumeFile extends Model
{
	private $_fileContent;
	
	protected $appends = ['fileContent'];
	
	public function getFileContentAttribute()
    {
        return $this->_fileContent; 
    }
	public function setFileContentAttribute($value)
    {
        $this->_fileContent = $value; 
    }
}
