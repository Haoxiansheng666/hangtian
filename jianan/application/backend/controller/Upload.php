<?php
namespace app\backend\controller;
use think\Controller;
use think\Db;
use think\Config;
use think\Request;
class Upload extends Common
{

    /** 
     * layui图片上传方法
     * @access public 
     * @since dxf 
     * @return [type] [json]
     */
	public function layuiImgUpload(){
		// 获取表单上传文件 例如上传了001.jpg
	    $file = request()->file('img');
	    $dir = input('post.dir');
	    // 移动到框架应用根目录/upload/dir/ 目录下 图片最大300k
	    $info = $file->validate(['size'=>60000000,'ext'=>'jpg,png,gif,jpeg'])->move(ROOT_PATH  .  DS .'public' . DS . 'uploads' . DS .$dir);
	    if($info){
			$name_path =str_replace('\\',"/",$info->getSaveName());
			if (!empty($dir)){
                $path =  '/uploads' . '/' . $dir . '/' . $name_path;
            }else{
                $path =  '/uploads' . '/' . $name_path;
            }
	        // 成功上传后 返回上传信息
			ajaxReturn($this->errCode('OK'),'上传成功',$path);
	    }else{
	        // 上传失败返回错误信息
			ajaxReturn($this->errCode('failed'),$info->getError());
	    }
	}
    /**
     * layui图片上传方法
     * @access public
     * @since dxf
     * @return [type] [json]
     */
    public function editorUpload(){
        // 获取表单上传文件 例如上传了001.jpg
        $file = request()->file('editormd-image-file');
        $dir = input('post.dir');
        // 移动到框架应用根目录/upload/dir/ 目录下 图片最大300k
        $info = $file->validate(['size'=>3072000,'ext'=>'jpg,png,gif,jpeg,bmp'])->move(ROOT_PATH  .  DS .'public' . DS . 'uploads' . DS .$dir);
        if($info){
            $name_path =str_replace('\\',"/",$info->getSaveName());
            $path =  '/uploads' . '/' . $dir . '/' . $name_path;
            // 成功上传后 返回上传信息
            return json(['url'=>$path,'success'=>1,'message'=>'上传成功']);
        }else{
            // 上传失败返回错误信息
            ajaxReturn($this->errCode('failed'),$info->getError());
        }
    }
    /** 
     * webupload 多图片上传方法
     * @access public 
     * @since dxf 
     * @return [type] [json]
     */
	public function webImgUpload(){
        // 获取表单上传文件 例如上传了001.jpg
        $file = request()->file('file');
        $param=input('param.');
        // 移动到框架应用根目录/public/uploads/ 目录下
        if($file){
            $info = $file->validate(['size'=>307200,'ext'=>'jpg,png,gif,jpeg'])->move(ROOT_PATH . 'public' . DS . 'uploads/webupload');
            if($info){
                $imgname=str_replace('\\','/',$info->getSaveName());
               	$data['main_img']='/uploads/webupload/'.$imgname;
               	$data['news_id']=$param['news_id'];
                $data['ctime']=time();
                $ausess=$this->ausess();
                $data['group_id']=$ausess['group_id'];
                $data['auid']=$ausess['auid'];
               	Db::name('news_img')->insert($data);
                die(json_encode(['img'=>$data['main_img'],'id'=>$param['news_id']]));
            }else{
                // 上传失败获取错误信息
                die($file->getError());
            }
        }
    }
    /** 
     * layui 文件上传方法
     * @access public 
     * @since dxf 
     * @return [type] [json]
     */
    public function layuiFileUpload(){
        // 获取表单上传文件 例如上传了001.jpg
        $file = request()->file('fileurl');
        $dir = input('post.dir');
        // 移动到框架应用根目录/upload/dir/ 目录下 大小10M
        $info = $file->validate(['size'=>10485760,'ext'=>'xls,xlsx,csv'])->move(ROOT_PATH  .  DS .'public' . DS . 'uploads' . DS .$dir);
        if($info){
            $name_path =str_replace('\\',"/",$info->getSaveName());
            $path =  'uploads' . '/' . $dir . '/' . $name_path;
            // 成功上传后 返回上传信息
            ajaxReturn($this->errCode('OK'),'上传成功',$path);
        }else{
            // 上传失败返回错误信息
            ajaxReturn($this->errCode('failed'),$info->getError());
        }
    }
    /** 
     * 文件导出
     * @access protected 
     * @since dxf 
     * @return [type] [file]
     */
    protected function push($data,$name='Excel'){
        vendor('PHPExcel.PHPExcel');
        //4.实例化该类
        $objPHPExcel = new \PHPExcel();
        //5.以下是一些设置 ，什么作者  标题啊之类的
        $objPHPExcel->getProperties()
            ->setCreator('yunqi') //设置创建者  
            ->setLastModifiedBy(date('Y-m-d',time())) //设置时间  
            ->setTitle('excel') //设置标题  
            ->setSubject('beizhu') //设置备注  
            ->setDescription('miaoshu') //设置描述  
            ->setKeywords('keys') //设置关键字 | 标记  
            ->setCategory('cate'); //设置类别  ;
        //6.第一行合并的单元格A1:C1
        $objPHPExcel->getActiveSheet()->mergeCells('A1:C1');
        //8.设置A1加粗
        $objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
        //9.设置各列数据单元格居中
        $objPHPExcel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);  
        $objPHPExcel->getActiveSheet()->getStyle('A:D')->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER); 
        $objPHPExcel->getActiveSheet()->getStyle('B')->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER); 
        $objPHPExcel->getActiveSheet()->getStyle('c')->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER); 
        //10.设置列宽
        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(18);
        //11.设置行高度  
        $objPHPExcel->getActiveSheet()->getRowDimension('1')->setRowHeight(22);
        //12.设置字体大小
        $objPHPExcel->getActiveSheet()->getStyle('A2:c2')->getFont()->setSize(12);
        //13.设置填充颜色
        $objPHPExcel->getActiveSheet()->getStyle('A1')->getFill()->setFillType(\PHPExcel_Style_Fill::FILL_SOLID);
        $objPHPExcel->getActiveSheet()->getStyle('A1')->getFill()->getStartColor()->setRGB('cd99fe'); 
        //7.设置第一行的标题和第二行的标题
        $num=2;
        $objPHPExcel->setActiveSheetIndex(0) 
            ->setCellValue('A1', "用户血糖测试记录")   
            ->setCellValue('A'.$num, "编号1")   
            ->setCellValue('B'.$num, "编号2")
            ->setCellValue('C'.$num, "编号3");
        //14.遍历数组，注意数组对应的下标
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
        $objWriter = \PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');
        exit;
    }
}