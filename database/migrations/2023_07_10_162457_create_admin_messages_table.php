<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('admin_messages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('message_id')->constrained('messages')->cascadeOnDelete();
            $table->foreignId('sender_id')->constrained('admins')->cascadeOnDelete();
            $table->foreignId('receiver_id')->constrained('admins')->cascadeOnDelete();
            $table->tinyInteger('type')->default(0)->comment('0:personal 1:group');
            $table->tinyInteger('seen_status')->default(0)->comment('0:unseen 1:seen');
            $table->tinyInteger('delivered_status')->default(0)->comment('0:undelivered 1:delivered');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('admin_messages');
    }
};
