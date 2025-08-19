<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('push_notification_histories', function (Blueprint $table) {
            $table->increments('id')->index()->comment('AUTO_INCREMENT');
            $table->string('title', 500)->comment('Title of Push Notification');
            $table->longText('body')->nullable()->comment('Body of Push Notification');
            $table->string('image', 500)->nullable()->comment('Image path and filename');
            $table->char('is_read', 1)->nullable()->index()->comment('R = Read, U = Unread');
            $table->string('button_name', 20)->nullable()->comment('Button name which visible on Push Notification');
            $table->string('button_link', 500)->nullable()->comment('Button dynamic redirect url');
            $table->timestamps();
            $table->softDeletes();
            $table->unsignedInteger('created_by')->nullable();
            $table->unsignedInteger('updated_by')->nullable();
            $table->unsignedInteger('deleted_by')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('push_notification_histories');
    }
};
