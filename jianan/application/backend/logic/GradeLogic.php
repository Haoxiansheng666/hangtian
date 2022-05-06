<?php

namespace app\backend\logic;

use app\backend\model\AdminUser;
use app\backend\model\OccupationStudent;
use app\backend\model\OccuProfession;
use app\backend\model\PayStudent;
use app\backend\model\Profession;
use think\Db;
use think\Request;

class GradeLogic
{
    /**
     * 客户查询的逻辑
     * @access public
     * @param array $param 条件数据
     * @param array $ausess 账号的session信息
     * @return [array]
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
        //工种
        if (!empty($param['profession_id'])) {
            $where['profession_id'] = $param['profession_id'];
        }
        return $where;
    }

    /**
     * 已选中学员筛选条件
     * @param $param
     * @param $admin
     * @return array
     */
    public static function selectStudentParam($param, $admin){
        $s_where = [];
        $where = [];
        // 客户名称
        if (!empty($param['name'])){
            $s_where['name'] = ['like',"%".$param['name']."%"];
        }
        // 客户手机号
        if (!empty($param['mobile'])){
            $s_where['mobile'] = ['like',"%".$param['mobile']."%"];
        }
        // 业务员
        if (!empty($param['auid'])){
            $s_where['auid'] = $param['auid'];
        }
        // 工种
        if (!empty($param['profession_id'])){
            $s_where['profession_id'] = $param['profession_id'];
        }
        // 公司名称
        if (!empty($param['company'])){
            $s_where['company'] = ['like',"%".$param['company']."%"];
        }
        // 获取学员ID
        if (!empty($s_where)){
            $pay_student_ids = (new PayStudent())->where($s_where)->column('id');
            $where['pay_student_id'] = ['in',$pay_student_ids];
        }
        if (!empty($param['grade_id'])){
            $where['grade_id'] = $param['grade_id'];
        }
        return $where;
    }

    /**
     * 已选中学员筛选条件
     * @param $param
     * @param $admin
     * @return array
     */
    public static function selectStudent($param){
        $s_where = [];
        // 客户名称
        if (!empty($param['name'])){
            $s_where['name'] = ['like',"%".$param['name']."%"];
        }
        // 客户手机号
        if (!empty($param['mobile'])){
            $s_where['mobile'] = ['like',"%".$param['mobile']."%"];
        }
        // 工种
        if (!empty($param['profession_id'])){
            $s_where['profession_id'] = $param['profession_id'];
        }
        // 公司名称
        if (!empty($param['company'])){
            $s_where['company'] = ['like',"%".$param['company']."%"];
        }
        if (!empty($param['grade_id'])){
            $s_where['grade_id'] = $param['grade_id'];
        }
        return $s_where;
    }

    /**
     * 获取待培训学员筛选条件
     * @param $param
     * @param $admin
     * @return array
     */
    public static function selectStudentCheckParam($param, $admin){
        $s_where = [];
        $where = [];
        // 客户名称
        if (!empty($param['name'])){
            $s_where['name'] = ['like',"%".$param['name']."%"];
        }
        // 客户手机号
        if (!empty($param['mobile'])){
            $s_where['mobile'] = ['like',"%".$param['mobile']."%"];
        }
        // 业务员
        if (!empty($param['auid'])){
            $s_where['auid'] = $param['auid'];
        }
        // 工种
        if (!empty($param['profession_id'])){
            $s_where['profession_id'] = $param['profession_id'];
        }
        // 公司名称
        if (!empty($param['company'])){
            $s_where['company'] = ['like',"%".$param['company']."%"];
        }
        // 获取学员ID
        if (!empty($s_where)){
            $pay_student_ids = (new PayStudent())->where($s_where)->column('id');
            $where['pay_student_id'] = ['in',$pay_student_ids];
        }

        return $where;
    }

    /**
     * 客户数据下载的逻辑
     * @access public
     * @param array $data 要下载的数据
     * @param array $name excel表名称
     * @param string $title excel表名称
     * @return [file]
     * @since dxf
     */
    static public function down($data, $name,$title)
    {
        vendor('PHPExcel.PHPExcel');
        $objPHPExcel = new \PHPExcel();
        $objPHPExcel->getActiveSheet()->getStyle('A:N')->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        //遍历数组，注意数组对应的下标
        if ($name == '职业技能提升学员导入模板') {
            foreach ($data as $k => $v) {
                //合并单元格
                $objPHPExcel->setActiveSheetIndex(0)->mergeCells('A1:L2');
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A1', $title);
                //设置单元格里面的值对齐
                $objPHPExcel->getActiveSheet()->getStyle('A1')->getAlignment()->setWrapText(true);
                $objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValue('A' . $k, $v['name'])
                    ->setCellValue('B' . $k, $v['mobile'])
                    ->setCellValue('C' . $k, $v['id_card']."\t")
                    ->setCellValue('D' . $k, $v['address'])
                    ->setCellValue('E' . $k, $v['type'])
                    ->setCellValue('F' . $k, $v['company'])
                    ->setCellValue('G' . $k, $v['profession_top_id'])
                    ->setCellValue('H' . $k, $v['profession_id'])
                    ->setCellValue('I' . $k, $v['level'])
                    ->setCellValue('J' . $k, $v['price'])
                    ->setCellValue('K' . $k, $v['code'])
                    ->setCellValue('L' . $k, $v['remarks']);
            }
        } else {
            foreach ($data as $k => $v) {
                //合并单元格
                $objPHPExcel->setActiveSheetIndex(0)->mergeCells('A1:L2');
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A1', $title);
                //设置单元格里面的值对齐
                $objPHPExcel->getActiveSheet()->getStyle('A1')->getAlignment()->setWrapText(true);
                $objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValue('A' . $k, $v['name'])
                    ->setCellValue('B' . $k, $v['mobile'])
                    ->setCellValue('C' . $k, $v['id_card'])
                    ->setCellValue('D' . $k, $v['address'])
                    ->setCellValue('E' . $k, $v['type'])
                    ->setCellValue('F' . $k, $v['company'])
                    ->setCellValue('G' . $k, $v['profession_top_id'])
                    ->setCellValue('H' . $k, $v['profession_id'])
                    ->setCellValue('I' . $k, $v['level'])
                    ->setCellValue('J' . $k, $v['price'])
                    ->setCellValue('K' . $k, $v['code'])
                    ->setCellValue('L' . $k, $v['remarks']);
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
    static public function muban()
    {
        $rs['3']['name'] = '姓名';$rs['3']['mobile'] = '手机号';$rs['3']['id_card'] = '身份证号';$rs['3']['address'] = '家庭地址';$rs['3']['type'] = '人员类别';
        $rs['3']['company'] = '单位名称';$rs['3']['profession_top_id'] = '工种';$rs['3']['profession_id'] = '培训级别';$rs['3']['level'] = '项目类别';
        $rs['3']['price'] = '补贴金额';$rs['3']['code'] = '证书编号';$rs['3']['remarks'] = '备注';

        $rs['4']['name'] = '张三';$rs['4']['mobile'] = '13213688945';$rs['4']['id_card'] = '410322196505061234';$rs['4']['address'] = '郑州金水';$rs['4']['type'] = '个人';
        $rs['4']['company'] = '百度';$rs['4']['profession_top_id'] = '电工';$rs['4']['profession_id'] = '五级';$rs['4']['level'] = '社评';
        $rs['4']['price'] = '999';$rs['4']['code'] = '4561289425';$rs['4']['remarks'] = '电工五级考证补贴';

        $rs['5']['name'] = '李四';$rs['5']['mobile'] = '13213688956';$rs['5']['id_card'] = '410322198508061256';$rs['5']['address'] = '南阳卧龙';$rs['5']['type'] = '退役军人';
        $rs['5']['company'] = '腾讯';$rs['5']['profession_top_id'] = '焊工';$rs['5']['profession_id'] = '三级';$rs['5']['level'] = '建筑工匠';
        $rs['5']['price'] = '666';$rs['5']['code'] = '19812347527';$rs['5']['remarks'] = '焊工三级考证补贴';
        return $rs;
    }

    /**
     * 文件上传的字段逻辑
     * @access public
     * @param file $uploadfile 上传后的文件名
     * @param string $campus_id 用户数据
     * @param string $grade 用户数据
     * @return [array]
     * @since dxf
     */
    static public function uploadFile($uploadfile, $campus_id,$grade = 1)
    {
        vendor('PHPExcel.PHPExcel');
        vendor('PHPExcel.PHPExcel.IOFactory');
        vendor('PHPExcel.PHPExcel.Reader.Excel2007.php');
        vendor('PHPExcel.PHPExcel.Reader.Excel5.php');
        vendor('PHPExcel.PHPExcel.Reader.CSV.php');
        $extension = strtolower(pathinfo($uploadfile, PATHINFO_EXTENSION));
        if ($extension == 'xlsx') {
            $objReader = new \PHPExcel_Reader_Excel2007();
            $objPHPExcel = $objReader->load($uploadfile);
        } else if ($extension == 'xls') {
            $objReader = new \PHPExcel_Reader_Excel5();
            $objPHPExcel = $objReader->load($uploadfile);
        } else if ($extension == 'csv') {
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
        //echo '总行数='.$highestRow;
        $highestColumnIndex = \PHPExcel_Cell::columnIndexFromString($highestColumn);
        $headtitle = array();
        $msg = array();
        $status = 1;
        for ($row = 3; $row <= $highestRow; $row++) {
            $strs = array();
            //注意highestColumnIndex的列数索引从0开始
            for ($col = 0; $col < $highestColumnIndex; $col++) {
                $strs[$col] = $objWorksheet->getCellByColumnAndRow($col, $row)->getValue();
            }
            //检查表头
            if ($row == 3) {
                if (trim($strs['0']) != '姓名') {
                    $msg = "表头:" . $strs['0'] . "，与要求表头不匹配，请修改为".trim($strs['0']);
                    $status = -1;
                    break;
                }
                if (trim($strs['1']) != '手机号') {
                    $msg = "表头:" . $strs['1'] . "，与要求表头不匹配，请修改为".trim($strs['1']);
                    $status = -1;
                    break;
                }
                if (trim($strs['2']) != '身份证号') {
                    $msg = "表头:" . $strs['2'] . "，与要求表头不匹配，请修改为".trim($strs['2']);
                    $status = -1;
                    break;
                }
                if (trim($strs['3']) != '家庭地址') {
                    $msg = "表头:" . $strs['3'] . "，与要求表头不匹配，请修改为".trim($strs['3']);
                    $status = -1;
                    break;
                }
                if (trim($strs['4']) != '人员类别') {
                    $msg = "表头:" . $strs['4'] . "，与要求表头不匹配，请修改为".trim($strs['4']);
                    $status = -1;
                    break;
                }
                if (trim($strs['5']) != '单位名称') {
                    $msg = "表头:" . $strs['5'] . "，与要求表头不匹配，请修改为".trim($strs['5']);
                    $status = -1;
                    break;
                }
                if (trim($strs['6']) != '工种') {
                    $msg = "表头:" . $strs['6'] . "，与要求表头不匹配，请修改为".trim($strs['6']);
                    $status = -1;
                    break;
                }
                if (trim($strs['7']) != '培训级别') {
                    $msg = "表头:" . $strs['7'] . "，与要求表头不匹配，请修改为".trim($strs['7']);
                    $status = -1;
                    break;
                }
                if (trim($strs['8']) != '项目类别') {
                    $msg = "表头:" . $strs['8'] . "，与要求表头不匹配，请修改为".trim($strs['8']);
                    $status = -1;
                    break;
                }
                if (trim($strs['9']) != '补贴金额') {
                    $msg = "表头:" . $strs['9'] . "，与要求表头不匹配，请修改为".trim($strs['9']);
                    $status = -1;
                    break;
                }
                if (trim($strs['10']) != '证书编号') {
                    $msg = "表头:" . $strs['10'] . "，与要求表头不匹配，请修改为".trim($strs['10']);
                    $status = -1;
                    break;
                }
                if (trim($strs['11']) != '备注') {
                    $msg = "表头:" . $strs['11'] . "，与要求表头不匹配，请修改为".trim($strs['11']);
                    $status = -1;
                    break;
                }
            } elseif ($row > 1001) {
                $msg = '导入失败！单次最大导入量1000条';
                $status = -1;
                break;
            } else {
                $data[$row]['name'] = trim($strs['0']);
                $data[$row]['mobile'] = trim($strs['1']);
                $data[$row]['id_card'] = trim($strs['2']);
                $data[$row]['address'] = trim($strs['3']);
                $data[$row]['type'] = trim($strs['4']);
                $data[$row]['company'] = trim($strs['5']);
                $data[$row]['profession_top_id'] = OccuProfession::where('name',trim($strs['6']))->value('id');
                $data[$row]['profession_id'] = OccuProfession::where('name',trim($strs['7']))->value('id');
                $data[$row]['level'] = trim($strs['8']);
                $data[$row]['price'] = trim($strs['9']);
                $data[$row]['code'] = trim($strs['10']);
                $data[$row]['remark'] = trim($strs['11']);
                if (empty($data[$row]['mobile'])){
                    unset($data[$row]);
                    continue;
                }

                if (!is_Mobile($data[$row]['mobile'])) {
                    $msg = '第' . $row . "行数据，手机号码:" . $data[$row]['mobile'] . "，不正确";
                    $status = -1;
                    break;
                }
                $pay_student = OccupationStudent::get(['mobile' => $data[$row]['mobile'],'profession_id'=>$data[$row]['profession_id'],'grade_id'=>$grade]);
                if (!empty($pay_student)){
                    return ['status' => -1, 'msg' => '此电话号已存在:'.$data[$row]['mobile']];
                }
                $data[$row]['create_time'] = time();
                $data[$row]['grade_id'] = $grade;
                $data[$row]['campus_id'] = $campus_id;
            }
        }
        if ($status == 1) {
            return ['status' => 1, 'msg' => '数据检查成功', 'data' => $data];
        } else {
            return ['status' => -1, 'msg' => $msg];
        }
    }


}
 

