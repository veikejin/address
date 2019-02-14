<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAddressTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */

    protected $table= 'address';

    public function up()
    {
        Schema::create($this->table, function (Blueprint $table) {
                $table->increments('id');
                $table->morphs('haveaddress');
                $table->string('name')->comment('姓名');
                $table->string('mobile')->comment('手机号');
                $table->integer('area_id')->comment('地区ID');
                $table->string('detail')->comment('详细地址');
                $table->tinyInteger('is_default')->default(0)->comment('是否是默认地址');
                $table->string('label')->nullable()->comment('地址标签，可以用来表示，家，公司等');
                $table->string('postal_code')->nullable()->comment('邮编');
                $table->float('lat')->nullable()->comment('经度');
                $table->float('lng')->nullable()->comment('纬度');
                $table->json('other')->nullable()->comment('其他地址信息');
                $table->timestamps();
            }
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists($this->table);
    }
}
