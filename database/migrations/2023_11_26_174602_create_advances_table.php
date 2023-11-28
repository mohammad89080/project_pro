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
        Schema::create('advances', function (Blueprint $table) {
            $table->id();
<<<<<<< HEAD
            $table->decimal('amount', 10, 2);
=======
            $table->foreignId('user_id')->constrained();
            $table->decimal('amount');
            $table->string('status')->default('Pending');
            $table->text('notes')->nullable();
>>>>>>> 3a33d1ce67e3b4b0b3a0513ff1a0b9d9de3261c4
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('advances');
    }
};
