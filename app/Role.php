<?php
/**
 * Created by PhpStorm.
 * User: alanruizaguirre
 * Date: 2019-02-11
 * Time: 09:57
 */

namespace App;


class Role
{
    public static function getList()
    {
        return ['admin','user'];
    }
}