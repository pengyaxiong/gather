<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateConfigsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('configs', function (Blueprint $table) {
            $table->increments('id')->autoIncrement();
            $table->string('title', 100)->comment('网站名称');
            $table->string('keyword', 100)->comment('关键词');
            $table->text('description')->comment('网站描述');
            $table->string('icp', 100)->comment('icp备案号');
            $table->string('copyright', 100)->comment('版权信息');
            $table->string('author', 100)->comment('管理员');
            $table->string('company', 100)->comment('公司名');
            $table->string('qq',100)->comment('联系QQ');
            $table->string('email',100)->comment('联系邮箱');
            $table->string('mobile',100)->nullable()->comment('联系手机');
            $table->string('telephone',100)->nullable()->comment('联系座机');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('configs');
    }
}
