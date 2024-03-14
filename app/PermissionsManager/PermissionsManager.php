<?php

namespace App\PermissionsManager;

class PermissionsManager
{
    /**
     * The permissions that this user level can access
     * 
     * @var array
     */
    public $permissions = array();

    /**
     * Function to return the permissions
     */
    public function getPermissions(): array
    {
        return $this->permissions;
    }
}