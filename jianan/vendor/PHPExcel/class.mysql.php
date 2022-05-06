<?php
Class Class_Mysql{
	public $link;
	public $query;
	function __construct($host,$user_name,$password,$db_name){
		$this->link = mysql_connect($host,$user_name,$password) or die("Cound not connect to $host");
		mysql_select_db($db_name,$this->link) or die("Cound not select db $db_name");
		mysql_query("set names gbk");
	}
//定义query方法
	function query($sql){  
		$this -> query = mysql_query($sql);
		return $this -> query;
	}

//获得一个关联数组和索引数组
	function getarray($sql){
		$array=array();
		$this -> query= $this->query($sql);
		return  mysql_fetch_array($this -> query);
	}

/*//获得关联数组
	function getall($sql){
		$this -> query= $this->query($sql);
		$array=array();
		while ($rows = @mysql_fetch_assoc($this -> query)){
			$array[] = $rows;
		}
		return $array;
	}

//获得一条数据的关联数组
	function getone($sql){
		$this -> query= $this->query($sql);
		$rows = @mysql_fetch_assoc($this -> query);
		return $rows;
	}*/


	function getOneq($sql, $limited = false)
    {
        if ($limited == true)
        {
            $sql = trim($sql . ' LIMIT 1');
        }

        $res = $this->query($sql);
        
        if ($res !== false)
        {
            $row = mysql_fetch_row($res);

            if ($row !== false)
            {
                return $row[0];
            }
            else
            {
                return '';
            }
        }
        else
        {
            return false;
        }
    }
function getAll($sql)
    {
        $res = $this->query($sql);
        if ($res !== false)
        {
            $arr = array();
            while ($row = mysql_fetch_assoc($res))
            {
                $arr[] = $row;
            }

            return $arr;
        }
        else
        {
            return false;
        }
    }


    

//获得记录的总数目
	function getcount($sql){
		$reslut= $this->query($sql);
		$rows = mysql_num_rows($reslut);
		if($rows){
			return $rows;
		}else{
			return 0;
		}	
	}


//删除一条数据
	function deldata($sql){
		$reslut= $this->query($sql);
		return mysql_affected_rows();
	}

//插入数据，返回数据的id
	function insertdata($sql){
		$reslut= $this->query($sql);
		return mysql_insert_id();
	}

//修改数据
	function updata($sql){
		$reslut= $this->query($sql);
		return mysql_affected_rows();;
	}



}
			
$db_host      =  'localhost';
$db_username  =  'root';
$db_password  =  'root';
$db_name      =  'cycrm';


$db = new Class_Mysql($db_host,$db_username,$db_password,$db_name);

?>