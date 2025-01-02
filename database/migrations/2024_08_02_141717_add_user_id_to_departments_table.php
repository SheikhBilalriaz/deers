<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddUserIdToDepartmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('departsments', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id')->nullable()->after('status'); // Add user_id column after status
            $table->foreign('user_id')->references('id')->on('users')->onDelete('set null'); // Optional: Add foreign key constraint
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('departsments', function (Blueprint $table) {
            $table->dropForeign(['user_id']); // Drop foreign key constraint
            $table->dropColumn('user_id'); // Drop user_id column
        });
    }
}
