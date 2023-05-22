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
        Schema::table('entries', function (Blueprint $table) {
            $table->string('jA-catD')->after('judge_a')->nullable();
            $table->string('jA-catC')->after('judge_a')->nullable();
            $table->string('jA-catB')->after('judge_a')->nullable();
            $table->string('jA-catA')->after('judge_a')->nullable();
            $table->string('jB-catD')->after('judge_b')->nullable();
            $table->string('jB-catC')->after('judge_b')->nullable();
            $table->string('jB-catB')->after('judge_b')->nullable();
            $table->string('jB-catA')->after('judge_b')->nullable();
            $table->string('jC-catD')->after('judge_c')->nullable();
            $table->string('jC-catC')->after('judge_c')->nullable();
            $table->string('jC-catB')->after('judge_c')->nullable();
            $table->string('jC-catA')->after('judge_c')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('entries', function (Blueprint $table) {
            $table->dropColumn(['jA-catA']);
            $table->dropColumn(['jA-catB']);
            $table->dropColumn(['jA-catC']);
            $table->dropColumn(['jA-catD']);
            $table->dropColumn(['jB-catA']);
            $table->dropColumn(['jB-catB']);
            $table->dropColumn(['jB-catC']);
            $table->dropColumn(['jB-catD']);
            $table->dropColumn(['jC-catA']);
            $table->dropColumn(['jC-catB']);
            $table->dropColumn(['jC-catC']);
            $table->dropColumn(['jC-catD']);
        });
    }
};
