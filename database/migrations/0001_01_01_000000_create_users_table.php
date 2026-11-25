<?php
// Menimpa migration users bawaan Laravel agar skemanya sama dengan database.sql lama
// (kolom: id, username, email, password, created_at).

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');                       // INT UNSIGNED AUTO_INCREMENT
            $table->string('username', 50)->unique('uq_users_username');
            $table->string('email', 100)->unique('uq_users_email');
            $table->string('password', 255);
            $table->timestamp('created_at')->useCurrent();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
