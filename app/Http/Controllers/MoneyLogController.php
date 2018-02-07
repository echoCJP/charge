<?php 

namespace App\Http\Controllers;

use App\Repositories\MoneyLogRepository;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Http\Request;

/**
* 账单记录
*/
class MoneyLogController extends Controller
{

    public function __construct(MoneyLogRepository $moneylog){
        $this->moneylog = $moneylog;
    }
    // 消费/收入
    public function consume(Request $request){
        $user_id = $request->user_id;   
        $cate_id = $request->cate_id;     
        $cost = $request->cost;     
        $date = $request->date;   
        $type = $request->type;//consume-消费、income-收入
        $bill_id = $request->bill_id; //账单ID（edit）
        
        $todo = $this->moneylog->doConsume($user_id,$cate_id,$type,$cost,$date,$bill_id);
        return $todo;
    }

    // 订单列表
    // TODO: 年-月 
    public function lists(Request $request){
        $user_id = $request->user_id;   
        $year = $request->year;   
        $month = $request->month;  

        $todo = $this->moneylog->getLists($user_id,$year,$month);
        return $todo;
    }
    

    // 统计(月)
    public function counts(Request $request){
        $user_id = $request->user_id;   
        $year = $request->year;   
        $month = $request->month;   

        $todo = $this->moneylog->getCounts($user_id,$year,$month);
        return $todo;
    }

    // 设置预算
    public function setting(Request $request){
        $user_id = $request->user_id;   
        $budget = $request->budget; 

        $todo = $this->moneylog->settingBudget($user_id,$budget);
        return $todo;
    }

    
}