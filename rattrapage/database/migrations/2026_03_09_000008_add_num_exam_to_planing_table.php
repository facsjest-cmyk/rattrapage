<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('planing', function (Blueprint $table) {
            $table->string('num_exam')->nullable()->after('salle');
        });
    }

    public function down(): void
    {
        Schema::table('planing', function (Blueprint $table) {
            $table->dropColumn('num_exam');
        });
    }
};
