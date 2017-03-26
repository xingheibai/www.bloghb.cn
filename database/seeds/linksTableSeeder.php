<?php

use Illuminate\Database\Seeder;

class linksTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data=[
            [
              'link_name' => '百度搜索',
              'link_title' => '百度一下,你就知道',
              'link_url' => 'http://www.baidu.com',
              'link_order'=>1,
            ],
            [
                'link_name' => '新浪网',
                'link_title' => '新浪网为全球用户24小时提供全面及时的中文资讯',
                'link_url' => 'http://www.sina.com',
                'link_order'=>2,
            ]
        ];
        //
        DB::table('links')->insert($data);

    }
}
