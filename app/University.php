<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class University extends Model {


	public function matchEmailSuffix($email)
    {
        return substr($email, strlen($this->email_suffix)-1) === $this->email_suffix;
    }

}
