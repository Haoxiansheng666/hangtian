<?php
namespace app\backend\logic;
use app\backend\model\CompanyCustomerBatch;
use app\backend\model\Customer;
use app\backend\model\PayStudent;
use app\backend\model\Profession;
use Exception;
use think\Db;
use think\Request;
class InvoiceLogic
{
    /**
     * 客户查询的逻辑
     * @access public
     * @param array $param 条件数据
     * @param array|void|mixed $ausess 账号的session信息
     * @return array
     */
    public static function selectParam($param,$ausess){
        $where=[];

        //添加人
        if(isset($param['auid']) && !empty($param['auid'])){
            $customer_ids = (new Customer())
                ->where('auid',$param['auid'])
                ->column('id');
            $where['customer_id']=['in',$customer_ids];
        }
        // 客户ID
        if (!empty($param['company_name'])){
            $where['customer_id'] = $param['company_name'];
        }
        // 支付状态
        if (!empty($param['pay_status'])){
            $where['pay_status'] = $param['pay_status'];
        }
        return $where;
    }

    /**
     * 获取个人客户的财务统计查询条件
     * @param $param
     * @param $ausess
     * @return array
     */
    public static function selectGrParam($param,$ausess){
        $where = [];
        //客户名称
        if (isset($param['name']) && !empty($param['name'])) {
            $where['name'] = array('like', "%".$param['name']."%");
        }
        //手机号
        if (isset($param['mobile']) && !empty($param['mobile'])) {
            $where['mobile'] = array('like', "%".$param['mobile']."%");
        }
        //添加人
        if (isset($param['auid']) && !empty($param['auid'])) {
            $where['auid'] = $param['auid'];
        }
        //学员状态
        if (!empty($param['status'])) {
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
     * 财务审核查询条件
     * @param $param
     * @param $ausess
     * @return array
     */
    public static function selectAuditParam($param,$ausess){
        $where=[];
        //客户名称
        if(isset($param['name']) && !empty($param['name'])){
            $customer_where['name']=array('like',"%$param[name]%");
        }
        //手机号
        if(isset($param['mobile']) && !empty($param['mobile'])){
            $customer_where['mobile']=array('like',"%$param[mobile]%");
        }
        //来源
        if(isset($param['from']) && !empty($param['from'])){
            $customer_where['from']=$param['from'];
        }
        //添加人
        if(isset($param['auid']) && !empty($param['auid'])){
            $customer_where['auid']=$param['auid'];
        }

//        // 企业用户与个人用户区别查询
//        if (!empty($customer_where)){
//            if (!empty($company_customer)){
//                $batch_number = (new CompanyCustomerBatch())
//                    ->where([
//                        'customer_id' => ['in',$company_customer]
//                    ])
//                    ->column('batch_number');
//                $where['batch_number'] = ['in',$batch_number];
//            }else{
//                $customer = (new Customer())
//                    ->where($customer_where)
//                    ->column('id');
//                $pay_student_ids = (new PayStudent())
//                    ->where("customer_id",'in',$customer)
//                    ->column('id');
//                $where['pay_student_id'] = ['in',$pay_student_ids];
//            }
//        }
        // 创建时间
        if(isset($param['action_time']) && !empty($param['action_time'])){
            $where['create_time'] = ['>=' , strtotime($param['action_time'])];
        }
        // 创建时间截止查询时间
        if(isset($param['end_time']) && !empty($param['end_time'])){
            if (!empty($where['create_time'])){
                $where['create_time'] = ['between' , [strtotime($param['action_time']),strtotime($param['end_time'])]];
            }else{
                $where['create_time'] = ['<=' , strtotime($param['end_time'])];
            }

        }
        // if (isset($param['status']) && $param['status'] !== ''){
        if (isset($param['status'])){
            $where['status'] = $param['status'];
        }
        return $where;
    }

    /**
     * 客户数据下载的逻辑
     * @access public
     * @param array $data 要下载的数据
     * @param array|string|void|mixed $name excel表名称
     * @param int $ware_id 客户、个人财务统计判断
     * @return void
     * @throws Exception
     */
    static public function down($data,$name,$ware_id){
        vendor('PHPExcel.PHPExcel');
        $objPHPExcel = new \PHPExcel();
        $objPHPExcel->getActiveSheet()->getStyle('A:N')->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER); 
        //遍历数组，注意数组对应的下标
        if($name=='客户信息导入模板'){
            foreach($data as $k => $v){
                $k=1;
                $objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValue('A'.$k, $v['id'])
                    ->setCellValue('B'.$k, $v['from_name'])
                    ->setCellValue('C'.$k, $v['cate_name'])
                    ->setCellValue('D'.$k, $v['name'])
                    ->setCellValue('E'.$k, $v['mobile'])
                    ->setCellValue('F'.$k, $v['address'])
                    ->setCellValue('G'.$k, $v['create_time'])
                    ->setCellValue('H'.$k, $v['real_name']);
            }
        }else{
            if ($ware_id == 1){
                foreach($data as $k => $v){
                    $k++;
                    $objPHPExcel->setActiveSheetIndex(0)
                        ->setCellValue('A'.$k, $v['id'])
                        ->setCellValue('B'.$k, $v['batch_number'])
                        ->setCellValue('C'.$k, $v['company_name'])
                        ->setCellValue('D'.$k, $v['name'])
                        ->setCellValue('E'.$k, $v['mobile'])
                        ->setCellValue('F'.$k, $v['total_price'])
                        ->setCellValue('G'.$k, $v['pay_price'])
                        ->setCellValue('H'.$k, $v['surplus_price'])
                        ->setCellValue('I'.$k, $v['admin'])
                        ->setCellValue('J'.$k, $v['pay_status'])
                        ->setCellValue('K'.$k, $v['apply_num'])
                        ->setCellValue('L'.$k, $v['create_time']);
                }
            }else{
                foreach($data as $k => $v){
                    $k++;
                    $objPHPExcel->setActiveSheetIndex(0)
                        ->setCellValue('A'.$k, $v['id'])
                        ->setCellValue('B'.$k, $v['name'])
                        ->setCellValue('C'.$k, $v['mobile'])
                        ->setCellValue('D'.$k, $v['total_price'])
                        ->setCellValue('E'.$k, $v['pay_price'])
                        ->setCellValue('F'.$k, $v['surplus_price'])
                        ->setCellValue('G'.$k, $v['profession'])
                        ->setCellValue('H'.$k, $v['admin'])
                        ->setCellValue('I'.$k, $v['status'])
                        ->setCellValue('J'.$k, $v['create_time']);
                }
            }

        }
        
        ob_end_clean();
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="'.$name.'.xls"');
        header('Cache-Control: max-age=0');
        $objWriter = \PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        $objWriter->save('php://output');
        exit;
    }
}
 

