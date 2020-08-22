<?php
/**
 * File Permission.php
 *
 * @author Tuan Duong <bacduong@gmail.com>
 * @package Laravue
 * @version 1.0
 */

namespace App\Models;

class Permission extends \Spatie\Permission\Models\Permission
{
    public $guard_name = 'api';

}
