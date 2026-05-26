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
            $table->foreignId('fonction_id')->nullable()->constrained('fonctions')->onDelete('set null');
            $table->foreignId('bu_id')->nullable()->constrained('business_units')->onDelete('set null');
            $table->foreignId('nature_id')->nullable()->constrained('natures')->onDelete('set null');
            $table->foreignId('post_id')->nullable()->constrained('posts')->onDelete('set null');
            $table->decimal('daily_rate', 10, 2)->default(0);
            $table->boolean('status')->default(true);
            $table->timestamps();
            $table->softDeletes();
            
            // Indexes for performance
            $table->index(['bu_id', 'fonction_id']);
            $table->index(['nature_id', 'status']);
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
