<?php 

namespace App\Repositories;

use App\Models\MoneyLog;
use App\Models\User;


use Illuminate\Support\Facades\DB;

// use Symfony\Component\HttpFoundation\Response;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Exceptions\HttpResponseException;

class MoneyLogRepository extends InitRepository
{

    // test123456
    public function doConsume($user_id,$cate_id,$type,$cost,$date,$bill_id,$remark)
    {
        //$type consume-消费、income-收入123
        $cost_type = 0;
        if($type == "income"){
            $cost_type = 1;
        }

        // 
        if(!($cate_id>0)){
            $cate_id = 0;
        }

        // date为
        $year = date('Y',$date);
        $month = date('m',$date);
        $day = date('d',$date);
        $week = date('w',$date);

        if(!$date){
            $this -> badRequest('时间无效');
        }

        if(!($cost>0)){
            $this -> badRequest('请输入金额');
        }

        $data = [
            'user_id'=>$user_id,
            'type'=>$cate_id,
            'cost'=>$cost,
            'cost_type'=>$cost_type,
            'year'=>$year,
            'remark'=>$remark?$remark:'',
            'month'=>$month,
            'day'=>$day,
            'week'=>$week    
        ];

        // 修改
        if($bill_id > 0){
            $data['updated_at'] =date('Y-m-d H:i:s',time($data));
            $res = MoneyLog::where('id',$bill_id) -> update($data);
        }else{
            // 新增
            $data['created_at'] =date('Y-m-d H:i:s',time());
            $res = MoneyLog::insert($data);
        }       

        if($res){
            return $this -> successRequest('操作成功');
        }
            
        $this -> serverError('操作失败');
    }

    public function getLists($user_id,$year,$month)
    {
        // 验证
        if(!($user_id>0)){
            $this -> serverError('用户出错');
        }

        
        if(!($month>0)||!($year>0)){
            // $this -> serverError('时间无效');
            $year = date('Y',time());
            $month = date('m',time());
        }


        $where = [
            ['user_id',$user_id],
            ['soft_del',0],
            ['year',$year],
            ['month',$month]
        ];
       
        // every_day
        $all_day = MoneyLog::select(['day','week','month','year'])
            ->orderBy('day','DESC')
            ->where($where) 
            ->groupBy('day')
            ->get();
      
        $data = [];
        foreach ($all_day as $k => $v) {
            $field = ['money_log.id','money_log.cost','money_log.type','money_log.remark','cate.cate_name','cate.cover'];
            $cost_where = $where;
            $cost_where['type'] = 0;
            $cost_where['day'] = $v->day;

            $data[$k]['year'] = $v->year;
            $data[$k]['month'] = $v->month;
            $data[$k]['day'] = $v->day;
            $data[$k]['week'] = $v->week;

            // 消费
            $data[$k]['day_cost_sum'] = MoneyLog::where($cost_where)->sum('cost');
            
            // 收入
            $income_where = $cost_where;
            $income_where['type'] = 1;
            $data[$k]['day_imcome_sum'] = MoneyLog::where($income_where)->sum('cost');
            // 消费|收入
            $where_list = $where;
            $where_list['day'] = $v->day;
            $list = MoneyLog::where($where_list) 
                ->leftJoin('cate', 'cate.id', '=', 'money_log.cost_type')
                ->orderBy('money_log.created_at','desc') 
                ->select($field) 
                ->get();
            $data[$k]['list'] = $list;
        }
        if($data){
            return $data;
        }
        $this->badRequest('数据为空');
    }

    public function getCounts($user_id,$year,$month)
    {
        // 验证
        if(!($user_id>0)){
            $this -> serverError('用户出错');
        }

       
        if(!($month>0)||!($year>0)){
            // $this -> serverError('时间无效');
            $year = date('Y',time());
            $month = date('m',time());
        }

        // 用户预计目标
        $budget_res = User::where('id',$user_id)->select('budget')->first();
        if($budget_res){
            $budget = $budget_res['budget'];
        }else{
            $budget = 0;
        }

        // 统计已消费
        $where = [
            'user_id'=>$user_id,
            'year'=>$year,
            'month'=>$month
        ];
        

        $cost_where = $where;
        $cost_where['cost_type'] = 0;
        $cost_sum = MoneyLog::where($cost_where)->sum('cost');

        // 剩余
        $residue_sum = $budget - $cost_sum;
        // 收入总额
        $income_where = $where;
        $income_where['cost_type'] = 1;
        $income_sum = MoneyLog::where($income_where)->sum('cost');

        $data = [
            'budget' =>format_money($budget),
            'cost_sum'=>format_money($cost_sum),
            'residue_sum'=>format_money($residue_sum),
            'income_sum'=>format_money($income_sum),
            'year'=>$year,
            'month'=>$month
        ];


        return $data;
    }

    public function settingBudget($user_id,$budget)
    {
        // 验证
        if(!($user_id>0)){
            $this -> serverError('用户出错');
        }

        if(!($budget>0)){
            $this -> badRequest('请输入合理预算');
        }

        $res = User::where('id',$user_id)
          ->update(['budget' => $budget]);

        if($res){
            return $this->successRequest('操作成功');
        }

        $this->badRequest('操作失败');
    }

    public function cateList($type){
        if($type == "income"){
            // 收入图标
            $where['type'] = ['IN','0,1'];
        }else{
            $where['type'] = ['IN','0,2'];
        }

        $data = DB::table('cate') -> where($where)->get();
        return $data;
    }


}