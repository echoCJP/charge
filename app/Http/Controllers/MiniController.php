<?php 

namespace App\Http\Controllers;

use App\Repositories\WechatFansRepository;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Cache;
use Illuminate\Http\Request;
use EasyWeChat;

/**
* 
*/
class MiniController extends Controller
{
    
    public function __construct(WechatFansRepository $wechatFans)
    {
        $this->wechatFans = $wechatFans;
    }

    // 同步用户session 
    public function getSession(Request $request)
    {
        $mini = EasyWeChat::miniProgram();
        $session = $mini->auth->session($request->code);
        $token = substr(sha1(rand(1,9999999)), 0,16);
        Cache::put($token,$session,config('cache.expired.auth'));
        return ['token'=>$token];
    }

    // 同步用户数据
    public function syncUser(Request $request)
    {
        // $token = $request -> header('token');
        $token = $request->header('token');
        // return response(['msg'=>$token]);
        // if(Cache::has($token)){
        //     $cache = Cache::get($token);
        //     $wechatFans = $this->wechatFans->syncFans($cache['openid'],(object)$request->userInfo);
        //     $cache['userInfo'] = $wechatFans;
            
        //     Cache::put($token, $cache, config('cache.expired.auth'));
        //     return [
        //         'message' => 'ok',
        //         'userinfo' => $wechatFans
        //     ];
        // }

        if (Cache::has($token)) {
            $cache = Cache::get($token);
            $wechatFans = $this->wechatFans->syncFans($cache['openid'],(object)$request->userInfo);
            $cache['userInfo'] = $wechatFans;
            Cache::put($token, $cache, config('cache.expired.auth'));
            return [
                'message' => 'ok',
                'userinfo' => $wechatFans
            ];
        }


        return response(['message' => 'token异常'], Response::HTTP_UNAUTHORIZED);


    }
}