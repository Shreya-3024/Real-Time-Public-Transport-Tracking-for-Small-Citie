<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('trips', function (Blueprint $table) {
            $table->id();
            $table->foreignId('bus_id')->constrained()->onDelete('cascade');
            $table->foreignId('driver_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('route_id')->constrained()->onDelete('cascade');
            $table->timestamp('started_at');
            $table->timestamp('ended_at')->nullable();
            $table->decimal('distance_covered', 8, 2)->nullable();
            $table->integer('duration')->nullable();
            $table->enum('status', ['ongoing', 'completed', 'cancelled'])->default('ongoing');
            $table->text('notes')->nullable();
            $table->timestamps();
            $table->index('started_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('trips');
    }
};
