<?php

use App\Enums\EventStatus;
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
        Schema::create(
            'events', function (Blueprint $table) {
                $table->id();
                $table->foreignId('user_id')->constrained()->onDelete('cascade');
                $table->foreignId('category_id')->constrained()->onDelete('cascade');
                $table->string('title');
                $table->text('description');
                $table->string('location');
                $table->dateTime('start_date');
                $table->dateTime('end_date');
                $table->unsignedInteger('max_participants');
                $table->unsignedTinyInteger('status')->default(EventStatus::UPCOMING);
                $table->timestamps();
            }
        );
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('events');
    }
};
