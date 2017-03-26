<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLinksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     * 开始创建表
     */
    public function up()
    {
        Schema::create('links', function (Blueprint $table) {
            $table->engine='MyISAM'; //设置数据库引擎
            $table->increments('link_id'); //主键
            //string 代表varchar default 代表默认 comment是注释
            $table->string('link_name')->default('')->comment('//名称');
            $table->string('link_title')->default('')->comment('//标题');
            $table->string('link_url')->default('')->comment('//链接');
            $table->integer('link_order')->default(0)->comment('//排序'); //interger 代表 int
        });
    }

    /**
     * Reverse the migrations.
     *结束
     * @return void
     */
    public function down()
    {
        //删除
        Schema::drop('links');
    }
}
