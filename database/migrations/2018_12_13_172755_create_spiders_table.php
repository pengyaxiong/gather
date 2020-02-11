<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSpidersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('spiders', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 100)->comment('网站名称');
            $table->string('url', 100)->comment('网站地址');
            $table->text('description')->comment('网站描述');
            $table->tinyInteger('state')->default(1);
            $table->timestamp('deleted_at')->nullable();
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
        Schema::dropIfExists('spiders');
    }
}
