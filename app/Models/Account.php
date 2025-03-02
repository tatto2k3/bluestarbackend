<?php

namespace App\Models;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;

class Account extends Model implements Authenticatable
{
    protected $table = 'accounts';
    public $timestamps = false;
    protected $primaryKey = 'email';
    public $incrementing = false;

    // Phương thức của Authenticatable
    public function getAuthIdentifierName()
    {
        return 'email'; // Tên cột ID
    }

    public function getAuthIdentifier()
    {
        return $this->{$this->getAuthIdentifierName()};
    }

    public function getAuthPassword()
    {
        return $this->password; // Tên cột mật khẩu
    }

    public function getRememberToken()
    {
        return $this->remember_token; // Tên cột remember token (nếu có)
    }

    public function setRememberToken($value)
    {
        $this->remember_token = $value; // Tên cột remember token (nếu có)
    }

    public function getRememberTokenName()
    {
        return 'remember_token'; // Tên cột remember token (nếu có)
    }
}

