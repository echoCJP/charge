<?php 

namespace App\Http\Controllers;
use Illuminate\Http\Request; 
use App\Repositories\InitRepository;

/**
* 
*/
class TestController extends Controller
{

    public function __construct(InitRepository $init) {
        $this->init = $init;
    }
    

    public function index(Request $request){
        var_dump(config("cache.expired"));
        return $this->init->success('hehe');
    }
}