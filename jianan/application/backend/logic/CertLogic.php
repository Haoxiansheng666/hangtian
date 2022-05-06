<?php

namespace app\backend\logic;

use app\backend\model\AdminUser;
use app\backend\model\PayStudent;
use app\backend\model\Profession;
use think\Db;
use think\Request;

class CertLogic
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
        $where1 = [];
        //班级名称
        if (isset($param['name']) && !empty($param['name'])) {
            $where1['name'] = array('like', "%$param[name]%");
        }
        //班主任
        if (isset($param['mobile']) && !empty($param['mobile'])) {
            $where1['mobile'] = $param['mobile'];
        }

        $where = [];
        if (isset($param['from']) && !empty($param['from'])) {
            $where['from'] = $param['from'];
        }
        if($where1){
            $pay_student = (new PayStudent())->where($where1)->column('id');
            $where['pay_student_id'] =  ['in',$pay_student];
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
     * 获取待培训学员筛选条件
     * @param $param
     * @param $admin
     * @return array
     */
    public static function selectStudentCheckParam($param, $admin){
        $where = [];
        // 客户名称
        if (!empty($param['name'])){
            $where['name'] = ['like',"%".$param['name']."%"];
        }
        // 客户手机号
        if (!empty($param['mobile'])){
            $where['mobile'] = ['like',"%".$param['mobile']."%"];
        }
        // 业务员
        if (!empty($param['auid'])){
            $where['auid'] = $param['auid'];
        }
        // 工种
        if (!empty($param['profession_id'])){
            $where['profession_id'] = $param['profession_id'];
        }
        // 公司名称
        if (!empty($param['company'])){
            $where['company'] = ['like',"%".$param['company']."%"];
        }
        return $where;
    }

    /**
     * 客户数据下载的逻辑
     * @access public
     * @param array $data 要下载的数据
     * @param array $name excel表名称
     * @return [file]
     * @since dxf
     */
    static public function down($data, $name)
    {
        vendor('PHPExcel.PHPExcel');
        $objPHPExcel = new \PHPExcel();
        $objPHPExcel->getActiveSheet()->getStyle('A:N')->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        //遍历数组，注意数组对应的下标
        if ($name == '客户信息导入模板') {
            foreach ($data as $k => $v) {
                $k = 1;
                $objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValue('A' . $k, $v['id'])
                    ->setCellValue('B' . $k, $v['from'])
                    ->setCellValue('C' . $k, $v['name'])
                    ->setCellValue('D' . $k, $v['mobile'])
                    ->setCellValue('E' . $k, $v['id_card'])
                    ->setCellValue('F' . $k, $v['company'])
                    ->setCellValue('G' . $k, $v['profession_id'])
                    ->setCellValue('H' . $k, $v['recommend_job'])
                    ->setCellValue('I' . $k, $v['status'])
                    ->setCellValue('J' . $k, $v['real_name']);
            }
        } else {
            foreach ($data as $k => $v) {
                $k++;
                $objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValue('A' . $k, $v['id'])
                    ->setCellValue('B' . $k, $v['user_type'])
                    ->setCellValue('C' . $k, $v['apply_type'])
                    ->setCellValue('D' . $k, $v['name'])
                    ->setCellValue('E' . $k, $v['mobile'])
                    ->setCellValue('F' . $k, $v['from'])
                    ->setCellValue('G' . $k, $v['profession_id'])
                    ->setCellValue('H' . $k, $v['recommend_job'])
                    ->setCellValue('I' . $k, $v['pay_status'])
                    ->setCellValue('J' . $k, $v['status'])
                    ->setCellValue('K' . $k, $v['pay_end_time'])
                    ->setCellValue('L' . $k, $v['create_time'])
                    ->setCellValue('M' . $k, $v['real_name']);
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
        $rs['0']['id']='(导入数据时,请删除括号及里面内容,并删除第一列空白数据,单次导入最大值1000)';
        $rs['0']['from'] = '客户分类(1=个人,2=企业)';
        $rs['0']['name'] = '客户名称';
        $rs['0']['mobile'] = '手机号';
        $rs['0']['id_card'] = '身份证号';
        $rs['0']['company'] = '单位名称(企业客户必填)';
        $rs['0']['profession_id'] = '工种(工种ID)';
        $rs['0']['recommend_job'] = '推荐就业(1=是,0=否)';
        $rs['0']['status'] = '状态(默认:2=待培训,1=待审核,3=培训中,4=待考试,5=考试中,6=未领证,7=已领证)';
        $rs['0']['real_name'] = '业务员(填写业务员ID)';
        return $rs;
    }

    /**
     * 文件上传的字段逻辑
     * @access public
     * @param file $uploadfile 上传后的文件名
     * @param array $ausess 用户数据
     * @return [array]
     * @since dxf
     */
    static public function uploadFile($uploadfile, $ausess)
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
        for ($row = 1; $row <= $highestRow; $row++) {
            $strs = array();
            //注意highestColumnIndex的列数索引从0开始
            for ($col = 0; $col < $highestColumnIndex; $col++) {
                $strs[$col] = $objWorksheet->getCellByColumnAndRow($col, $row)->getValue();
            }
            //检查表头
            if ($row == 1) {
                if (trim($strs['0']) != '客户分类') {
                    $msg = "表头:" . $strs['0'] . "，与要求表头不匹配，请修改为客户分类";
                    $status = -1;
                    break;
                }
                if (trim($strs['1']) != '客户名称') {
                    $msg = "表头:" . $strs['1'] . "，与要求表头不匹配，请修改为客户名称";
                    $status = -1;
                    break;
                }
                if (trim($strs['2']) != '手机号') {
                    $msg = "表头:" . $strs['2'] . "，与要求表头不匹配，请修改为手机号";
                    $status = -1;
                    break;
                }
                if (trim($strs['3']) != '身份证号') {
                    $msg = "表头:" . $strs['3'] . "，与要求表头不匹配，请修改为身份证号";
                    $status = -1;
                    break;
                }
                if (trim($strs['4']) != '单位名称') {
                    $msg = "表头:" . $strs['4'] . "，与要求表头不匹配，请修改为单位名称";
                    $status = -1;
                    break;
                }
                if (trim($strs['5']) != '工种') {
                    $msg = "表头:" . $strs['5'] . "，与要求表头不匹配，请修改为工种";
                    $status = -1;
                    break;
                }
                if (trim($strs['6']) != '推荐就业') {
                    $msg = "表头:" . $strs['6'] . "，与要求表头不匹配，请修改为推荐就业";
                    $status = -1;
                    break;
                }
                if (trim($strs['7']) != '状态') {
                    $msg = "表头:" . $strs['7'] . "，与要求表头不匹配，请修改为状态";
                    $status = -1;
                    break;
                }
                if (trim($strs['8']) != '业务员') {
                    $msg = "表头:" . $strs['8'] . "，与要求表头不匹配，请修改为业务员";
                    $status = -1;
                    break;
                }
            } elseif ($row > 1001) {
                $msg = '导入失败！单次最大导入量1000条';
                $status = -1;
                break;
            } else {
                $data[$row]['from'] = trim($strs['0']);
                $data[$row]['name'] = trim($strs['1']);
                $data[$row]['mobile'] = trim($strs['2']);
                $data[$row]['id_card'] = trim($strs['3']);
                $data[$row]['company'] = trim($strs['4']);
                $data[$row]['profession_id'] = trim($strs['5']);
                $data[$row]['recommend_job'] = trim($strs['6']);
                $data[$row]['status'] = trim($strs['7']);
                $data[$row]['auid'] = trim($strs['8']);
                if (empty($data[$row]['mobile'])){
                    unset($data[$row]);
                    continue;
                }
                if (!empty($data[$row]['auid'])){
                    $data[$row]['group_id'] = (new AdminUser())->where('id',$data[$row]['auid'])->value('group_id');
                }
                if (empty($data[$row]['status'])){
                    $data[$row]['status'] = 2;
                }
                $fromlist = Db::name('customer_from')->where(['status' => 1])->select();
                if ($fromlist) {
                    $fe = [];
                    foreach ($fromlist as $k => $v) {
                        $fe[$v['id']] = $v['name'];
                    }
                    $ffe = implode(',', $fe);
                    if (!in_array($data[$row]['from'], $fe)) {
                        $msg = '第' . $row . "行数据，客户分类:" . $data[$row]['from'] . "，不正确，正确的类型为：" . $ffe;
                        $status = -1;
                        break;
                    }
                    //反转充值类型
                    $dt = array_flip($fe);
                    $data[$row]['from'] = $dt[$data[$row]['from']];
                }
                if (!is_Mobile($data[$row]['mobile'])) {
                    $msg = '第' . $row . "行数据，手机号码:" . $data[$row]['mobile'] . "，不正确";
                    $status = -1;
                    break;
                }
                $pay_student = PayStudent::get(['mobile' => $data[$row]['mobile']]);
                if (!empty($pay_student)){
                    return ['status' => -1, 'msg' => '此电话号已存在:'.$data[$row]['mobile']];
                }
                $data[$row]['create_time'] = time();
            }
        }
        if ($status == 1) {
            return ['status' => 1, 'msg' => '数据检查成功', 'data' => $data];
        } else {
            return ['status' => -1, 'msg' => $msg];
        }
    }


}
 

