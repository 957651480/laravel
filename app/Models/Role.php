<?php
/**
 * File Role.php
 *
 * @author Tuan Duong <bacduong@gmail.com>
 * @package Laravue
 * @version
 */
namespace App\Models;

class Role extends \Spatie\Permission\Models\Role
{
    public $guard_name = 'api';

}
