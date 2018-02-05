<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddAllTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // 分类表
        Schema::create('cate', function (Blueprint $table) {
            $table->increments('id');

            $table->string('cate_name')->comment('分类名称');
            $table->string('cover')->nullable()->comment('封面/样式');
            $table->tinyInteger('is_enable')->default(1)->comment('0-禁用 1-开启');
            $table->integer('sort')->default(100)->comment('排序，从大到小');
            $table->engine = 'MyISAM';
            $table->timestamps();
        });

        // 记账记录表
        Schema::create('money_log', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('user')->comment('用户ID');
            $table->tinyInteger('type')->default(0)->comment('类型');
            $table->float('cost',10,2)->default(0.00)->comment('金额');
            $table->tinyInteger('cost_type')->default(0)->comment('消费类型：0-负（消费） 1-正（收入）');
            $table->tinyInteger('soft_del')->default(0)->comment('0-未删除 1-已删除');
            $table->char('year',4)->default(0)->comment('年');
            $table->char('month',2)->default(0)->comment('月');   
            $table->index('year');
            $table->index('month'); 
            $table->engine = 'MyISAM';
            $table->timestamps();
        });

        // 设置表
        Schema::create('setting', function (Blueprint $table) {
            $table->increments('id');
            $table->string('key')->comment('key');
            $table->text('value')->comment('value');
            $table->tinyInteger('is_enable')->default(1)->comment('0-禁用 1-开启');
            $table->integer('sort')->default(0)->comment('排序');
            $table->engine = 'MyISAM';
        });

        // 用户表
        Schema::create('user', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('wechat_id')->nullable()->comment('微信用户id');
            $table->string('name')->comment('名称'); 
            $table->text('avatar')->nullable()->comment('头像'); 
            $table->tinyInteger('sex')->nullable()->default(1)->comment('1男2女');
            $table->string('phone')->nullable()->comment('手机号');
            $table->float('budget',10,2)->default(0.00)->comment('设置消费金额');
            $table->timestamps();
        });

        // 微信粉丝表
        Schema::create('wechat_fans', function (Blueprint $table) {
            $table->increments('id');           
            $table->char('openid', 100);
            $table->char('unionid', 100)->nullable();
            $table->tinyInteger('subscribe')->default(0);           //用户是否订阅该公众号，0：未关注，1：已关注
            $table->string('nickname')->nullable();                 //微信昵称
            $table->tinyInteger('sex')->nullable();                 //用户的性别，值为1时是男性，值为2时是女性，值为0时是未知
            $table->char('language', 100)->nullable();             //语言
            $table->string('country', 50)->nullable();               //用户所在国家
            $table->string('province', 50)->nullable();              //用户所在省份
            $table->string('city', 50)->nullable();                  //用户所在城市
            $table->string('avatar', 500)->nullable();           //用户头像
            $table->dateTime('subscribe_at');                       //用户关注时间    
            $table->integer('subscribe_num')->default(0);           //关注次数  
            $table->integer('groupid')->nullable();                 //用户组           
            $table->string('remark')->nullable();                 //用户描述          
            $table->timestamps();
        });





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
