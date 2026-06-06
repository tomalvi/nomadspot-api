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
        Schema::create('cities', function (Blueprint $table) {
            $table->id();         
            $table->string('name');
            $table->boolean('is_capital')->default(0);
            $table->foreignId('country_id')->constrained('countries');
            $table->foreignId('weather_id')->constrained('weather')->nullable();
            $table->integer('population');
            $table->decimal('latitude', 10, 7);
            $table->decimal('longitude', 10, 7);
            $table->float('cost_per_month')->nullable();
            $table->float('average_salary_per_month')->nullable();
            $table->float('median_salary_per_month')->nullable();
            $table->float('internet_speed')->nullable();
            $table->string('timezone')->nullable();
            $table->boolean('visa_friendly')->nullable();
            $table->string('images')->nullable();
            $table->float('score_overall')->default(0);
            $table->float('score_climate')->default(0);
            $table->float('score_cost')->default(0);
            $table->string('safety_score')->nullable();
            $table->integer('avg_rent_usd')->nullable();
            $table->float('avg_temp_c')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cities');
    }
};
