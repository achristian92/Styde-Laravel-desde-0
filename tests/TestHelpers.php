<?php
/**
 * Created by PhpStorm.
 * User: alanruizaguirre
 * Date: 2019-02-11
 * Time: 11:33
 */

namespace Tests;


trait TestHelpers
{

    protected function assertDatabaseEmpty($table,$connection = null)
    {
        $total = $this->getConnection($connection)->table($table)->count();
        $this->assertSame(0,$total,sprintf(
            "Failed asserting the tabla [%s] is empty. %s %s found." ,$table,$total,str_plural('row',$total)
        ));
    }
    public function withData(array $custom = [])
    {

        return array_merge($this->defaultData(),$custom);
    }

    protected function defaultData()
    {
        return $this->defaultData;
    }
}