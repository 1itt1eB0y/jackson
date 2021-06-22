<?php
class php_sell
{
    public function PageEntry($inPath)
    {
        if (!session_id()) {
            session_start();
        }

        if (!isset($_SESSION["islogin"])) {
            header("Location: /login");
        }
    }
}
?>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>销售--Jackson销售管理系统</title>
    <!-- Bootstrap -->
    <!-- <link href="css/bootstrap.css" rel="stylesheet"> -->
    <link href="css/bootstrap-4.3.1.css" rel="stylesheet" type="text/css">
    <link href="https://unpkg.com/bootstrap-table@1.18.2/dist/bootstrap-table.min.css" rel="stylesheet">
</head>

<body>
    <div id="head"></div>
    <br>
    <div style="width: 300px; align-items: center; margin:0px auto;">
        <form action="" target="form-result" role="form" id="query-from">
            <div class="form-group">
                <label for="drug-name">药品名称</label>
                <input type="text" class="form-control" id="durg-name" placeholder="">
            </div>
            <div class="form-group">
                <label for="drug-code">药品编号</label>
                <input type="text" class="form-control" id="drug-code" placeholder="">
            </div>
            <div class="form-check">
                <input type="checkbox" class="form-check-input" id="drug-strict" value="false" onclick="checkboxOnclick(this)">
                <label class="form-check-label" for="drug-strict">模糊查询（取消勾选以进行全字匹配）</label>
            </div>
            <div class="form-check">
                <button type="button" class="btn btn-primary" onsubmit="return false;"
                    onclick="refreshtable()">提交查询</button>
            </div>
        </form>
        <iframe name="form-result" style="display:none"></iframe>
    </div>
    <div style="width: 80%; align-items: center; align-content: center; margin: 0px auto">
        <table id="query_table" 
            class="table table-bordered table-striped" 
            style="text-align: center"
            data-toggle="table" 
            data-pagination="true" 
            data-height="422" 
            data-page-size="5" 
            data-locale="zh-CN"
            data-unique-id="id" 
            data-url="/mysql/data/drugs" 
            data-click-to-select="true">
            <thead>
                <tr>
                    <th data-field="id">ID</th>
                    <th data-field="name">药品名</th>
                    <th data-field="code">编号</th>
                    <th data-field="amount">库存(单位)</th>
                    <th data-field="price_out">售价(元/单位)</th>
                    <th data-field="bufferint" data-formatter="operateFormatter" data-events="operateEvents">出库数量(单位)</th>
                    <th data-field="price_sum">总价(元)</th>
                    <th data-field="commit" data-formatter="commitFormatter" data-events="commitEvents">操作</th>
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
    <!-- <script src="https://unpkg.com/bootstrap-table@1.18.2/dist/bootstrap-table.js"></script> -->
    <script src="js/bootstrap-4.3.1.js"></script>
    <script src="js/bootstrap-table.min.js"></script>
    <script>
    $('#bottom').load("html/bottom.html");
    $('#head').load("html/head.html");
    var $table = $('#query_table');
    var can = false;

    function operateFormatter(value, row, index) {
        return '<input type="text" class="form-control amount" name='+row.id+' placeholder=" " value=' + value + '>';
    }

    function commitFormatter(value, row, index) {
        return '<button type="button" class="btn btn-primary commit">售卖</button>';
    }
    window.operateEvents = {
        'change .amount': function(e, value, row, index) {
            var svalue = parseInt($("input[name="+row.id+"]").val());
            $table.bootstrapTable('updateCell', {
                index: index,
                field: 'price_sum',
                value: svalue * Number(row.price_out)
            })
            $table.bootstrapTable('updateCell', {
                index: index,
                field: 'bufferint',
                value: svalue
            });
            //            alert(row.price_sum);
//           alert(JSON.stringify(row));
            if (svalue > 0 && svalue <= row.amount) {
                can = true;
            } else {
                //                alert(JSON.stringify($table.bootstrapTable('getData',true)));
                can = false;
            }
        },
    }
    window.commitEvents = {
        'click .commit': function(e, value, row, index) {
            if (can == true) {
                //                alert(typeof row.amount);
                $.post('/mysql/commit', JSON.stringify(row),
                    function(data) {
                        if (data) {
                            alert("已成功售出！");
                        } else {
                            alert("服务器错误！");
                        };
                    });
                $table.bootstrapTable('refresh');
            } else {
                alert("所售数量为零或大于库存！请核验！");
            }
        }
    }
    $('.navbar').find('a').each(function() {
        if (this.href == document.location.href || document.location.href.search(this.href) >= 0) {
            $(this).addClass('active'); // this.className = 'active';
        }
    });

    function checkboxOnclick(checkbox) {
        if (checkbox.checked == true) {
            checkbox.value = "true";
        } else {
            checkbox.value = "false";
        }
    }

    function geturl() {
        var form = document.getElementById('query-from');
        var elements = new Array();
        var queryVars = form.getElementsByTagName('input');
        var urladdr = "/mysql/chuku";
        if (queryVars[2].value == "false") {
            if (queryVars[0].value && queryVars[1].value) {
                urladdr += "/n2/" + encodeURIComponent(queryVars[0].value) + "/" + queryVars[1].value;
            } else if (queryVars[0].value) {
                urladdr += "/n1/name/" + encodeURIComponent(queryVars[0].value);
            } else if (queryVars[1].value) {
                urladdr += "/n1/code/" + queryVars[1].value;
            }
        } else if (queryVars[2].value == "true") {
            if (queryVars[0].value && queryVars[1].value) {
                urladdr += "/y2/" + encodeURIComponent(queryVars[0].value) + "/" + queryVars[1].value;
            } else if (queryVars[0].value) {
                urladdr += "/y1/name/" + encodeURIComponent(queryVars[0].value);
            } else if (queryVars[1].value) {
                urladdr += "/y1/code/" + queryVars[1].value;
            }
        }
        //    alert(urladdr);
        return urladdr;
    }

    function refreshtable() {
        var $table = $('#query_table')
        $table.bootstrapTable('refreshOptions', {
            url: geturl()
        });
    }
    </script>
</body>

</html>