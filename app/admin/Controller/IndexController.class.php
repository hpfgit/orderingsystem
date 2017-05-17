<?php
namespace admin\Controller;
use Think\Controller;
class IndexController extends Controller {
    public function index(){
       	$model = new D('User');
    }
}