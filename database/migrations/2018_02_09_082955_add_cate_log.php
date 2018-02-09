<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddCateLog extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        DB::table('cate')->insert(['cate_name'=>'吃喝','cover'=>'icon-chifanzhong1','type'=>'1']);
        DB::table('cate')->insert(['cate_name'=>'学习','cover'=>'icon-xuexi','type'=>'1']);
        DB::table('cate')->insert(['cate_name'=>'医疗','cover'=>'icon-yiliao','type'=>'1']);
        DB::table('cate')->insert(['cate_name'=>'交通','cover'=>'icon-jiaotong','type'=>'1']);
        DB::table('cate')->insert(['cate_name'=>'购物','cover'=>'icon-xiazai49','type'=>'1']);
        DB::table('cate')->insert(['cate_name'=>'居家','cover'=>'icon-jujia','type'=>'1']);
        DB::table('cate')->insert(['cate_name'=>'娱乐','cover'=>'icon-yule','type'=>'1']);
        DB::table('cate')->insert(['cate_name'=>'美容','cover'=>'icon-meirong','type'=>'1']);
        DB::table('cate')->insert(['cate_name'=>'通讯','cover'=>'icon-tongxun','type'=>'1']);
        DB::table('cate')->insert(['cate_name'=>'其他','cover'=>'icon-qita','type'=>'0']);
        DB::table('cate')->insert(['cate_name'=>'工资','cover'=>'icon-gongzi','type'=>'2']);
        DB::table('cate')->insert(['cate_name'=>'报销','cover'=>'icon-baoxiao','type'=>'2']);
        DB::table('cate')->insert(['cate_name'=>'兼职','cover'=>'icon-jianzhi','type'=>'2']);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
