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
        Schema::create('tours', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->unsignedSmallInteger('year');
            $table->string('country')->nullable();
            $table->string('summary')->nullable();
            $table->longText('description')->nullable();
            $table->longText('itinerary')->nullable();
            $table->unsignedSmallInteger('duration_days')->nullable();
            $table->string('date_label')->nullable();
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->unsignedInteger('price_gbp')->nullable();
            $table->unsignedInteger('price_usd')->nullable();
            $table->unsignedInteger('single_supplement_gbp')->nullable();
            $table->unsignedInteger('single_supplement_usd')->nullable();
            $table->string('status')->default('available')->index();
            $table->string('image')->nullable();
            $table->string('external_url')->nullable();
            $table->boolean('is_featured')->default(false)->index();
            $table->boolean('is_published')->default(true)->index();
            $table->unsignedInteger('sort_order')->default(0);
            $table->string('meta_title')->nullable();
            $table->string('meta_description')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->index(['year', 'is_published']);
            $table->index('sort_order');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tours');
    }
};
