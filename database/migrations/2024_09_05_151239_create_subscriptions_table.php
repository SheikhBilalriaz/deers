<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSubscriptionsTable extends Migration
{
    public function up()
    {
        Schema::create('subscriptions', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->decimal('price', 8, 2)->default(0);
            $table->boolean('can_look_at_records')->default(false);
            $table->boolean('can_book_appointments')->default(false);
            $table->boolean('can_store_documents')->default(false);
            $table->boolean('can_make_appointments')->default(false);
            $table->boolean('can_upload_documents')->default(false);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('subscriptions');
    }
}
