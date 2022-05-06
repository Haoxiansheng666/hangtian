<?
    header("Content-type: text/html; charset=utf-8");

    //接收html页面传过来的文件
    
    if($_POST['leadExcel'] == "true")
    {
        $filename = $_FILES['inputExcel']['name'];
        $tmp_name = $_FILES['inputExcel']['tmp_name'];
        $msg = uploadFile($filename,$tmp_name);
        if( $msg=='true'){
            echo "导入成功";
        }
       
    }

/*
 *excel文件上传转换的方法

 * @access  public  
 *
 * @param  $file  接收的文件['name']名称 $filetempname ['tmp_name']保存的临时名字
 *
 * @ return  boole
*/
    function uploadFile($file,$filetempname)
    {
        //1.自己设置的上传文件存放路径
        $filePath = 'upFile/';  
        $str = "";  
        //2.导入PHPExcel类文件
        require_once 'PHPExcel.php';
        require_once 'PHPExcel/IOFactory.php';
        require_once 'PHPExcel/Reader/Excel5.php';
        //3.修改上传后的文件路径名称
        $time=date("y-m-d-H-i-s");
        $extend=strrchr ($file,'.');
        $name=$time.$extend;
        $uploadfile=$filePath.$name;
        //4.将文件移动到新路径下
        $result=move_uploaded_file($filetempname,$uploadfile);

        if($result) //如果上传文件成功，就执行导入excel操作
        {
            //5.导入自己的数据库操作文件
            include "class.mysql.php"; 
            $objReader = PHPExcel_IOFactory::createReader('Excel5');//use excel2007 for 2007 format
            $objPHPExcel = $objReader->load($uploadfile);
            $sheet = $objPHPExcel->getSheet(0);
            $highestRow = $sheet->getHighestRow();           //取得总行数
            $highestColumn = $sheet->getHighestColumn();    //取得总列数
            $objWorksheet = $objPHPExcel->getActiveSheet();
            $highestRow = $objWorksheet->getHighestRow();
            //echo '总行数='.$highestRow;
           // echo "<br>";
            $highestColumn = $objWorksheet->getHighestColumn();
            $highestColumnIndex = PHPExcel_Cell::columnIndexFromString($highestColumn);//总列数
            //echo '总列数='.$highestColumnIndex;
           // echo "<br>";
            $headtitle=array();
            for ($row = 1;$row <= $highestRow;$row++)
            {
                $strs=array();
                //注意highestColumnIndex的列数索引从0开始
                for ($col = 0;$col < $highestColumnIndex;$col++)
                {
                    $strs[$col] =$objWorksheet->getCellByColumnAndRow($col, $row)->getValue();
                }   
                //var_dump($strs);
                //6.拼接sql语句
                $sql = "INSERT INTO excel(`id`, `a`, `b`, `c`) VALUES (null,'{$strs['0']}','{$strs['1']}','{$strs['2']}')";
                //7.调用自己封装的数据库插入insertdata()方法
                $ress=$db->insertdata($sql);

            }
            if($ress){
                return  true;
            }
        }
        else
        {
           return  false;
        }
    }
?>