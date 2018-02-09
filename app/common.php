<?php
/** 
 * 格式化金额 
 * 
 * @param int $money 
 * @param int $len 
 * @param string $sign 
 * @return string 
 */  
function format_money($money, $len=2, $sign=''){  //$sign='￥'
    $negative = $money > 0 ? '' : '-';  
    $int_money = intval(abs($money));  
    $len = intval(abs($len));  
    $decimal = '';//小数  
    if ($len > 0) {  
        $decimal = '.'.substr(sprintf('%01.'.$len.'f', $money),-$len);  
    }  
    $tmp_money = strrev($int_money);  
    $strlen = strlen($tmp_money);  
    $format_money = "";
    for ($i = 3; $i < $strlen; $i += 3) {  
        $format_money .= substr($tmp_money,0,3).',';  
        $tmp_money = substr($tmp_money,3);  
    }  
    $format_money .= $tmp_money;  
    $format_money = strrev($format_money);  
    return $sign.$negative.$format_money.$decimal;  
}  
