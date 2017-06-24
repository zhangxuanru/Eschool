<?php

namespace app\admin\model;

use think\Model;

class Meeting extends Model
{
    protected $table = 'eschool_meeting';

    public function apply()
    {
        return $this->hasOne('apply','m_id');
    }
}
