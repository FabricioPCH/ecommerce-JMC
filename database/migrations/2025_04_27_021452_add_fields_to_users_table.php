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
            // Hacer el campo password nullable para permitir login con Google
            $table->string('password')->nullable()->change();
            
            // Agregar el campo de rol para distinguir entre tipos de usuarios
            $table->enum('role', ['admin', 'employee', 'client'])->default('client')->after('password');
            
            // Agregar los campos para autenticación con Google
            $table->string('google_id')->nullable()->after('role');
            $table->string('avatar')->nullable()->after('google_id');
            $table->string('phone', 20)->nullable()->after('avatar');
            $table->text('address')->nullable()->after('phone');
            $table->timestamp('last_login_at')->nullable()->after('email_verified_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Revertir el campo password a not nullable
            $table->string('password')->nullable(false)->change();
            
            // Eliminar los campos agregados
            $table->dropColumn([
                'role',
                'google_id',
                'avatar',
                'phone',
                'address',
                'last_login_at'
            ]);
        });
    }
};
