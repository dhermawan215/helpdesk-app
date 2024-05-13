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
        Schema::create('help_desk_tickets', function (Blueprint $table) {
            $table->id();
            $table->string('ticket_id')->unique();
            $table->bigInteger('user_request_id')->nullable();
            $table->bigInteger('category_id')->nullable();
            $table->bigInteger('sub_category_id')->nullable();
            $table->string('subject')->nullable();
            $table->text('description')->nullable();
            $table->dateTime('ticket_date')->nullable();
            $table->bigInteger('assign_to')->nullable();
            $table->enum('status', ['open', 'on progress', 'finished', 'declined'])->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('help_desk_tickets');
    }
};
