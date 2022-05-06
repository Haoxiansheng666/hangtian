<?php

    //1.导入类文件
    include_once('PHPExcel.php');
    //2.准备好参数
    $data=array('0'=>array('q' => 1, 'w' => 2,'e' => 3),'1'=>array('q' =>4, 'w' => 5,'e' => 6));//二维数组
    $name='Excelfile';    //生成的Excel文件文件名
    //3.调用方法
    push($data,$name);
    function push($data,$name='Excel'){
           //4.实例化该类
           $objPHPExcel = new PHPExcel();
          //5.以下是一些设置 ，什么作者  标题啊之类的
           $objPHPExcel->getProperties()->
                  setCreator('Gary.F.Dong') //设置创建者  
                 ->setLastModifiedBy(date('Y-m-d',time())) //设置时间  
                 ->setTitle('Filters') //设置标题  
                 ->setSubject('产品Filters选项') //设置备注  
                 ->setDescription('导出所有产品的Filters') //设置描述  
                 ->setKeywords('Filters') //设置关键字 | 标记  
                 ->setCategory('Filters'); //设置类别  ;

          //6.第一行合并的单元格A1:C1
          $objPHPExcel->getActiveSheet()->mergeCells('A1:C1');
          
          //8.设置A1加粗
          $objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
          //9.设置各列数据单元格居中
          $objPHPExcel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);  
          $objPHPExcel->getActiveSheet()->getStyle('A')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); 
          $objPHPExcel->getActiveSheet()->getStyle('B')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); 
          $objPHPExcel->getActiveSheet()->getStyle('c')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); 
          //10.设置列宽
          $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(18);
          //11.设置行高度  
          $objPHPExcel->getActiveSheet()->getRowDimension('1')->setRowHeight(22);
          //12.设置字体大小
          $objPHPExcel->getActiveSheet()->getStyle('A2:c2')->getFont()->setSize(12);

          //13.设置填充颜色
           $objPHPExcel->getActiveSheet()->getStyle('A1')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
          $objPHPExcel->getActiveSheet()->getStyle('A1')->getFill()->getStartColor()->setRGB('cd99fe'); 

          //7.设置第一行的标题和第二行的标题
          $num=2;
          $objPHPExcel->setActiveSheetIndex(0) 
              ->setCellValue('A1', "用户血糖测试记录")   
             ->setCellValue('A'.$num, "编号1")   
             ->setCellValue('B'.$num, "编号2")
             ->setCellValue('C'.$num, "编号3");
          //8.遍历数组，注意数组对应的下标
          foreach($data as $k => $v){
               $num=$k+3;
               $objPHPExcel->setActiveSheetIndex(0)
                   ->setCellValue('A'.$num, $v['q'])   
                   ->setCellValue('B'.$num, $v['w'])
                    ->setCellValue('C'.$num, $v['e']);
          }
          $objPHPExcel->getActiveSheet()->setTitle('User');
          $objPHPExcel->setActiveSheetIndex(0);
          ob_end_clean();
          header('Content-Type: application/vnd.ms-excel');
          header('Content-Disposition: attachment;filename="'.$name.'.xls"');
          header('Cache-Control: max-age=0');
          $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
          $objWriter->save('php://output');
          exit;
      }

  
