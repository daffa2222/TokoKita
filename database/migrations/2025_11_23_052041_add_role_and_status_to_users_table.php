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
        Schema::table('users', function (Blueprint $table) {
            // Menambahkan kolom role, status seller, dan no hp
            $table->enum('role', ['admin', 'seller', 'buyer'])->default('buyer')->after('password');
            $table->enum('seller_status', ['pending', 'approved', 'rejected'])->nullable()->after('role');
            $table->string('phone')->nullable()->after('email');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['role', 'seller_status', 'phone']);
        });
    }
};