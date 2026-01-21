<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('mobile', 10)->unique()->after('email');
            $table->enum('role', ['admin', 'member'])->default('member')->after('password');
            $table->text('address')->after('role');
            $table->string('city')->after('address');
            $table->string('pincode', 6)->after('city');
            $table->boolean('is_active')->default(true)->after('pincode');
        });
    }

    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['mobile', 'role', 'address', 'city', 'pincode', 'is_active']);
        });
    }
};