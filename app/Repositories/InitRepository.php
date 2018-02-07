<?php 

namespace App\Repositories;

use Illuminate\Http\Exceptions\HttpResponseException;
use Symfony\Component\HttpFoundation\Response;

/**
* 
*/
class InitRepository// implements HouseRepositoryInterface
{
    /**
     * 合法请求
     */
    public function successRequest($data,$msg="success",$code='200'){
        return [
            'data'=>$data,
            'message'=>$msg,
            'code'=>$code
        ];       
    } 

    /**
     * 不合法请求
     */
    public function badRequest($message)
    {
        throw new HttpResponseException(response()->json([
            'message' => $message
        ], Response::HTTP_BAD_REQUEST));
    }

    /**
     * 服务器错误
     */
    public function serverError($message)
    {
        throw new HttpResponseException(response()->json([
            'message' => $message
        ], Response::HTTP_INTERNAL_SERVER_ERROR));
    }


}