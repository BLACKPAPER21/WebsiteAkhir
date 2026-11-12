<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('seller_applications', function (Blueprint $table) {
            $table->string('ktp_nik')->nullable()->after('ktp_image_path');
            $table->string('ktp_name')->nullable()->after('ktp_nik');
            $table->string('ktp_dob')->nullable()->after('ktp_name');       // tanggal lahir
            $table->string('ktp_address')->nullable()->after('ktp_dob');
        });
    }

    public function down(): void
    {
        Schema::table('seller_applications', function (Blueprint $table) {
            $table->dropColumn(['ktp_nik', 'ktp_name', 'ktp_dob', 'ktp_address']);
        });
    }
};
