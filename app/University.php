<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class University extends Model {


	public function matchEmailSuffix($email)
    {
        if (preg_match('/.*@'.$this->email_suffix.'\z/i', $email))
        {
            return true;
        }
        return false;
    }

}
