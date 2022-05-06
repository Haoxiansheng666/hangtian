<?php
namespace app\backend\logic;
use app\backend\model\AdminUser;
use app\backend\model\AuthGroup;
use app\backend\model\Customer;
use app\backend\model\CustomerCate;
use app\backend\model\PayStudent;
use app\backend\model\Profession;
use think\Db;
use think\Model;
use think\Request;
class CustomerLogic 
{   
    /**
     * 客户查询的逻辑
     * @access public 
     * @param array   $param 条件数据
     * @param array   $ausess 账号的session信息
     * @since dxf 
     * @return [array]
     */
	static public  function selectParam($param,$ausess){
        $where=[];
        //客户名称
        if(isset($param['name']) && !empty($param['name'])){
            $where['name']=array('like',"%$param[name]%");
        }
        //手机号
        if(isset($param['mobile']) && !empty($param['mobile'])){
            $where['mobile']=array('like',"%$param[mobile]%");
        }
        //类别id
        if(isset($param['cate_id']) && !empty($param['cate_id'])){
            $where['cate_id']=$param['cate_id'];
        }
        //来源
        if(isset($param['from']) && !empty($param['from'])){
            $where['from']=$param['from'];
        }
        //添加人
        if(isset($param['auid']) && !empty($param['auid'])){
            $where['auid']=$param['auid'];
        }
        //添加人
        if(isset($param['company_id']) && !empty($param['company_id'])){
            $where['company_id']=$param['company_id'];
        }
        //跟进状态
        if(isset($param['follow_status']) && !empty($param['follow_status'])){
            $where['follow_status']=$param['follow_status'];
        }
        // 选择id
        if (!empty($param['ids'])){
            $where['t.id'] = ['in',$param['ids']];
        }
        // 下次跟进开始时间
        if(isset($param['action_time']) && !empty($param['action_time'])){
            $where['next_contact_time'] = ['>=' , strtotime($param['action_time'])];
        }
        // 下次跟进结束时间
        if(isset($param['end_time']) && !empty($param['end_time'])){
            if (!empty($where['next_contact_time'])){
                $where['next_contact_time'] = ['between' , [strtotime($param['action_time']),strtotime($param['end_time'])]];
            }else{
                $where['next_contact_time'] = ['between' , [1,strtotime($param['end_time'])]];
            }

        }
        if (empty($param['fa']) && empty($where['auid']) && !empty($ausess)){
            // 权限设置
            $group = AuthGroup::get($ausess['group_id']);
            if ($group['pid'] == 0 && $group['department_id'] == 0){
                $admin_ids = (new AdminUser())
                    ->column('id');
            }else if ($group['pid'] == 0 && $group['department_id'] == 7){
                $admin_ids = (new AdminUser())
                ->where(['campus_id' => $ausess['campus_id']])
                ->column('id');
            }else{
                $top_group = AuthGroup::get($group['pid']);
                if ($top_group['pid'] == 0){
                    $admin_ids = (new AdminUser())
                        ->where(['pid' => $ausess['auid'],'campus_id' => $ausess['campus_id']])
                        ->column('id');
                }else{
                    $admin_ids = [];
                }
            }
            $where['auid'] = ['in',array_merge([$ausess['auid']],$admin_ids)];
        }

        if (!empty($param['profession_id'])){
            $where['profession_id'] = $param['profession_id'];
        }

        if (!empty($param['pid'])){
            $where['profession_top_id'] = $param['pid'];
        }
        if (!empty($param['status'])){
            if (is_array($param['status'])){
                $where['status'] = ['>',1];
            }else{
                $where['status'] = $param['status'];
            }
        }
        return $where;
    }

    /**
     * 客户数据下载的逻辑
     * @access public 
     * @param array   $data 要下载的数据
     * @since dxf 
     * @return [file]
     */
    static public function down($data,$name){
        vendor('PHPExcel.PHPExcel');
        $objPHPExcel = new \PHPExcel();
        $objPHPExcel->getActiveSheet()->getStyle('A:N')->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER); 
        //遍历数组，注意数组对应的下标
        $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A1', '学员姓名')
            ->setCellValue('B1', '手机号')
            ->setCellValue('C1', '工种')
            ->setCellValue('D1', '类型')
            ->setCellValue('E1', '客户分类')
            ->setCellValue('F1', '客户来源')
            ->setCellValue('G1', '业务员名称')
            ->setCellValue('H1', '添加时间');

        foreach($data as $k=>$v){
            $k++;
            $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue('A'.($k+1), $v['name'])
                ->setCellValue('B'.($k+1), ' '.$v['mobile'])
                ->setCellValue('C'.($k+1), $v['profession_top'])
                ->setCellValue('D'.($k+1), $v['profession'])
                ->setCellValue('E'.($k+1), $v['cate'])
                ->setCellValue('F'.($k+1), $v['source'])
                ->setCellValue('G'.($k+1), $v['admin'])
                ->setCellValue('H'.($k+1), $v['create_time']);
        }

        
        ob_end_clean();
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="'.$name.'.xls"');
        header('Cache-Control: max-age=0');
        $objWriter = \PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');
        exit;
    }


    /**
     * 客户数据下载的逻辑
     * @access public
     * @param array $data 要下载的数据
     * @param array $name excel表名称
     * @return [file]
     * @since dxf
     */
    static public function cus_down($data, $name,$type = 1,$title = "")
    {
        vendor('PHPExcel.PHPExcel');
        $objPHPExcel = new \PHPExcel();
        $objPHPExcel->getActiveSheet()->getStyle('A:N')->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        //遍历数组，注意数组对应的下标
        if ($type == 2) {
            foreach ($data as $k => $v) {
                //合并单元格
               // $objPHPExcel->setActiveSheetIndex(0)->mergeCells('A1:K2');
                $objPHPExcel->setActiveSheetIndex(0)->mergeCells('A1:H2');
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A1', $title);
                //设置单元格里面的值对齐
                $objPHPExcel->getActiveSheet()->getStyle('A1')->getAlignment()->setWrapText(true);
                $objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValue('A'. $k, $v['name'])
                    ->setCellValue('B'. $k, ' '.$v['mobile'])
                    ->setCellValue('C'. $k, $v['cate'])
                    ->setCellValue('D'. $k, $v['source'])
                    ->setCellValue('E'. $k, $v['profession_id'])
                    ->setCellValue('F'. $k, $v['type'])
//                    ->setCellValue('G'. $k, $v['expire'])
                    ->setCellValue('G'. $k, $v['from'])
                    ->setCellValue('H'. $k, $v['real_name']);
            }
        } else if($type == 1) {
            foreach($data as $k => $v){
                $k++;
                $objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValue('A'.$k, $v['id'])
                    ->setCellValue('B'.$k, $v['from_name'])   
                    ->setCellValue('C'.$k, $v['cate_name'])
                    ->setCellValue('D'.$k, $v['name'])
                    ->setCellValue('E'.$k, ' '.$v['mobile'])
                    ->setCellValue('F'.$k, $v['address'])
                    ->setCellValue('G'.$k, $v['real_name'])
                    ->setCellValue('H'.$k, $v['education'])
                    ->setCellValue('I'.$k, $v['account'])
                    ->setCellValue('J'.$k, $v['password']);
            }
        }else if($type == 3){
            foreach($data as $k => $v){
                //合并单元格
                $objPHPExcel->setActiveSheetIndex(0)->mergeCells('A1:D1');
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A1', $title);
                //设置单元格里面的值对齐
                $objPHPExcel->getActiveSheet()->getStyle('A1')->getAlignment()->setWrapText(true);
                $objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValue('A'.$k, $v['company'])
                    ->setCellValue('B'.$k, $v['contact'])
                    ->setCellValue('C'.$k, ' '.$v['mobile'])
                    ->setCellValue('D'.$k, $v['auid'])
                    ->setCellValue('E'.$k, $v['address']);
            }
        }else if($type == 4){
            foreach ($data as $k => $v) {
                //合并单元格
                $objPHPExcel->setActiveSheetIndex(0)->mergeCells('A1:I2');
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A1', $title);
                //设置单元格里面的值对齐
                $objPHPExcel->getActiveSheet()->getStyle('A1')->getAlignment()->setWrapText(true);
                $objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValue('A'. $k, $v['name'])
                    ->setCellValue('B'. $k, ' '.$v['mobile'])
                    ->setCellValue('C'. $k, $v['profession_top_id'])
                    ->setCellValue('D'. $k, $v['profession_id'])
                    ->setCellValue('E'. $k, $v['auid'])
                    ->setCellValue('F'. $k, $v['education'])
                    ->setCellValue('G'. $k, $v['expire'])
                    ->setCellValue('H'. $k, $v['account'])
                    ->setCellValue('I'. $k, $v['password']);
            }
        }
        ob_end_clean();
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . $name . '.xls"');
        header('Cache-Control: max-age=0');
        $objWriter = \PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');
        exit;
    }
    
    /**
     * 模板下载的表头
     * @access public
     * @return [array]
     * @since dxf
     */
    static public function cus_muban()
    {
        $rs[3]['name'] = '客户名称';$rs[3]['mobile'] = '手机号';$rs[3]['cate'] = '客户等级'; $rs[3]['source'] = '客户来源';$rs[3]['from'] = '客户分类';$rs[3]['profession_id'] = '工种'; $rs[3]['type'] = '类型';$rs[3]['real_name'] = '业务员账号';
        $rs[4]['name'] = '张三';$rs[4]['mobile'] = '13213656981';$rs[4]['cate'] = 'A类'; $rs[4]['source'] = '个人新开发';$rs[4]['from'] = '个人';$rs[4]['profession_id'] = '低压电工作业'; $rs[4]['type'] = '新办';$rs[4]['real_name'] = 'mameng';
        $rs[5]['name'] = '李四';$rs[5]['mobile'] = '13213656983';$rs[5]['cate'] = 'B类'; $rs[5]['source'] = '公司老客户';$rs[5]['from'] = '个人';$rs[5]['profession_id'] = '塔吊司机'; $rs[5]['type'] = '复审';$rs[5]['real_name'] = 'admin';
        return $rs;
    }

    /**
     * 企业客户模板表头
     * @access public
     * @return [array]
     * @since dxf
     */
    static public function enter_muban()
    {
        $rs[3]['company'] = '企业名称';$rs[3]['contact'] = '联系人';$rs[3]['mobile'] = '手机号'; $rs[3]['auid'] = '业务员'; $rs[3]['address'] = '地址';
        $rs[4]['company'] = '腾讯';$rs[4]['contact'] = '张三';$rs[4]['mobile'] = '13253458566'; $rs[4]['auid'] = 'mameng';$rs[4]['address'] = '郑州市二七区';
        $rs[5]['company'] = '阿里云';$rs[5]['contact'] = '李四';$rs[5]['mobile'] = '13253458568'; $rs[5]['auid'] = 'renbeilei';$rs[5]['address'] = '郑州市金水区';
      return $rs;
    }

    /**
     * 企业客户成员
     * @access public
     * @return [array]
     * @since dxf
     */
    static public function member_muban()
    {
        $rs[3]['name'] = '客户名称';$rs[3]['mobile'] = '手机号'; $rs[3]['profession_top_id'] = '工种';$rs[3]['profession_id'] = '类型';$rs[3]['auid'] = '业务员';$rs[3]['education'] = '学历';$rs[3]['expire'] = '证书到期时间';$rs[3]['account'] = '账号';$rs[3]['password'] = '密码';
        $rs[4]['name'] = '王五';$rs[4]['mobile'] = '13639856523'; $rs[4]['profession_top_id'] = '低压电工作业';$rs[4]['profession_id'] = '新办';$rs[4]['auid'] = 'mameng';$rs[4]['education'] = '大学本科';$rs[4]['expire'] = '2022-12-26';$rs[4]['account'] = 'wangwu';$rs[4]['password'] = '123456';
        return $rs;
    }

    /**
     * 模板下载的表头
     * @access public 
     * @since dxf 
     * @return [array]
     */
    static public function muban(){
        $rs['0']['id']='(导入数据时,请删除括号及里面内容,并删除第一列空白数据,单次导入最大值1000)';
        $rs['0']['from_name']='客户分类(1=个人,2=企业)';
        $rs['0']['cate_name']='客户分类(非必填项)';
        $rs['0']['name']='客户名称';
        $rs['0']['mobile']='手机号';
        $rs['0']['address']='地址(非必填项)';
        $rs['0']['real_name']='业务员(填写业务员ID)';
        return $rs;
    }

    /**
     * 文件上传的字段逻辑
     * @access public 
     * @param file   $uploadfile 上传后的文件名
     * @param array   $ausess 用户数据
     * @since dxf 
     * @return [array]
     */
    static public function uploadFile($uploadfile,$ausess)
    {   
        vendor('PHPExcel.PHPExcel');
        vendor('PHPExcel.PHPExcel.IOFactory');
        vendor('PHPExcel.PHPExcel.Reader.Excel2007.php');
        vendor('PHPExcel.PHPExcel.Reader.Excel5.php');
        vendor('PHPExcel.PHPExcel.Reader.CSV.php');
        $extension = strtolower(pathinfo($uploadfile, PATHINFO_EXTENSION) );
        if ($extension =='xlsx') {
            $objReader = new \PHPExcel_Reader_Excel2007();
            $objPHPExcel = $objReader ->load($uploadfile);
        } else if ($extension =='xls') {
            $objReader = new \PHPExcel_Reader_Excel5();
            $objPHPExcel = $objReader ->load($uploadfile);
        } else if ($extension=='csv') {
            $PHPReader = new \PHPExcel_Reader_CSV();
            //默认输入字符集
            $PHPReader->setInputEncoding('UTF-8');
            //默认的分隔符
            $PHPReader->setDelimiter(',');
            //载入文件
            $objPHPExcel = $PHPReader->load($uploadfile);
        }
        $sheet = $objPHPExcel->getSheet(0);
        $highestRow = $sheet->getHighestRow();           //取得总行数
        $highestColumn = $sheet->getHighestColumn();    //取得总列数
        $objWorksheet = $objPHPExcel->getActiveSheet();
        $highestColumnIndex = \PHPExcel_Cell::columnIndexFromString($highestColumn);
        $headtitle=array();
        $msg=array();
        $status=1;
        $data = [];
        for ($row = 3;$row <= $highestRow;$row++)
        {
            $strs=array();
            //注意highestColumnIndex的列数索引从0开始
            for ($col = 0;$col < $highestColumnIndex;$col++)
            {
                $strs[$col] =$objWorksheet->getCellByColumnAndRow($col, $row)->getValue();
            }
            //检查表头
            if($row == 3){
                if(trim($strs['0'])!='客户名称'){
                    $msg="表头:".$strs['0']."，与要求表头不匹配";
                    $status=-1;
                    break;
                }
                if(trim($strs['1'])!='手机号'){
                    $msg="表头:".$strs['1']."，与要求表头不匹配";
                    $status=-1;
                    break;
                }
                if(trim($strs['2'])!='客户等级'){
                    $msg="表头:".$strs['2']."，与要求表头不匹配";
                    $status=-1;
                    break;
                }
                if(trim($strs['3'])!='客户来源'){
                    $msg="表头:".$strs['3']."，与要求表头不匹配";
                    $status=-1;
                    break;
                }
                if(trim($strs['4'])!='工种'){
                    $msg="表头:".$strs['4']."，与要求表头不匹配";
                    $status=-1;
                    break;
                }
                if(trim($strs['5'])!='类型'){
                    $msg="表头:".$strs['5']."，与要求表头不匹配";
                    $status=-1;
                    break;
                }
//                if(trim($strs['6'])!='证书到期时间'){
//                    $msg="表头:".$strs['6']."，与要求表头不匹配";
//                    $status=-1;
//                    break;
//                }
                if(trim($strs['6'])!='客户分类'){
                    $msg="表头:".$strs['6']."，与要求表头不匹配";
                    $status=-1;
                    break;
                }
                if(trim($strs['7'])!='业务员账号'){
                    $msg="表头:".$strs['7']."，与要求表头不匹配";
                    $status=-1;
                    break;
                }
//                if(trim($strs['8'])!='学历'){
//                    $msg="表头:".$strs['8']."，与要求表头不匹配";
//                    $status=-1;
//                    break;
//                }
//                if(trim($strs['9'])!='账号'){
//                    $msg="表头:".$strs['9']."，与要求表头不匹配";
//                    $status=-1;
//                    break;
//                }
//                if(trim($strs['10'])!='密码'){
//                    $msg="表头:".$strs['10']."，与要求表头不匹配";
//                    $status=-1;
//                    break;
//                }
            }else{
                $data[$row]['from'] = trim($strs['6']);
//                $data[$row]['expire'] = trim($strs['6']);
//                $data[$row]['education'] = trim($strs['8']);
//                $data[$row]['account'] = trim($strs['9']);
//                $data[$row]['password'] = trim($strs['10']);
                $data[$row]['cate_id'] = CustomerCate::where('name',trim($strs['2']))->value('id');
                $data[$row]['name'] = trim($strs['0']);
                $data[$row]['mobile'] = trim($strs['1']);
                $admin = AdminUser::where('admin_name',trim($strs['7']))->find();
                $data[$row]['auid'] = $admin['id'];
                $data[$row]['group_id'] = $admin['group_id'];
                $data[$row]['campus_id'] = $admin['campus_id'] ?? 2;
                $data[$row]['group_id'] = $admin['group_id'];
                $data[$row]['customer_source_name'] = trim($strs['3']);
                $data[$row]['profession_top_id'] = $top_id = Profession::where('name',trim($strs['4']))->value('id');
                $data[$row]['profession_id'] = Profession::where(['name'=>trim($strs['5']),'pid'=>$top_id])->value('id');
                if (empty($data[$row]['mobile'])){
                    unset($data[$row]);
                    break;
                }
                $fromlist = [
                    [
                        'name' => '个人',
                        'id' => '1'
                    ],
                    [
                        'name' => '企业',
                        'id' => '2'
                    ]
                ];
                if($fromlist){
                    $fe=[];
                    $fe_ids=[];
                    foreach ($fromlist as $k => $v) {
                        $fe[$v['id']]=$v['name'];
                        $fe_ids[]=$v['id'];
                    }
                    $ffe=implode(',', $fe);
                    if(in_array($data[$row]['from'], $fe) == false && in_array($data[$row]['from'],$fe_ids) == false){
                        $msg='第'.$row."行数据，客户分类:".$data[$row]['from']."，不正确，正确的类型为：".$ffe;
                        $status=-1;
                        break;
                    }
                    //反转充值类型
                    $dt=array_flip($fe);
                    $data[$row]['from'] = is_numeric($data[$row]['from']) ? $data[$row]['from'] : $dt[$data[$row]['from']];
                }
                if(!is_Mobile($data[$row]['mobile'])){
                    $msg='第'.$row."行数据，手机号码:".$data[$row]['mobile']."，不正确";
                    $status=-1;
                    break;
                }
                $data[$row]['create_time']=time();
                $data[$row]['ren_time']=time();
            }
        }
        foreach ($data as $k => $v){
            $customer = (new Customer())
                ->where([
                    'mobile' => $v['mobile']
                ])
                ->value('id');
            if (!empty($customer)){
                $msg = "手机号：".$v['mobile'].'已存在，请删除后重新导入';
                $status=-1;
                break;
            }
        }
        if($status==1){
            return ['status'=>1,'msg'=>'数据检查成功','data'=>$data];
        }else{
            return ['status'=>-1,'msg'=>$msg];
        }
    }

    /**
     * 企业客户信息
     * @access public
     * @param file   $uploadfile 上传后的文件名
     * @param array   $ausess 用户数据
     * @since dxf
     * @return [array]
     */
    static public function uploadFile_enter($uploadfile,$ausess)
    {
        vendor('PHPExcel.PHPExcel');
        vendor('PHPExcel.PHPExcel.IOFactory');
        vendor('PHPExcel.PHPExcel.Reader.Excel2007.php');
        vendor('PHPExcel.PHPExcel.Reader.Excel5.php');
        vendor('PHPExcel.PHPExcel.Reader.CSV.php');
        $extension = strtolower(pathinfo($uploadfile, PATHINFO_EXTENSION) );
        if ($extension =='xlsx') {
            $objReader = new \PHPExcel_Reader_Excel2007();
            $objPHPExcel = $objReader ->load($uploadfile);
        } else if ($extension =='xls') {
            $objReader = new \PHPExcel_Reader_Excel5();
            $objPHPExcel = $objReader ->load($uploadfile);
        } else if ($extension=='csv') {
            $PHPReader = new \PHPExcel_Reader_CSV();
            //默认输入字符集
            $PHPReader->setInputEncoding('UTF-8');
            //默认的分隔符
            $PHPReader->setDelimiter(',');
            //载入文件
            $objPHPExcel = $PHPReader->load($uploadfile);
        }
        $sheet = $objPHPExcel->getSheet(0);
        $highestRow = $sheet->getHighestRow();           //取得总行数
        $highestColumn = $sheet->getHighestColumn();    //取得总列数
        $objWorksheet = $objPHPExcel->getActiveSheet();
        $highestColumnIndex = \PHPExcel_Cell::columnIndexFromString($highestColumn);
        $headtitle=array();
        $msg=array();
        $status=1;
        $data = [];
        for ($row = 3;$row <= $highestRow;$row++)
        {
            $strs=array();
            //注意highestColumnIndex的列数索引从0开始
            for ($col = 0;$col < $highestColumnIndex;$col++)
            {
                $strs[$col] =$objWorksheet->getCellByColumnAndRow($col, $row)->getValue();
            }
            //检查表头
            if($row == 3){
                if(trim($strs['0'])!='企业名称'){
                    $msg="表头:".$strs['0']."，与要求表头不匹配";
                    $status=-1;
                    break;
                }
                if(trim($strs['1'])!='联系人'){
                    $msg="表头:".$strs['1']."，与要求表头不匹配";
                    $status=-1;
                    break;
                }
                if(trim($strs['2'])!='手机号'){
                    $msg="表头:".$strs['2']."，与要求表头不匹配";
                    $status=-1;
                    break;
                }
                if(trim($strs['3'])!='业务员'){
                    $msg="表头:".$strs['3']."，与要求表头不匹配";
                    $status=-1;
                    break;
                }
                if(trim($strs['4'])!='地址'){
                    $msg="表头:".$strs['4']."，与要求表头不匹配";
                    $status=-1;
                    break;
                }
            }else{
                $data[$row]['company'] = trim($strs['0']);
                $data[$row]['contact'] = trim($strs['1']);
                $data[$row]['mobile'] = trim($strs['2']);
                $data[$row]['address'] = trim($strs['4']);
                $admin = AdminUser::where('admin_name',trim($strs['3']))->find();
                $data[$row]['auid'] = $admin['id'];$data[$row]['group_id'] = $admin['group_id'];
                $data[$row]['create_time'] = time();
                if (empty($data[$row]['mobile'])){
                    unset($data[$row]);
                    break;
                }
                if(!is_Mobile($data[$row]['mobile'])){
                    $msg='第'.$row."行数据，手机号码:".$data[$row]['mobile']."，不正确";
                    $status=-1;
                    break;
                }
                $data[$row]['create_time']=time();
            }
        }
        foreach ($data as $k => $v){
            $customer = db('company')
                ->where([
                    'mobile' => $v['mobile']
                ])
                ->value('id');
            if (!empty($customer)){
                $msg = "手机号：".$v['mobile'].'已存在，请删除后重新导入';
                $status=-1;
                break;
            }
        }
        if($status==1){
            return ['status'=>1,'msg'=>'数据检查成功','data'=>$data];
        }else{
            return ['status'=>-1,'msg'=>$msg];
        }
    }

    static public function uploadFile_member($uploadfile,$ausess)
    {
        vendor('PHPExcel.PHPExcel');
        vendor('PHPExcel.PHPExcel.IOFactory');
        vendor('PHPExcel.PHPExcel.Reader.Excel2007.php');
        vendor('PHPExcel.PHPExcel.Reader.Excel5.php');
        vendor('PHPExcel.PHPExcel.Reader.CSV.php');
        $extension = strtolower(pathinfo($uploadfile, PATHINFO_EXTENSION) );
        if ($extension =='xlsx') {
            $objReader = new \PHPExcel_Reader_Excel2007();
            $objPHPExcel = $objReader ->load($uploadfile);
        } else if ($extension =='xls') {
            $objReader = new \PHPExcel_Reader_Excel5();
            $objPHPExcel = $objReader ->load($uploadfile);
        } else if ($extension=='csv') {
            $PHPReader = new \PHPExcel_Reader_CSV();
            //默认输入字符集
            $PHPReader->setInputEncoding('UTF-8');
            //默认的分隔符
            $PHPReader->setDelimiter(',');
            //载入文件
            $objPHPExcel = $PHPReader->load($uploadfile);
        }
        $sheet = $objPHPExcel->getSheet(0);
        $highestRow = $sheet->getHighestRow();           //取得总行数
        $highestColumn = $sheet->getHighestColumn();    //取得总列数
        $objWorksheet = $objPHPExcel->getActiveSheet();
        $highestColumnIndex = \PHPExcel_Cell::columnIndexFromString($highestColumn);
        $headtitle=array();
        $msg=array();
        $status=1;
        $data = [];
        for ($row = 3;$row <= $highestRow;$row++)
        {
            $strs=array();
            //注意highestColumnIndex的列数索引从0开始
            for ($col = 0;$col < $highestColumnIndex;$col++)
            {
                $strs[$col] =$objWorksheet->getCellByColumnAndRow($col, $row)->getValue();
            }
            //检查表头
            if($row == 3){
                if(trim($strs['0'])!='客户名称'){
                    $msg="表头:".$strs['0']."，与要求表头不匹配";
                    $status=-1;
                    break;
                }
                if(trim($strs['1'])!='手机号'){
                    $msg="表头:".$strs['1']."，与要求表头不匹配";
                    $status=-1;
                    break;
                }
                if(trim($strs['2'])!='工种'){
                    $msg="表头:".$strs['2']."，与要求表头不匹配";
                    $status=-1;
                    break;
                }
                if(trim($strs['3'])!='类型'){
                    $msg="表头:".$strs['3']."，与要求表头不匹配";
                    $status=-1;
                    break;
                }
                if(trim($strs['4'])!='业务员'){
                    $msg="表头:".$strs['4']."，与要求表头不匹配";
                    $status=-1;
                    break;
                }
                if(trim($strs['5'])!='学历'){
                    $msg="表头:".$strs['5']."，与要求表头不匹配";
                    $status=-1;
                    break;
                }
                if(trim($strs['6'])!='证书到期时间'){
                    $msg="表头:".$strs['6']."，与要求表头不匹配";
                    $status=-1;
                    break;
                }
                if(trim($strs['7'])!='账号'){
                    $msg="表头:".$strs['7']."，与要求表头不匹配";
                    $status=-1;
                    break;
                }
                if(trim($strs['8'])!='密码'){
                    $msg="表头:".$strs['8']."，与要求表头不匹配";
                    $status=-1;
                    break;
                }
            }else{
                $data[$row]['name'] = trim($strs['0']);
                $data[$row]['mobile'] = trim($strs['1']);
                $data[$row]['education'] = trim($strs['5']);
                $data[$row]['expire'] = trim($strs['6']);
                $data[$row]['account'] = trim($strs['7']);
                $data[$row]['password'] = trim($strs['8']);
                $data[$row]['cate_id'] = Profession::where('name',trim($strs['2']))->value('cate_id');
                $data[$row]['profession_top_id'] = Profession::where('name',trim($strs['2']))->value('id');
                $data[$row]['profession_id'] = $profession_id = Profession::where('name',trim($strs['3']))->value('id');
                $admin = AdminUser::where('admin_name',trim($strs['4']))->find();
                $data[$row]['auid'] = $admin['id'];
                $data[$row]['group_id'] = $admin['group_id'];
                $data[$row]['campus_id'] = $admin['campus_id'];
                if (empty($data[$row]['mobile'])){
                    unset($data[$row]);
                    break;
                }
                if(!is_Mobile($data[$row]['mobile'])){
                    $msg='第'.$row."行数据，手机号码:".$data[$row]['mobile']."，不正确";
                    $status=-1;
                    break;
                }
                $data[$row]['create_time']=time();
            }
        }
        foreach ($data as $k => $v){
            $customer = (new PayStudent())
                ->where([
                    'mobile' => $v['mobile'],
                    'profession_id'=>$profession_id
                ])
                ->value('id');
            if (!empty($customer)){
                $msg = "手机号：".$v['mobile'].'已存在，请删除后重新导入';
                $status=-1;
                break;
            }
        }
        if($status==1){
            return ['status'=>1,'msg'=>'数据检查成功','data'=>$data];
        }else{
            return ['status'=>-1,'msg'=>$msg];
        }
    }

}
 

