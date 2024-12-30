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
        Schema::create('complaints', function (Blueprint $table) {
            $table->id(); // auto-incrementing primary key
            $table->string('user_id', 15); // make sure the 'user_id' matches the type of the 'nim' column in 'users'
            $table->string('judul'); // complaint title
            $table->text('deskripsi'); // complaint description
            $table->string('kategori', 100); // category of the complaint
            $table->enum('status', ['unanswered', 'answered', 'closed'])->default('unanswered'); // complaint status
            $table->timestamps(); // created_at and updated_at columns

            // Foreign key constraint for 'user_id'
            $table->foreign('user_id')->references('nim')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('complaints');
    }
};
