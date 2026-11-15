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
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->string('reference_code')->unique();
            $table->foreignId('tour_id')->nullable()->constrained()->nullOnDelete();
            $table->string('tour_type')->default('scheduled');
            $table->string('tour_name');
            $table->string('tour_year')->nullable();
            $table->string('currency', 3)->default('gbp');
            $table->string('room_preference')->default('twin_share');
            $table->string('full_name');
            $table->string('email')->index();
            $table->string('phone');
            $table->string('country');
            $table->unsignedTinyInteger('participants_count')->default(1);
            $table->string('birding_experience')->nullable();
            $table->text('dietary_medical')->nullable();
            $table->text('special_notes')->nullable();
            $table->timestamp('terms_accepted_at');
            $table->string('status')->default('pending')->index();
            $table->string('payment_status')->default('unpaid')->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};
