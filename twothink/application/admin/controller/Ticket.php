<?php
/**
 * Created by PhpStorm.
 * User: DUHAILONG
 * Date: 2018/5/13
 * Time: 11:28
 */

namespace app\admin\controller;


class Ticket extends Admin
{
    /**
     * 报修列表
     */
    public function index()
    {
        $pid = input('get.pid', 0);
        /* 获取频道列表 */
        $map  = array('status' => array('gt', -1), 'pid'=>$pid);
        $list = \think\Db::name('Ticket')->where($map)->select();
        $this->assign('list', $list);
        $this->assign('pid', $pid);
        $this->assign('meta_title' , '报修管理');
        return $this->fetch();
        }

    /**
     * 添加报修
     * @return mixed|void
     */
    public function add()
    {
        if(request()->isPost()){
            $Ticket = model('ticket');
            $post_data=\think\Request::instance()->post();
            //自动验证
            $validate = validate('ticket');
            if(!$validate->check($post_data)){
                return $this->error($validate->getError());
            }

            $data = $Ticket->create($post_data);
            if($data){
                $this->success('新增成功', url('index'));
                //记录行为
                action_log('update_ticket', 'ticket', $data->id, UID);
            } else {
                $this->error($Ticket->getError());
            }
        } else {
            $pid = input('pid', 0);
            //获取父导航
            if(!empty($pid)){
                $parent = \think\Db::name('Ticket')->where(array('id'=>$pid))->field('title')->find();
                $this->assign('parent', $parent);
            }

            $this->assign('pid', $pid);
            $this->assign('info',null);
            $this->assign('meta_title', '新增报修');
            return $this->fetch('edit');
        }
        }

    public function edit($id = 0)
    {
        if($this->request->isPost()){
            $postdata = \think\Request::instance()->post();
            $Ticket = \think\Db::name("ticket");
            $data = $Ticket->update($postdata);
            if($data !== false){
                $this->success('编辑成功', url('index'));
            } else {
                $this->error('编辑失败');
            }
        } else {
            $info = array();
            /* 获取数据 */
            $info = \think\Db::name('Ticket')->find($id);

            if(false === $info){
                $this->error('获取配置信息错误');
            }

            $pid = input('get.pid', 0);
            //获取父导航
            if(!empty($pid)){
                $parent = \think\Db::name('Ticket')->where(array('id'=>$pid))->field('title')->find();
                $this->assign('parent', $parent);
            }

            $this->assign('pid', $pid);
            $this->assign('info', $info);
            $this->meta_title = '编辑报修';
            return $this->fetch();
        }
        }

    public function del()
    {
        $id = array_unique((array)input('id/a',0));

        if ( empty($id) ) {
            $this->error('请选择要操作的数据!');
        }

        $map = array('id' => array('in', $id) );
        if(\think\Db::name('ticket')->where($map)->delete()){
            //记录行为
            action_log('update_ticket', 'ticket', $id, UID);
            $this->success('删除成功');
        } else {
            $this->error('删除失败！');
        }
        }
}