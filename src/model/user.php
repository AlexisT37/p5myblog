<?php

namespace Application\Model\User;

class User
{
    public int $id;
    public string $email;
    public string $username;
    public string $password;
    public array $roles;
}
