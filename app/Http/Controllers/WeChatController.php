<?php 

namespace App\Http\Controllers;

use Log;
/**
* 
*/
class WeChatController extends Controller
{
    
    public function serve(){
        Log::info('request arrived.'); # 注意：Log 为 Laravel 组件，所以它记的日志去 Laravel 日志看，而不是 EasyWeChat 日志

        $app = app('wechat.mini_program');
        $app->server->push(function($message){
            return "欢迎关注 echo！";
        });

        return $app->server->serve();
    }

    // public function wxReceive(){
    //     //获得参数 signature nonce token timestamp echostr
    //     $nonce     = $_GET['nonce']?$_GET['nonce']:'';
    //     $token     = 'fyit';
    //     $timestamp = $_GET['timestamp']?$_GET['timestamp']:'';
    //     $echostr   = $_GET['echostr']?$_GET['echostr']:'';
    //     $signature = $_GET['signature']?$_GET['signature']:'';
    //     //形成数组，然后按字典序排序
    //     $array = array();
    //     $array = array($nonce, $timestamp, $token);
    //     sort($array);
    //     //拼接成字符串,sha1加密 ，然后与signature进行校验
    //     $str = sha1( implode( $array ) );

    //     // https://api.weixin.qq.com/cgi-bin/message/custom/send?access_token=ACCESS_TOKEN
    //     // 小程序的原始ID
    //     // $ToUserName=$_POST('ToUserName');
    //     // 发送者的openid
    //     $FromUserName=$_REQUEST['openid']?$_REQUEST['openid']:'';
    //     // 消息创建时间(整型）   
    //     // $CreateTime  =$_POST('CreateTime');
    //     // event
    //     // $MsgType =$_POST('MsgType');
    //     // 事件类型，user_enter_tempsession
    //     // $Event   =$_POST('Event');
    //     // 开发者在客服会话按钮设置的session-from属性
    //     // $SessionFrom =$_POST('SessionFrom');
    //     // 封面图片的临时cdn链接
    //     // $ThumbUrl=$_POST('ThumbUrl');

    //     // \Think\Log::record('发送者的openid');
    //     // \Think\Log::record($FromUserName);

    //     if($FromUserName){
    //         // \Think\Log::record('由用户');
    //         // $this->sendMsg($ToUserName,$FromUserName,$CreateTime,$MsgType,$Event,$SessionFrom,$ThumbUrl);
    //         // $this->sendMsg($FromUserName);
    //     }


    //     if( $str  == $signature && $echostr ){
    //         //第一次接入weixin api接口的时候
    //         echo  $echostr;
    //         return;
    //     }else{
    //         die;
    //     }

    // }
}