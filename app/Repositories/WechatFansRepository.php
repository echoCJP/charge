<?php 

namespace App\Repositories;


use App\Models\WechatFans;


/**
* 
*/
class WechatFansRepository
{
    
    // 同步微信粉丝数据
    public function syncFans($openid,$data)
    {
        $fans = WechatFans::where('openid',$openid)->first();
        if(!$fans){
            $fans = new WechatFans();
            $fans -> openid = $openid;
            $fans -> subscribe_at = date('Y-m-d H:i:s');
        }

        $fans->sex = $data->gender;
        $fans->headimgurl = $data->avatarUrl;
        $fans->nickname = $data->nickName;
        $fans->country = $data->country;
        $fans->language = $data->language;
        $fans->province = $data->province;
        $fans->city = $data->city;
        $fans->save();
        
        return $fans;
    }
}