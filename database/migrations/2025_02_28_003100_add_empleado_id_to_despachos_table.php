<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::table('despachos', function (Blueprint $table) {
            $table->foreignId('empleado_id')->nullable()->constrained('users')->onDelete('set null');
           
        });
    }

    public function down(): void {
        Schema::table('despachos', function (Blueprint $table) {
            $table->dropForeign(['empleado_id']);
            $table->dropColumn('empleado_id');
        });
    }
};

