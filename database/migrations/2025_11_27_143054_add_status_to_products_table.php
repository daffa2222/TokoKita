<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::table('products', function (Blueprint $table) {
        // Menambahkan kolom status setelah kolom stock
        // Defaultnya 'active' agar produk lama dianggap aktif semua
        $table->string('status')->default('active')->after('stock');
    });
}

public function down()
{
    Schema::table('products', function (Blueprint $table) {
        $table->dropColumn('status');
    });
}
};
