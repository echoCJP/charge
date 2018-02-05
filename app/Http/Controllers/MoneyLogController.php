<?php 

namespace App\Http\Controllers;

use Symfony\Component\HttpFoundation\Response;
use Illuminate\Http\Request;

/**
* 账单记录
*/
class MiniController extends Controller
{

    public function __construct(MoneyLogRepository $moneylog){
        $this->moneylog = $moneylog;
    }
    // 消费/收入
    public function consume(){
        $user_id = $request->user_id;     
        $cate_id = $request->cate_id;     
        $cost = $request->cost;     
        $date = $request->date;   
        $type = $request->type;//consume-消费、income-收入
        $bill_id = $request->bill_id; 
        
        $opera = $this->moneylog->doConsume($user_id,$cate_id,$type,$cost,$date,$bill_id);
        return $opera;
    }

    // 订单列表
    

    
}