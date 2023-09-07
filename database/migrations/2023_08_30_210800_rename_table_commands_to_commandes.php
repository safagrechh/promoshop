<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RenameTableCommandsToCommandes extends Migration
{
    public function up()
    {
        Schema::rename('commands', 'commandes');
    }

    public function down()
    {
        Schema::rename('commandes', 'commands');
    }
}
