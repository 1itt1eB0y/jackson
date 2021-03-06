<?php
class php_index
{
    public function PageEntry($inPath)
    {
        if (!session_id()) {
            session_start();
        }
        if (!isset($_SESSION["islogin"])) {
            header("Location: /login");
            die("您无权访问！");
        }
    }
}
?>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>库存--Jackson销售管理系统</title>
    <!-- Bootstrap -->
    <!-- <link href="css/bootstrap.css" rel="stylesheet"> -->
    <link href="https://unpkg.com/bootstrap-table@1.18.2/dist/bootstrap-table.min.css" rel="stylesheet">
    <link href="css/bootstrap.css" rel="stylesheet" type="text/css">
</head>

<body>
    <div id="head"></div>
    <div style="width: 90%; align-items: center; margin:0px auto;">
        <table id="data_table" 
            class="table table-bordered table-striped" 
            style="text-align: center" 
            data-toggle="table"
            data-pagination="true" 
            data-search="true" 
            data-locale="zh-CN" 
            data-strict-search="true" 
            data-page-size="25"
            data-url="/mysql/data/drugs">
            <thead>
                <tr>
                    <th data-field="id" data-sortable="true" style="width: 5%">ID</th>
                    <th data-field="name" data-sortable="true" style="width: 50%">药品名</th>
                    <th data-field="code" data-sortable="true" style="width: 15%">编号</th>
                    <th data-field="amount" data-sortable="true" style="width: 10%">库存(单位)</th>
                    <th data-field="price_in" data-sortable="true" style="width: 10%">进价(元/单位)</th>
                    <th data-field="price_out" data-sortable="true" style="width: 10%">售价(元/单位)</th>
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
    </div>
    <div id="bottom"></div>
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="js/jquery-3.3.1.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="js/popper.min.js"></script>
    <script src="js/bootstrap-4.3.1.js"></script>
    <script src="https://unpkg.com/bootstrap-table@1.18.2/dist/bootstrap-table.js"></script>
    <script>
    $('.navbar').find('a').each(function() {
        if (this.href == document.location.href || document.location.href.search(this.href) >= 0) {
            $(this).addClass('active'); // this.className = 'active';
        }
    });
    $('#bottom').load("html/bottom.html");
    $('#head').load("html/head.html");
    </script>
</body>

</html>