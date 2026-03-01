<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('umkm_categories', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100);
            $table->string('slug')->unique();
            $table->string('icon')->nullable();
            $table->text('description')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        Schema::create('umkm_profiles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('name', 200);
            $table->string('slug')->unique();
            $table->foreignId('category_id')->nullable()->constrained('umkm_categories')->nullOnDelete();
            $table->text('description')->nullable();
            $table->string('logo')->nullable();
            $table->text('address');
            $table->string('kelurahan', 100)->nullable();
            $table->string('kecamatan', 100);
            $table->decimal('latitude', 10, 8)->nullable();
            $table->decimal('longitude', 11, 8)->nullable();
            $table->string('phone', 20)->nullable();
            $table->string('whatsapp', 20)->nullable();
            $table->string('instagram', 100)->nullable();
            $table->string('website')->nullable();
            $table->json('operational_hours')->nullable();
            $table->string('nik_pemilik', 16)->nullable();
            $table->string('no_izin_usaha', 50)->nullable();
            $table->enum('status', ['pending', 'active', 'inactive', 'rejected'])->default('pending');
            $table->timestamp('verified_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('umkm_profiles');
        Schema::dropIfExists('umkm_categories');
    }
};
