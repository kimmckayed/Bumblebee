<?php namespace App\Managers;


use Sentinel;

class AuthManager
{

    public function getUser()
    {
        try {
            $user = Sentinel::getUser();
        } catch (\Exception $e) {
            Sentinel::activate(Sentinel::forceCheck());
            $user = Sentinel::getUser();
        }

        return $user;
    }


    public function forceCheck()
    {

        return Sentinel::forceCheck();
    }


    public function check()
    {
        try {
            $user = Sentinel::check();
        } catch (\Exception $e) {
            $user = Sentinel::forceCheck();
        }

        return $user;
    }

    public function hasAccess(array $actions)
    {
        if ($this->getUser()) {
            if ($this->getUser()->hasAccess($actions)) {
                return true;
            }

            return false;
        }
        return false;
    }

    public function hasAnyAccess(array $actions)
    {
        if ($this->getUser()) {
            if ($this->getUser()->hasAnyAccess($actions)) {
                return true;
            }

            return false;
        }
        return false;
    }

    public function isRole($role)
    {
        if ($this->getUser()) {
            if ($this->getUser()->inRole($role)) {
                return true;
            }

            return false;
        }
        return false;
    }

    public function isAnyRole(array $roles)
    {
        if ($this->getUser()){
            foreach ($roles as $role) {
                if ($this->getUser()->inRole($role)) {
                    return true;
                }
            }

            return false;
        }
        return false;
    }

}