<?php

namespace app\backend\logic;

use app\backend\controller\LabourUser;
use app\backend\model\AdminUser;
use app\backend\model\Customer;
use app\backend\model\CustomerCate;
use app\backend\model\LabourCompanyDemand;
use app\backend\model\PayStudent;
use app\backend\model\Profession;
use think\Db;
use think\Model;
use think\Request;

class LabourLogic
{
    /**
     * 客户查询的逻辑
     * @access public
     * @param array $param 条件数据
     * @param array $ausess 账号的session信息
     * @return array [array]
     * @since dxf
     */
    static public function selectParam($param, $ausess)
    {
        $where = [];
        //班级名称
        if (isset($param['name']) && !empty($param['name'])) {
            $where['name'] = array('like', "%$param[name]%");
        }
        //班主任
        if (isset($param['teacher_id']) && !empty($param['teacher_id'])) {
            $where['teacher_id'] = $param['teacher_id'];
        }
        // 业务员
        if (isset($param['admin_id']) && !empty($param['admin_id'])) {
            $where['salesman_id'] = $param['admin_id'];
        }
        // 工作经验
        if (!empty($param['work_exp'])){
            $where['work_exp'] = $param['work_exp'];
        }
        //学员状态
        if ($param['ware_id'] == 1){
            $where['status'] = ['in','1,2,3,5'];
        }else{
            $where['status'] = ['in','4'];
        }
        if (!empty($param['status']) && $param['ware_id'] != 2){
            $where['status'] = $param['status'];
        }
        //工种
        if (!empty($param['profession_id'])) {
            $where['profession_id'] = $param['profession_id'];
        } // 一级栏目
        elseif (!empty($param['pid'])) {
            $profession_ids = (new Profession())
                ->where([
                    'pid' => $param['pid']
                ])
                ->column('id');
            $where['profession_id'] = ['in', $profession_ids];
        } // 工种类型
        elseif (!empty($param['cate_id'])) {
            $profession_ids = (new Profession())
                ->where([
                    'cate_id' => $param['cate_id'],
                    'pid' => 0
                ])
                ->column('id');
            $where['profession_id'] = ['in', $profession_ids];
        }
        return $where;
    }
    /**
     * 客户查询的逻辑
     * @access public
     * @param array $param 条件数据
     * @param array $ausess 账号的session信息
     * @return array [array]
     * @since dxf
     */
    static public function selectCompanyParam($param, $ausess)
    {
        $where = [];
        //班级名称
        if (isset($param['name']) && !empty($param['name'])) {
            $where['name'] = array('like', "%$param[name]%");
        }
        if (isset($param['contact_name']) && !empty($param['contact_name'])) {
            $where['contact_name'] = array('like', "%$param[contact_name]%");
        }
        if (isset($param['contact_mobile']) && !empty($param['contact_mobile'])) {
            $where['contact_mobile'] = array('like', "%$param[contact_mobile]%");
        }
        //班主任
        if (isset($param['teacher_id']) && !empty($param['teacher_id'])) {
            $where['salesman_id'] = $param['teacher_id'];
        }
        // 需求
        if (!empty($param['demand_id'])){
            $where['demand_id'] = $param['demand_id'];
        }
        // 用人企业
        if (!empty($param['company_id'])){
            $where['company_id'] = $param['company_id'];
        }
        //学员状态
        if (!empty($param['status'])){
            $where['status'] = $param['status'];
        }
        return $where;
    }

    /**
     * 客户查询的逻辑
     * @access public
     * @param array $param 条件数据
     * @param array $ausess 账号的session信息
     * @return array [array]
     * @since dxf
     */
    static public function selectDemandParam($param, $ausess)
    {
        $where = [];
        // 公司ID
        if (!empty($param['company_id'])){
            $where['company_id'] = $param['company_id'];
        }
        //班级名称
        if (isset($param['name']) && !empty($param['name'])) {
            $where['name'] = array('like', "%$param[name]%");
        }
        if (isset($param['mobile']) && !empty($param['mobile'])) {
            $where['mobile'] = array('like', "%$param[contact_mobile]%");
        }
        //工种
        if (!empty($param['profession_id'])) {
            $where['profession_id'] = $param['profession_id'];
        } // 一级栏目
        elseif (!empty($param['pid'])) {
            $profession_ids = (new Profession())
                ->where([
                    'pid' => $param['pid']
                ])
                ->column('id');
            $where['profession_id'] = ['in', $profession_ids];
        } // 工种类型
        elseif (!empty($param['cate_id'])) {
            $profession_ids = (new Profession())
                ->where([
                    'cate_id' => $param['cate_id'],
                    'pid' => 0
                ])
                ->column('id');
            $where['profession_id'] = ['in', $profession_ids];
        }
        return $where;
    }

    /**
     * 客户查询的逻辑
     * @access public
     * @param array $param 条件数据
     * @param array $ausess 账号的session信息
     * @return array [array]
     * @since dxf
     */
    static public function selectRecommendParam($param, $ausess)
    {
        $where = [];
        //班级名称
        if (isset($param['name']) && !empty($param['name'])) {
            $where['name'] = array('like', "%$param[name]%");
        }
        if (isset($param['mobile']) && !empty($param['mobile'])) {
            $where['mobile'] = array('like', "%$param[contact_mobile]%");
        }
        if (isset($param['work_exp']) && !empty($param['work_exp'])) {
            $where['work_exp'] = array('like', "%$param[work_exp]%");
        }
        //工种
        if (!empty($param['profession_id'])) {
            $where['profession_id'] = $param['profession_id'];
        } // 一级栏目
        elseif (!empty($param['pid'])) {
            $profession_ids = (new Profession())
                ->where([
                    'pid' => $param['pid']
                ])
                ->column('id');
            $where['profession_id'] = ['in', $profession_ids];
        } // 工种类型
        elseif (!empty($param['cate_id'])) {
            $profession_ids = (new Profession())
                ->where([
                    'cate_id' => $param['cate_id'],
                    'pid' => 0
                ])
                ->column('id');
            $where['profession_id'] = ['in', $profession_ids];
        }
        // 需求
        if (!empty($param['demand_id'])){
            $demand = LabourCompanyDemand::get($param['demand_id']);
            $where['profession_id'] = $demand['profession_id'];
        }
        return $where;
    }

    /**
     * 模板下载的表头
     * @access public
     * @return [array]
     * @since dxf
     */
    static public function cus_muban()
    {
        $rs[3]['name'] = '客户名称';$rs[3]['mobile'] = '手机号';$rs[3]['id_card'] = '身份证号';$rs[3]['work_exp'] = '工作经验'; $rs[3]['salary_expectation'] = '期望薪资';$rs[3]['gender'] = '性别';$rs[3]['profession_id'] = '工种'; $rs[3]['type'] = '类型';
        $rs[4]['name'] = '张三';$rs[4]['mobile'] = '13213656981';$rs[4]['id_card'] = '410322199502052616';$rs[4]['work_exp'] = '3年'; $rs[4]['salary_expectation'] = '5000';$rs[4]['gender'] = '男';$rs[4]['profession_id'] = '低压电工作业'; $rs[4]['type'] = '新办';
        $rs[5]['name'] = '李四';$rs[5]['mobile'] = '13213656983';$rs[5]['id_card'] = '410322199502052616';$rs[5]['work_exp'] = '5年'; $rs[5]['salary_expectation'] = '6800';$rs[5]['gender'] = '女';$rs[5]['profession_id'] = '塔吊司机'; $rs[5]['type'] = '复审';
        return $rs;
    }

    /**
     * 客户数据下载的逻辑
     * @access public
     * @param array $data 要下载的数据
     * @param array $name excel表名称
     * @return [file]
     * @since dxf
     */
    static public function cus_down($data, $name,$title = "")
    {
        vendor('PHPExcel.PHPExcel');
        $objPHPExcel = new \PHPExcel();
        $objPHPExcel->getActiveSheet()->getStyle('A:H')->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        //遍历数组，注意数组对应的下标
        foreach ($data as $k => $v) {
            //合并单元格
            // $objPHPExcel->setActiveSheetIndex(0)->mergeCells('A1:K2');
            $objPHPExcel->setActiveSheetIndex(0)->mergeCells('A1:H2');
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A1', $title);
            //设置单元格里面的值对齐
            $objPHPExcel->getActiveSheet()->getStyle('A1')->getAlignment()->setWrapText(true);
            $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue('A' . $k, $v['name'])
                ->setCellValue('B' . $k, ' ' . $v['mobile'])
                ->setCellValue('C' . $k, ' ' . $v['id_card'])
                ->setCellValue('D' . $k, $v['work_exp'])
                ->setCellValue('E' . $k, $v['salary_expectation'])
                ->setCellValue('F' . $k, $v['gender'])
                ->setCellValue('G' . $k, $v['profession_id'])
                ->setCellValue('H' . $k, $v['type']);
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
                if(trim($strs['2'])!='身份证号'){
                    $msg="表头:".$strs['2']."，与要求表头不匹配";
                    $status=-1;
                    break;
                }
                if(trim($strs['3'])!='工作经验'){
                    $msg="表头:".$strs['3']."，与要求表头不匹配";
                    $status=-1;
                    break;
                }
                if(trim($strs['4'])!='期望薪资'){
                    $msg="表头:".$strs['4']."，与要求表头不匹配";
                    $status=-1;
                    break;
                }
                if(trim($strs['5'])!='性别'){
                    $msg="表头:".$strs['5']."，与要求表头不匹配";
                    $status=-1;
                    break;
                }
                if(trim($strs['6'])!='工种'){
                    $msg="表头:".$strs['6']."，与要求表头不匹配";
                    $status=-1;
                    break;
                }
                if(trim($strs['7'])!='类型'){
                    $msg="表头:".$strs['7']."，与要求表头不匹配";
                    $status=-1;
                    break;
                }
            }else{
                $data[$row]['name'] = trim($strs['0']);
                $data[$row]['mobile'] = trim($strs['1']);
                $data[$row]['id_card'] = trim($strs['2']);
                $admin = AdminUser::where('id',$ausess['auid'])->find();
                $data[$row]['salesman_id'] = $admin['id'];
                $data[$row]['campus_id'] = $admin['campus_id'] ?? 2;
                $data[$row]['work_exp'] = trim($strs['3']);
                $data[$row]['salary_expectation'] = trim($strs['4']);
                $data[$row]['gender'] = trim($strs['5']);
                $top_id = Profession::where('name',trim($strs['6']))->value('id');
                $data[$row]['profession_id'] = Profession::where(['name'=>trim($strs['7']),'pid'=>$top_id])->value('id');
                if (empty($data[$row]['mobile'])){
                    unset($data[$row]);
                    break;
                }
                if(!is_Mobile($data[$row]['mobile'])){
                    $msg='第'.$row."行数据，手机号码:".$data[$row]['mobile']."，不正确";
                    $status=-1;
                    break;
                }
                $data[$row]['create_time'] = time();
                $data[$row]['status'] = 1;
            }
        }
        foreach ($data as $k => $v){
            $labour = (new \app\backend\model\LabourUser())
                ->where(['mobile' => $v['mobile']])
                ->value('id');
            if (!empty($labour)){
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
 

