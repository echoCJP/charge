<?php

namespace App\Http\Middleware;

use Closure;

use App\Models\WechatFans;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Cache;

class CheckUser
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        // return $next($request);
        $message = 'token不存在';
        if($request->hasHeader('token')){
            if(Cache::has($token)){
                $cache = Cache::get($token);
                if(!isset($cache['userInfo'])){
                    $cache['userInfo']=WechatFans::where('openid',$cache['openid'])->first();
                }
            }

            debug($cache);
            $user = $cache['userInfo'];
            if (isset($cache['userInfo'])) {
                $request->attributes->add(compact('user'));
                return $next($request);
            }
            
            $message = '用户数据丢失';

        }
        return response(['message' => $message], Response::HTTP_UNAUTHORIZED);
    }
}
