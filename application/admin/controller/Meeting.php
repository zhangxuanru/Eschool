<?php

namespace app\admin\controller;

use controller\BasicAdmin;
use service\DataService;
use think\Db;
use think\Request;

/**
 * Meeting
 * @author    ShaoWei Pu <pushaowei0727@gmail.com>
 * @date      2017/6/21
 * @package   app\admin\controller
 * @license   Mozilla
 */
class Meeting  extends BasicAdmin
{
    public $table = 'EschoolMeeting';

    /**
     * 会议管理
     */
    public function index(){
        // 设置页面标题
        $this->title = '会议管理';
        // 获取到所有GET参数
        $get = $this->request->get();
        // 实例Query对象
        $db = Db::name($this->table)->where('status', '1');

        // 应用搜索条件
        foreach (['m_topic'] as $key) {
            if (isset($get[$key]) && $get[$key] !== '') {
                $db->where($key, 'like', "%{$get[$key]}%");
            }
        }
        // 实例化并显示
        return parent::_list($db);
    }

    /**
     * 会议操作
     */
    public function meeting(){
        if ($this->request->isGet()) {
            $id = $this->request->get('id','');
            return view('form', ['title' => '发表会议','id'=> $id,'vo' => Db::name('Meeting')->where('id',$id)->find()]);
        }
        if ($this->request->isPost()) {
            $data = $this->request->post();
            if ($this->_apply_news_meeting($data['data']) ) {
                return  "<script>window.location='#/meeting/index'</script>";
            }
            $this->error('会议编辑失败，请稍候再试！');
        }
    }

    /**
     * 更新操作
     * @param array $data
     * @param array $ids
     * @return string
     */
    protected function _apply_news_meeting($data) {
        $data['o_id']       = session('user.id');
        $data['start_time'] = strtotime($data['start_time']);
        $data['end_time']   = strtotime($data['end_time']);
        $data['apply_time'] = strtotime($data['apply_time']);
        $data['m_content']  = empty($data['m_content']) ? strip_tags( $data['m_content']) : $data['m_content'];
        if (empty($data['id'])) {
            $result = $id = Db::name('Meeting')->insertGetId($data);
        } else {
            $id = intval($data['id']);
            $result = Db::name('Meeting')->where('id', $id)->update($data);
        }
        if ($result !== FALSE) {
            return true;
        }
    }

    /**
     * 关闭
     */
    public function forbid(){
        if($this->request->isPost()){
            $data = $this->request->post();
            $result = Db::name($this->table)->where('id', $data['id'])
                        ->update([$data['field'] => $data['value']]);
            if( $result !== FALSE ){
                $this->success('操作成功','');
            }
            $this->error('操作失败');
        }
    }

    /**
     * 课件管理
     */
    public function courseware(){

    }

    /**
     * 签到管理
     */
    public function sigin(){

    }

    /**
     * 报名管理
     */
    public function apply(){

    }

    /**
     * 会员管理
     */
    public function member(){

    }

    /**
     * 会议日程
     */
    public function schedule(){

    }

    /**
     * 通知管理
     */
    public function notice(){

    }



}
