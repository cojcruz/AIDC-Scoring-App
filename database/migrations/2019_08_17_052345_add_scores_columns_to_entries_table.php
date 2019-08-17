<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddScoresColumnsToEntriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('entries', function (Blueprint $table) {
            $table->string('judge_c')->after('category')->default(null)->nullable();
            $table->string('judge_b')->after('category')->default(null)->nullable();
            $table->string('judge_a')->after('category')->default(null)->nullable();
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
            $table->dropColumn(['judge_a']);
            $table->dropColumn(['judge_b']);
            $table->dropColumn(['judge_c']);
        });
    }
}
