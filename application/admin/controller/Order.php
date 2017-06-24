<?php

namespace app\admin\controller;

use controller\BasicAdmin;
use service\DataService;
use think\Db;
use think\Request;
use  app\admin\model\Order as OrderModel;

/**
 * Order
 * @author    ShaoWei Pu <pushaowei0727@gmail.com>
 * @date      2017/6/24
 * @package   app\admin\controller
 * @license   Mozilla
 */
class Order extends BasicAdmin
{
    public $table = 'EschoolOrder';

    public function index(){
        $this->title = '订单列表';
        // 获取到所有GET参数
        $get = $this->request->get();
        // 实例Query对象

        $list = Db::table($this->table)
                ->alias('main')
                ->join('EschoolUser   u','u.id = main.user_id')
                ->join('EschoolTicket t','main.ticket = t.id')->select();
dd($list);
        // 实例化并显示
        //return parent::_list($list);
    }

}