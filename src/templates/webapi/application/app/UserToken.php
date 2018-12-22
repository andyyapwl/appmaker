<?php

namespace App;
use App\User;

class UserToken 
{	
    public $id=0;
	public $name="";
	public $email="";
	public $username="";
	public $first_name="";
	public $last_name="";
	public $is_admin=false;
	public $status_id=0;
	public $is_active=false;
	public $created_by=0;
	public $modified_by=0;
	public $created_at=0;
	public $updated_at=0;
	
	public function import(Object $object)
    {   
        foreach (get_object_vars($object) as $key => $value) {
			if(isset($this->$key))
				$this->$key = $value;
        }
    }   
}
