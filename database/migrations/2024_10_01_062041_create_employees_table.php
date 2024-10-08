<?php

use App\Models\Department;
use App\Models\Manager;
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
            $table->string('first_name', 255);
            $table->string('last_name', 255);
            $table->string('email', 255)->unique();
            $table->string('phone', 20);
            $table->date('date_of_birth');
            $table->dateTime('hire_date');
            $table->decimal('salary', 10, 2);
            $table->tinyInteger('is_active')->default(1);
            $table->foreignIdFor(Department::class)->constrained();
            $table->foreignIdFor(Manager::class)->constrained();
            $table->text('address');
            $table->binary('profile_picture')->nullable();
            $table->softDeletes();
            $table->timestamps();
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
