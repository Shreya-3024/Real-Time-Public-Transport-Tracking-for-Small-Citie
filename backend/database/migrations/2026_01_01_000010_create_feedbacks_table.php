<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('feedbacks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('trip_id')->nullable()->constrained()->onDelete('cascade');
            $table->foreignId('bus_id')->nullable()->constrained()->onDelete('cascade');
            $table->integer('rating')->unsigned();
            $table->text('comment')->nullable();
            $table->enum('category', ['bus_condition', 'driver_behavior', 'timeliness', 'safety', 'other'])->default('other');
            $table->timestamps();
            $table->index('rating');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('feedbacks');
    }
};
