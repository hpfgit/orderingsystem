<?php
namespace Home\Controller;
use Think\Controller;

class dishajax extends Controller {
    public function dish() {
        $model = M("order");
        $data = I("post.dishes");
        $number = I("post.number");
        $ret = $model->data($data)->add();
        if ($ret) {
            $this->ajaxReturn(array("msg"=>"success"));
        } else {
            $this->ajaxReturn(array("msg"=>"error"));
        }
    }
}