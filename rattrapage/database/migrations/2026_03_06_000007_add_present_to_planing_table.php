<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('planing', function (Blueprint $table) {
            $table->boolean('present')->default(false)->after('horaire');
        });
    }

    public function down(): void
    {
        Schema::table('planing', function (Blueprint $table) {
            $table->dropColumn('present');
        });
    }
};
