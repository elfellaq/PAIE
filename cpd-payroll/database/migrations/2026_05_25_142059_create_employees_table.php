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
        Schema::create('employees', function (Blueprint $table) {
            $table->id();
            $table->string('matricule')->unique();
            $table->string('full_name');
            $table->string('cin_passport')->nullable();
            $table->enum('gender', ['M', 'F'])->nullable();
            $table->foreignId('fonction_id')->constrained()->onDelete('set null');
            $table->foreignId('business_unit_id')->constrained()->onDelete('set null');
            $table->foreignId('nature_id')->constrained()->onDelete('set null');
            $table->foreignId('post_id')->nullable()->constrained()->onDelete('set null');
            $table->decimal('daily_rate', 10, 2)->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            $table->softDeletes();
            
            // Indexes for performance
            $table->index(['business_unit_id', 'fonction_id']);
            $table->index(['nature_id', 'is_active']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employees');
    }
};
