<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('scores', function (Blueprint $table) {
            $table->string('technique')->after('code')->nullable();
            $table->string('artistry')->after('code')->nullable();
            $table->string('musicality')->after('code')->nullable();
            $table->string('costume')->after('code')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('scores', function (Blueprint $table) {
            $table->dropColumn(['techinque']);
            $table->dropColumn(['artistry']);
            $table->dropColumn(['musicality']);
            $table->dropColumn(['costume']);
        });
    }
};
