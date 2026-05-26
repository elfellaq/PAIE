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
        Schema::create('attendance_records', function (Blueprint $table) {
            $table->id();
            $table->foreignId('employee_id')->constrained()->onDelete('cascade');
            $table->foreignId('payroll_period_id')->constrained()->onDelete('cascade');
            $table->date('date');
            $table->enum('shift_type', ['J', 'N'])->default('J'); // J = Jour, N = Nuit
            $table->time('hours_in')->nullable();
            $table->time('hours_out')->nullable();
            $table->decimal('days_worked', 5, 2)->default(0); // Fractional days
            $table->decimal('amount', 10, 2)->default(0); // Calculated amount for this record
            $table->enum('status', ['pending', 'verified', 'approved', 'rejected'])->default('pending');
            $table->foreignId('verified_by')->nullable()->constrained('users')->onDelete('set null');
            $table->foreignId('approved_by')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamp('approved_at')->nullable();
            $table->text('comment')->nullable();
            $table->timestamps();
            
            // Indexes for performance
            $table->index(['employee_id', 'payroll_period_id']);
            $table->index(['date', 'shift_type']);
            $table->index(['status', 'payroll_period_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('attendance_records');
    }
};
