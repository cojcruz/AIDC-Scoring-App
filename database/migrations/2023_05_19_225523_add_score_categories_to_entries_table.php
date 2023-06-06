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
            $table->string('jAcatD')->after('judge_a')->nullable();
            $table->string('jAcatC')->after('judge_a')->nullable();
            $table->string('jAcatB')->after('judge_a')->nullable();
            $table->string('jAcatA')->after('judge_a')->nullable();
            $table->string('jBcatD')->after('judge_b')->nullable();
            $table->string('jBcatC')->after('judge_b')->nullable();
            $table->string('jBcatB')->after('judge_b')->nullable();
            $table->string('jBcatA')->after('judge_b')->nullable();
            $table->string('jCcatD')->after('judge_c')->nullable();
            $table->string('jCcatC')->after('judge_c')->nullable();
            $table->string('jCcatB')->after('judge_c')->nullable();
            $table->string('jCcatA')->after('judge_c')->nullable();
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
            $table->dropColumn(['jAcatA']);
            $table->dropColumn(['jAcatB']);
            $table->dropColumn(['jAcatC']);
            $table->dropColumn(['jAcatD']);
            $table->dropColumn(['jBcatA']);
            $table->dropColumn(['jBcatB']);
            $table->dropColumn(['jBcatC']);
            $table->dropColumn(['jBcatD']);
            $table->dropColumn(['jCcatA']);
            $table->dropColumn(['jCcatB']);
            $table->dropColumn(['jCcatC']);
            $table->dropColumn(['jCcatD']);
        });
    }
};
