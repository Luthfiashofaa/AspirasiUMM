<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB; // Tambahkan ini

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('comments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('pengaduan_id');
            $table->string('user_id', 15);
            $table->text('isi_komentar'); // Isi komentar
            $table->boolean('is_admin')->default(false);
            $table->timestamps();
            
            $table->foreign('pengaduan_id')->references('id')->on('complaints')->onDelete('cascade');
            $table->foreign('user_id')->references('nim')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('comments');
    }
};
