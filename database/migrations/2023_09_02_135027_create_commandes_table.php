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
        Schema::create('commandes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id'); // ID de l'utilisateur qui a passé la commande
            $table->json('items')->nullable(); // JSON contenant les détails des articles commandés (id, nom, quantité, prix, etc.)
            $table->decimal('total_amount', 10, 2);
            $table->string('address'); // Add a column for the client's address
            $table->string('phone');  // Montant total de la commande
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('commandes');
    }
};
