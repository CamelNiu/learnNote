<?php
    // +----------------------------------------------------------------------
    // | Theme:封装的数据库操作类,进行增删改查
    // +----------------------------------------------------------------------
    // | Introduce:只需要sql语句,就可以实现,连接,执行等等已经实现
    // +----------------------------------------------------------------------
    // | Author: <NgauSiuKong@gmail.com>
    // +----------------------------------------------------------------------
        /**
         * 数据库操作类,进行增删改查
         * @author <NgauSiuKong@gmail.com>
         */
        class DatabaseOperate
        {
            private $host = "mysql.linode.niushao.net";//服务器地址
            private $name = "niushao";//数据库用户名
            private $pwd = "niushao";//数据库登录密码
            private $dBase = "dh_tuoling";//数据库名称
            private $conn = "";//数据库连接对象
            private $result = "";//结果集
            private $filesArray = array();
            private $rowsArray = array();
            /**
             * 构造函数,实现数据库连接,默认设置本地
             * @param $host
             * @param $name
             * @param $pwd
             * @param dBase
             * @author <NgauSiuKong@gmail.com>
             */
            public function __construct($host="",$name="",$pwd="",$dBase="")
            {
                if($host != "") $this->host = $host;
                if($name != "") $this->name = $name;
                if($pwd != "") $this->pwd = $pwd;
                if($dBase != "") $this->dBase = $dBase;
                $this->init_conn();
            }
            /**
             * 连接数据库,设置字符集
             * @author <NgauSiuKong@gmail.com>
             */
            public function init_conn()
            {
                $this->conn = @mysqli_connect($this->host,$this->name,$this->pwd,$this->dBase);
                @mysqli_set_charset($this->conn,'utf8');
            }
            /**
             * 利用sql语句执行,返回结果集
             * @author <NgauSiuKong@gmail.com>
             */
            public function mysql_query_rst($sql)
            {
                if($this->conn == ""){
                    $this->init_conn();
                }
                $this->result = @mysqli_query($this->conn,$sql);
            }
            /**
             * 返回查询之后的记录函数
             * @author <NgauSiuKong@gmail.com>
             */
            public function getSelCount($sql)
            {
                $this->mysql_query_rst($sql);
                if(mysqli_connect_errno() == 0){
                    $sql_num = mysqli_num_rows($this->result);
                    return $sql_num;
                }else{
                    return "Connect failed:".mysqli_connect_error();
                }
            }
            /**
             * 取出查询之后结果集的单条记录
             * @author <NgauSiuKong@gmail.com>
             */
            public function getOneArray($sql)
            {
                $this->mysql_query_rst($sql);
                if(mysqli_connect_errno() == 0){
                    $this->rowsRst = mysqli_fetch_assoc($this->result);
                    return $this->rowsRst;
                }else{
                    return "Connect failed:".mysqli_connect_error();
                }
            }
            /**
             * 取出查询之后结果集的数组记录
             * @author <NgauSiuKong@gmail.com>
             */
            public function getAllArray($sql)
            {
                $this->mysql_query_rst($sql);
                if(mysqli_connect_errno() == 0){
                    while($row = mysqli_fetch_assoc($this->result)){
                        $this->rowsArray[] = $row;
                    }
                    return $this->rowsArray;
                }else{
                    return "Connect failed:".mysqli_connect_error();
                }
            }
            /**
             * 提供添加数据的id
             * @author <NgauSiuKong@gmail.com>
             */
            public function getAddId($sql)
            {
                $this->mysql_query_rst($sql);
                if(mysqli_connect_errno() == 0){
                    $addId = mysqli_insert_id($this->conn);
                    return $addId;
                }else{
                    return "Connect failed:".mysqli_connect_error();
                }
            }
            /**
             * 提供增删改的受影响行数
             * @author <NgauSiuKong@gmail.com>
             */
            public function getRows($sql)
            {
                $this->mysql_query_rst($sql);
                if(mysqli_connect_errno() == 0){
                    $rows = mysqli_affected_rows($this->conn);
                    return $rows;
                }else{
                    return "Connect failed:".mysqli_connect_error();
                }
            }
            /**
             * 释放结果集
             * @author <NgauSiuKong@gmail.com>
             */
            public function freeResult($sql)
            {
                mysqli_free_result($result);
                $this->msg = "";
                $this->fieldsNum = 0;
                $this->rowsNum = 0;
                $this->filesArray = "";
                $this->rowsArray = "";
            }
            /**
             * 关闭数据库
             * @author <NgauSiuKong@gmail.com>
             */
            public function close_conn()
            {
                $this->freeResult();
                mysqli_close($this->conn);
                $this->conn = "";
            }
        }

?>