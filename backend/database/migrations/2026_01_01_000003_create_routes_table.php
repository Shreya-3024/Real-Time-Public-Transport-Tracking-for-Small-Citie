<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('routes', function (Blueprint $table) {
            $table->id();
            $table->string('route_number')->unique();
            $table->string('name');
            $table->string('start_point');
            $table->string('end_point');
            $table->decimal('distance', 8, 2);
            $table->integer('estimated_duration');
            $table->string('color')->default('#3B82F6');
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('routes');
    }
};
