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
        Schema::table('commande_items', function (Blueprint $table) {
            $table->unsignedBigInteger('commande_id');
            $table->foreign('commande_id')->references('id')->on('commandes')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('commande_items', function (Blueprint $table) {
            $table->dropForeign(['commande_id']);
            $table->dropColumn('commande_id');
        });
    }
};
