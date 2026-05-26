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
        Schema::create('payroll_entries', function (Blueprint $table) {
            $table->id();
            $table->foreignId('employee_id')->constrained()->onDelete('cascade');
            $table->foreignId('payroll_period_id')->constrained()->onDelete('cascade');
            $table->decimal('total_jours', 8, 2)->default(0); // Total days worked in period
            $table->decimal('montant_brut', 12, 2)->default(0); // Gross salary for period
            $table->enum('status', ['draft', 'verified', 'approved', 'locked'])->default('draft');
            $table->timestamps();
            
            $table->unique(['employee_id', 'payroll_period_id']);
            $table->index(['payroll_period_id', 'status']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payroll_entries');
    }
};
