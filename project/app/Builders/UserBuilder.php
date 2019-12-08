<?php
namespace App\Builders;

use App\Models\User;

class UserBuilder
{
    private $name;
    private $email;
    private $password;


    public function name(string $name)
    {
        $this->name = $name;
        return $this;
    }

    public function email(string $email)
    {
        $this->email = $email;
        return $this;
    }

    public function password(string $password)
    {
        $this->password = bcrypt($password);
        return $this;
    }

    public function get() : User
    {
        $user = new User();
        $user->name = $this->name;
        $user->email = $this->email;
        $user->password = $this->password;

        return $user;
    }
}
