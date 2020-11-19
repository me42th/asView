<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAsnTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('asn', function (Blueprint $table) {
            $table->id();
            $table->string('out_id', 100)->nullable();
            $table->string('out_org_id', 100)->nullable();
            $table->string('out_name', 100)->nullable();
            $table->string('out_asn', 100)->nullable();
            $table->string('out_policy_general', 100)->nullable();
            $table->timestampTz('out_create', 0)->nullable();
            $table->timestampTz('out_update', 0)->nullable();
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
        Schema::dropIfExists('asn');
    }
}
