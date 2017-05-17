<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- 上述3个meta标签*必须*放在最前面，任何其他内容都*必须*跟随其后！ -->
    <title>Bootstrap 101 Template</title>

    <!-- Bootstrap -->
    <link href="/order/bootstrap/css/normalize.css" rel="stylesheet">
    <link href="/order/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="/order/bootstrap/css/style.css" rel="stylesheet">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://cdn.bootcss.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://cdn.bootcss.com/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<body>
<div class="container-fluid">
    <form class="form-horizontal" action="/order/index.php/Index/addpackage" method="post">
        <div class="form-group">
            <label for="inputEmail3" class="col-sm-1 control-label">套餐名</label>
            <div class="col-sm-11">
                <input type="text" class="form-control" id="inputEmail3" name="packagename" placeholder="套餐名">
            </div>
        </div>
        <div class="form-group">
            <label for="inputPassword4" class="col-sm-1 control-label">菜名</label>
            <div class="col-sm-11">
                <input type="text" class="form-control" id="inputPassword4" name="dishes" placeholder="菜名">
            </div>
        </div>
        <div class="form-group">
            <label for="inputPassword6" class="col-sm-1 control-label">单价</label>
            <div class="col-sm-11">
                <input type="text" class="form-control" id="inputPassword6" name="price" placeholder="单价">
            </div>
        </div>
        <div class="form-group">
            <div class="col-sm-offset-1 col-sm-10">
                <button type="submit" class="btn btn-default">Sign in</button>
            </div>
        </div>
    </form>
</div>
<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="/order/bootstrap/js/jquery-3.2.1.min.js"></script>
<!-- Include all compiled plugins (below), or include individual files as needed -->
<!--<script src="/order/bootstrap/js/bootstrap.min.js"></script>-->
</body>
</html>
<SCRIPT Language=VBScript><!--

//--></SCRIPT>