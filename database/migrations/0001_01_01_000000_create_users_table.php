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
        // Schema::create('users', function (Blueprint $table) {
        //     $table->id();
        //     $table->string('name');
        //     $table->string('email')->unique();
        //     $table->timestamp('email_verified_at')->nullable();
        //     $table->string('password');
        //     $table->rememberToken();
        //     $table->timestamps();
        // });

         // Create Roles Table
         Schema::create('roles', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 80);
            $table->text('description');
            $table->timestamps();
            $table->softDeletes();
        });
        // Create Permission Table
        Schema::create('permissions', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 80);
            $table->string('slug', 40);
            $table->timestamps();
            $table->softDeletes();
        });
        // Create Roles-Permissions Table
        Schema::create('permission_role', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('role_id')->unsigned()->nullable();
            $table->integer('permission_id')->unsigned()->nullable();
            $table->foreign('role_id')->references('id')->on('roles');
            $table->foreign('permission_id')->references('id')->on('permissions');
            $table->timestamps();
        });
        // Create Users Table
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->integer('servidor_id')->unsigned()->nullable();
            $table->string('matricula')->nullable();
            $table->string('email')->unique();
            $table->string('name')->nullable();
            $table->string('cpf')->nullable();
            $table->string('sexo', 30)->nullable();
            $table->string('telefone')->nullable();
            $table->string('cargo_id')->nullable();
            $table->string('cargo')->nullable();
            $table->string('classe_funcional')->nullable();
            $table->string('nivel_funcional')->nullable();
            $table->string('status')->nullable();
            $table->integer('unidade_lotacao_id')->unsigned()->nullable();
            $table->string('unidade_lotacao')->nullable();
            $table->integer('unidade_logada_id')->unsigned()->nullable();
            $table->string('unidade_logada')->nullable();
            $table->integer('unidade_estrutura_id')->unsigned()->nullable();
            $table->integer('unidade_sede')->unsigned()->nullable();
            $table->string('srpc')->nullable();
            $table->string('dspc')->nullable();
            $table->string('nivel')->nullable();
            $table->timestamp('email_verified_at')->nullable()->nullable();
            $table->string('password')->nullable();
            $table->integer('role_id')->unsigned()->nullable();
            $table->foreign('role_id')->references('id')->on('roles');
            $table->rememberToken();
            $table->timestamps();
        });

        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');
    }
};
