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
        Schema::create('personal_access_tokens', function (Blueprint $table) {
            $table->id();
            $table->string('name', 30);
            $table->string('token');
            $table->jsonb('abilities');
            $table->timestamp('expires_at')->nullable();
            $table->integer('tokenable_id')->constrained('users.id')->onDelete('cascade');
            $table->string('tokenable_type');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('personal_access_tokens');
    }
};
// `name`, `token`, `abilities`, `expires_at`, `tokenable_id`, `tokenable_type`, `updated_at`, `created_at`) values 
// (auth_token, 1f363b0d6351e6f1e1c801e8ef4b3ea84886bf2ff643ffda1a7ebd8fa4888274, [\"*\"], ?, 1, App\\Models\\User, 2026-10-06 20:41:02, 2026-10-06 20:41:02))