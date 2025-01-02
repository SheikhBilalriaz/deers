<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAnnouncementsTable extends Migration
{
    public function up()
    {
        Schema::create('announcements', function (Blueprint $table) {
            $table->id();
            $table->text('content');
            $table->string('doc')->nullable(); // Optional document attachment
            $table->string('image')->nullable(); // Optional image attachment
            $table->string('is_all_department')->nullable(); // Optional image attachment
            $table->foreignId('department_id')->constrained()->onDelete('cascade')->nullable(); // Foreign key for department
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('announcements');
    }
}

