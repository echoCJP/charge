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

    public function doConsume($user_id,$cate_id,$type,$cost,$date,$bill_id)
    {
        //$type consume-消费、income-收入
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
            $this -> serverError('时间无效');
        }


        $where = [
            ['user_id',$user_id],
            ['soft_del',0],
            ['year',$year],
            ['month',$month]
        ];
       
        // $data = MoneyLog::where($where) -> groupBy('day') -> get();
        $data = DB::table('money_log')
            ->where($where) 
            ->orderBy('day', 'desc')
            ->groupBy('day') 
            ->having('day', '>', 0)
            ->get();

        return $data;
        // Order By, Group By, 和 Having
        // $users = DB::table('users')
        //       ->orderBy('name', 'desc')
        //       ->groupBy('count')
        //       ->having('count', '>', 100)
        //       ->get();


    }

    public function getCounts($user_id,$year,$month)
    {
        // 验证
        if(!($user_id>0)){
            $this -> serverError('用户出错');
        }

       
        if(!($month>0)||!($year>0)){
            $this -> serverError('时间无效');
        }

        // 用户预计目标
        $budget = User::where('id',$user_id)->pluck('budget');
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
        $residue_sum = $budget[0] - $cost_sum;
        // 收入总额
        $income_where = $where;
        $income_where['cost_type'] = 1;
        $income_sum = MoneyLog::where($income_where)->sum('cost');

        $data = [
            'budget' =>$budget[0],
            'cost_sum'=>$cost_sum,
            'residue_sum'=>$residue_sum,
            'income_sum'=>$income_sum
        ];

        return $data;
    }
}