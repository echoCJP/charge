<?php 

namespace App\Repositories;


use App\Models\WechatFans;
use App\Models\User;


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
        $fans->avatar = $data->avatarUrl;
        $fans->nickname = $data->nickName;
        $fans->country = $data->country;
        $fans->language = $data->language;
        $fans->province = $data->province;
        $fans->city = $data->city;
        $fans->save();

        $user = User::where('wechat_id',$fans->id)->first();
        if(!$user){
            // 更新用户
            $user = new User();
            $user->wechat_id = $fans->id;
            $user->name = $data->nickName;
            $user->avatar = $data->avatarUrl;
            $user->sex = $data->gender;
            $user->budget = 0;
            $user->save();
        }


        
        return $fans;
    }
}