<?php
class php_mysql
{
    //数据库连接初始化
    public static function SQLConnect()
    {
        $db = new SDb();
        $db->init(
            array(
                "host" => "localhost",
                "user" => "root",
                "database" => "jackson",
                "password" => "toor",
                "port" => 3306,
                "engine" => "pdo_mysql",
            )
        );
        return $db;
    }
    //登录验证，防止非授权访问
    public function CheckSession()
    {
        if (!session_id()) {
            session_start();
        }
        if (isset($_SESSION['islogin'])) {
            return 1;
        } else {
            header("Location: /login");
        }
    }
    //json返回整张表单
    public function TableData($tablename)
    {
        self::CheckSession();
        $db = self::SQLConnect();
        $db_result = $db->execute("select * from $tablename");
        return $db_result;
    }

    public function PageQuery($inPath)
    {
        self::CheckSession();
//        print_r($inPath);
        $db = self::SQLConnect();
        $inPath[3] = urldecode($inPath[3]);
        $inPath[4] = urldecode($inPath[4]);
        if (isset($inPath[5])) {
            $inPath[5] = urldecode($inPath[5]);
            $db_result = $db->execute("select `$inPath[5]` from `$inPath[3]` where $inPath[4]");
        } else {
            $db_result = $db->execute("select * from `$inPath[3]` where $inPath[4]");
        }
//        $db_result = $db->select($inPath[3],urldecode($inPath[4]));
        print(json_encode($db_result));
        return 1;
    }
    //出售查询页面查询单条数据
    public function PageChuku($inPath)
    {
        self::CheckSession();
        $db = self::SQLConnect();
        $inPath[4] = urldecode($inPath[4]);
        $inPath[5] = urldecode($inPath[5]);
        //模糊查询
        if ($inPath[3] == "y1") {
            $db_result = $db->execute("select * from `drugs` where $inPath[4] like '%$inPath[5]%'");
        } else if ($inPath[3] == "y2") {
            $db_result = $db->execute("select * from `drugs` where name like '%$inPath[4]%' and code like '%$inPath[5]%'");
            //严格查询
        } else if ($inPath[3] == "n1") {
            $db_result = $db->execute("select * from `drugs` where $inPath[4] = '$inPath[5]'");
        } else if ($inPath[3] == "n2") {
            $db_result = $db->execute("select * from `drugs` where name = '$inPath[4]' and code = $inPath[5]'");
        }
        print(json_encode($db_result));
        return 1;
    }
    //出售提交
    public function PageCommit($inPath)
    {
        self::CheckSession();
        $data = json_decode(file_get_contents("php://input"));
        $db = self::SQLConnect();
        $seller=$_SESSION["username"];
        $result = (int) $data->amount - (int) $data->bufferint;
        $time = date("Y-m-d H:i:s",strtotime("+8 hours"));
        $db->execute("insert into `record` values(id, '$time', '$data->code', '$data->name', $data->id, $data->price_out, $data->bufferint, $data->price_sum, '$seller')");
        print($db->update("drugs", array("id" => $data->id), array("amount" => $result)));
    }
    //打开数据库
    public function PageEntry($inPath)
    {
        
        self::CheckSession();
        // print($_SESSION['username']);
        // print_r($inPath);
        // $usr = 'admin';
        // $pwd = 'admin';
        // print_r(self::SQLConnect()->selectOne('user', array("username" => $usr), 'password'));
    }
    public function PageData($inPath)
    {
        self::CheckSession();
        print(json_encode(self::TableData($inPath[3])));
    }
}