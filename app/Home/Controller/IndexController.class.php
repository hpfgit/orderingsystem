<?php
namespace Home\Controller;
use Think\Controller;
use Think\Model;

class IndexController extends Controller {
    public function index() {
        if (!empty($_POST)) {
            $model = M('user');
            $username = $_POST['username'];
            $userpass = $_POST['userpass'];
            $ret = $model->where("username='$username' AND userpass='$userpass'")->select();
            if ($ret) {
                if ($ret[0]['jurisdiction'] == "管理员") {
                    $this->success('登录成功！请稍后', 'login', 1);
                    return false;
                } else if ($ret[0]['jurisdiction'] == "服务员") {
                    $this->success("登陆成功！请稍后", "waiter", 1);
                    $this->display("waiter");
                    return false;
                }
            } else {
                $this->error("用户名或密码错误，请重新填写", "index", 30);
            }
        }
        $this->display('login');
    }
    public function login() {
        $model = M('order');
        $data = $model->select();
        $this->assign('data',$data);
        $model = M('user');
        $alluser = $model->select();
        $ni = "nihao";
        $this->assign('alluser',$alluser)->assign("nihao",$ni);
        $this->display('index');
    }
    public function orderManagement() {
        $model = M('order');
        $userdata = $model->where("state=0")->select();
        $userdataid = "userdataid";
        if ($userdata) {
            $this->assign('userdata', $userdata)->assign("userdataid", $userdataid);
        }
        $this->display('user');
    }
    public function order() {
        $model = M('menu');
        $menudata = $model->select();
        $this->assign('menudata',$menudata);
        $this->display('ordering');
    }
    // 添加用户
    public function adduser() {
        if (!empty($_POST)) {
            $model = M('user');
            $data['username'] = I('post.username');
            $data['userpass'] = I('post.userpass');
            $data["jurisdiction"] = I("post.jurisdiction");
            $ret = $model->data($data)->add();
            if ($ret) {
                $this->success('添加成功','login');
            }
        }
        $adduserid = "adduserid";
        $this->assign('adduserid',$adduserid);
        $this->display('user');
    }
    public function oneuser() {
        $model = M('user');
        $id = I('get.id');
        $oneuser = $model->where("id=$id")->select();
        $oneuserid = "oneuserid";
        $this->assign('oneuser',$oneuser)->assign("oneuserid",$oneuserid);
        $this->display('user');
    }
    // 查询订单
    public function queryorder() {
        $model = M('userordering');
        if (empty($_POST)) {
            $username = $_POST['username'];
            $queryorder = $model->where("username='$username'")->select();
            $queryorderid = "queryorderid";
            $this->assign('queryordering',$queryorder)->assign('queryorderid',$queryorderid);
        }
        $this->display('queryorder');
    }
    // 订单管理
//    public function administrationorder() {
//        $model = M('order');
//        $menumodel = new Model();
//        $page = $this->GetPage();
//        $state = I("get.state");
//        $userdataid = "userdataid";
//        $count = $model->where("state='$state'")->count();
//        $pagedata = 5;
//        $pagenum = ceil($count/$pagedata);
//        $data = $model->field("dishesuser")->select();
//        $arr = array();
//        $arr2 = array();
//        $arr3 = array();
//        $num = 0;
//        foreach ($data as $item) {
//            foreach ($item as $value) {
//                $arr[] = $value;
//            }
//        }
//        $arr = array_unique($arr);
//        foreach ($arr as $item) {
//            $arr2[$num++] = $model->where("dishesuser=$item AND state=$state")->select();
//        }
//        for ($i=0;$i<count($arr2);$i++) {
//            if (count($arr2[$i]) > 1) {
//                $num2 = 0;
//                foreach ($arr2[$i] as $value) {
//                    $ret = $menumodel->query("SELECT `dishes` FROM `menu` WHERE `id`={$value['dishesnum']}");
//                    foreach ($ret as $value) {
//                        foreach ($value as $value) {
//                            $arr2[$i][$num2++]["dishes"] = $value;
//                        }
//                    }
//                }
//            } else {
//                foreach ($arr2[$i] as $value) {
//                    $ret = $menumodel->query("SELECT `dishes` FROM `menu` WHERE `id`={$value['dishesnum']}");
//                    foreach ($ret as $value) {
//                        foreach ($value as $value) {
//                            $arr2[$i][0]["dishes"] = $value;
//                        }
//                    }
//                }
//            }
//        }
//        $arr2 = array_filter($arr2);
//        $arr3 = $this->pageorder($arr2);
//        $pagedata = $model->order("dishesuser")->join("menu ON menu.id=order.dishesnum")->where("state=$state")->page($page,$pagedata)->select();
//        $this->assign("pagedata",$pagedata)->assign("userdataid",$userdataid)->assign("state",$state)->assign("total",$pagenum)->assign("count",$count)->assign("controller","administrationorder");
//        $this->PageList($page,$pagenum,$state,"administrationorder");
//        $this->display("user");
//    }
    // 订单管理
    public function administrationorder() {
        $model = M('order');
        $table = M("tablenumbers");
        $kong = new Model();
        $data = $model->field("dishesuser")->select();
        $page = $this->GetPage();
        $start = ($this->GetPage()-1) * 5;
        $state = I("get.state");
        $end = $this->GetPage()*5;
        $num = 0;
        $total = 0;
        $arr = array();
        $arr1 = array();
        foreach ($data as $item) {
            foreach ($item as $value) {
                $arr1[] = $value;
            }
        }
        $arr1 = array_unique($arr1);
        foreach ($arr1 as $item) {
//            foreach ($item as $item) {
                $dishesnum = $model->where("dishesuser='$item'")->select();
                if (!$dishesnum) {echo "123";}
                $dishesnum = $dishesnum[0]["dishesnum"];
                $arr[$num++] = $kong->query("SELECT * FROM `menu` m INNER JOIN `order` o ON m.id IN ($dishesnum) WHERE o.dishesuser='$item' AND o.state=$state");
//            }
        }
        $arr = array_filter($arr);
        sort($arr,SORT_NATURAL);
        $count = count($arr);
        $pagenum = ceil($count/5);
        $config = array(
            "arr"=>$arr,
            "totals"=>$total,
            "pagenum"=>$end,
            "page"=>$start,
            "pagedata"=>$pagedata,
            "userdataid"=>"userdataid",
            "state"=>$state,
            "total"=>$pagenum,
            "count"=>$count,
            "controller"=>"administrationorder"
        );
        $this->assign($config);
        $this->PageList($page,$pagenum,$state,"administrationorder");
        $this->display("user");
    }
    public function ownorder() {
        $model = M("userordering");
        $model = M("userordering");
        $currentid =I("get.id");
        $current = $model->where("id=$id")->select();
        $this->assign("current",$current);
        $this->display('');
    }
    // 服务员
    public function waiter() {
        $model = M("userordering");
        $vieworder = $model->select();
        $this->assign("vieworder",$vieworder);
        $this->display("waiter");
    }
    // 查看订单
    public function vieworder() {
        $model = M("userordering");
        $id = I("get.id");
        $onevieworder = $model->where("id=$id")->select();
        $onevieworderid = "onevieworderid";
        $this->assign("onevieworder",$onevieworder)->assign("onevieworderid",$onevieworderid);
        $this->display("user");
    }
    // 所有的菜
    public function cai() {
        $model = M('menu');
        $page = $this->GetPage();
        $count = $model->count();
        $pagedata = 5;
        $pagenum = ceil($count/$pagedata);
        $caidata = $model->order("dishes")->page($page,$pagedata)->select();
        $dataid = "dataid";
        $this->PageList($page,$pagenum,$state,"cai");
        $this->assign('caidata',$caidata)->assign("dataid",$dataid)->assign("controller",'cai')->assign("total",$pagenum);
        $this->display('user');
    }
    // 添加菜品
    public function adddishes() {
        if (!empty($_POST)) {
            $upload = new \Think\Upload();
            $upload->maxSize = 1024 * 1024 * 1024;
            $upload->subName = date("Ymd");
            $upload->exts = array('jpg', 'gif', 'png', 'jpeg');
            $upload->savePath = "/thumb/";
            $info = $upload->upload();
            if (!$info) {//  上传错误提示错误信息
                $this->error($upload->getError());
            } else {//  上传成功
                foreach ($info as $key => $value) {
                    $path = "/Uploads" . $value["savepath"] . $value["savename"];
                    $thumbpath = "/Uploads" . $value["savepath"] ."thumb". $value["savename"];
                }
                $this->thumb($path,$thumbpath);
                if (!empty($_POST)) {
                    $model = M("menu");
                    $data["thumb"] = $thumbpath;
                    $data["dishes"] = I("post.dishes");
                    $data["package"] = 0;
                    $data["category"] = I("category");
                    $data["price"] = I("post.price");
                    $ret = $model->data($data)->add();
                }
                if ($ret) {
                    $this->success("添加成功！请稍后", "/order/index.php/Index/cai", 1);
                    return false;
                }
            }
        }
        $this->display("adddishes");
    }
    // 缩略图
    public function thumb($path,$thumbpath) {
        $image = new \Think\Image();
        $image->open($path);
        $image->thumb(150, 150)->save($thumbpath);
    }
    // 套餐管理
    public function package() {
        $model = M("menu");
        $page = $this->GetPage();
        $count = $model->where("package=1")->count();
        $pagedata = 5;
        $pagenum = ceil($count/$pagedata);
        $package = $model->where("package=1")->page($page,$pagedata)->select();
        $packageid = "packageid";
        $this->assign("package",$package)->assign("packageid",$packageid)->assign("total",$pagenum);
        $this->PageList($page,$pagenum,$state,"package");
        $this->display("user");
    }
    // 添加套餐
    public function addpackage() {
        if (!empty($_POST)) {
            $model = M("menu");
            $data["dishes"] = I("post.dishes");
            $data["price"] = I("post.price");
            $data["package"] = 1;
            $data["packagename"] = I("post.packagename");
            $ret = $model->data($data)->add();
            if ($ret) {
                $this->success("添加成功！","cai",1);
            }
        }
        $this->display("addpackage");
    }
    // 传菜
    public function dish() {
        if (!empty($_POST)) {
            $data["dishes"] = I("post.dishes");
            $data["dishesuser"] = I("dishesuser");
            $data["number"] = I("post.mumber");
            $data["beizhu"] = I("post.beizhu");
            $model = M("order");
            $ret = $model->data($data)->add();
            if ($ret) {
                $this->ajaxReturn(array("state"=>"success"));
            } else {
                $this->ajaxReturn(array("state"=>"error"));
            }
        }
    }
    // 加菜
    public function adddish() {
        if (!empty($_POST)) {
            $data["dishes"] = I("post.dishes");
            $data["dishesuser"] = I("dishesuser");
            $data["number"] = I("post.mumber");
            $data["beizhu"] = I("post.beizhu");
            $model = M("order");
            $ret = $model->data($data)->add();
            if ($ret) {
                $this->ajaxReturn(array("state"=>"success"));
            } else {
                $this->ajaxReturn(array("state"=>"error"));
            }
        }
    }
    // 退菜
    public function retreatfood() {
        if (!empty($_POST)) {
            $data["dishes"] = I("post.dishes");
            $data["dishesuser"] = I("dishesuser");
            $data["number"] = I("post.mumber");
            $data["beizhu"] = I("post.beizhu");
            $model = M("order");
            $ret = $model->data($data)->add();
            if ($ret) {
                $this->ajaxReturn(array("state"=>"success"));
            } else {
                $this->ajaxReturn(array("state"=>"error"));
            }
        }
    }
    // 结账
    public function checkout() {

    }
    // 修改状态
    public function modifystate() {
        $model = M("order");
        $id = I("get.id");
        if (is_numeric($id)) {
            $data["state"] = 1;
            $ret = $model->where("oid=$id")->data($data)->save();
            if ($ret) {
                $this->success("修改成功！", "/order/index.php/Index/orderManagement");
                $ret = $model->where("number=3 AND state=0")->select();
                if (!$ret) {
                    $model->select();
                }
            }
        }
    }
    // 批量修改状态
    public function batchmod() {
        $str = I("post.str");
//        $model = M("order");
        $model = new Model();
//        $ret = $model->where("state=0 AND oid IN ($str)")->select();
        $ret = $model->query("SELECT * FROM `order` WHERE `state`=0 AND `oid` IN ($str)");
        if ($ret) {
            $data["state"] = 1;
            $data["id"] = $str;
//            $ret = $model->data($data)->save();
            $ret = $model->query("UPDATE `order` SET `state`=1 WHERE `oid` IN ($str)");
            if ($ret) {
                $this->ajaxReturn(array("status" => "success"));
            } else {
                $this->ajaxReturn(array("status" => "error"));
            }
        }
    }
    // 餐桌管理
    public function tablemanager() {
        $model = M("tablenumbers");
        $ret = $model->select();
        if ($ret) {
            $this->assign("table",$ret)->assign("tableid","tableid");
        }
        $this->display('user');
    }
    //获取地址
    public function GetUrl() {
        $url = $_SERVER['REQUEST_URI'];
        $par = parse_url($url);
        if (isset($par['query'])) {
            parse_str($par['query'], $query);
            unset($query['page']);
            $url = $par['path'].'?'.http_build_query($query);
        }
        return $url;
    }
    // 获取页码
    public function GetPage() {
        if (empty(I("get.page"))) {
            $page = 1;
        } else {
            $page = I("get.page");
        }
        return $page;
    }
    // 分页
    private function PageList($page,$pagenum,$state,$controller) {
        if ($state == '') {$state = 0;}
        $start = 1;
        $showpage = 5;
        $pageoffset = ($showpage-1)/2;
        $pagelist = "";
        $end = $pagenum;
        if ($pagenum > $showpage) {
            if ($page > $pageoffset + 1) {
                $pagelist .= "<li><a>...</a></li>";
            }
            if ($page > $pageoffset) {
                $start = $page - $pageoffset;
                $end = $pagenum > $pageoffset + $page ? $page + $pageoffset : $pagenum;
            } else {
                $start = 1;
                $end = $pagenum > $showpage ? $showpage : $pagenum;
            }
            if ($page + $pageoffset > $pagenum) {
                $start = $start - ($page + $pageoffset - $end);
            }
        }
        for ($i=$start;$i<=$end;$i++) {
            if ($page == $i) {
                $pagelist .= "<li class='active'><a href='/order/index.php/Index/$controller/state/$state/page/$i'>$i</a></li>";
                continue;
            }
            $pagelist .= "<li><a href='/order/index.php/Index/$controller/state/$state/page/$i'>$i</a></li>";
        }
        if ($pagenum > $showpage && $pagenum > $page + $pageoffset) {
            $pagelist .= "<li><a>...</a></li>";
        }
        $this->assign("pagelist",$pagelist);
    }
}