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
    Schema::create('notifications', function (Blueprint $table) {
        $table->id();

        $table->foreignId('user_id'); // quem recebe
        $table->foreignId('from_user_id'); // quem fez a ação
        $table->string('type'); // like ou comment
        $table->foreignId('chirp_id');

        $table->boolean('read')->default(false);

        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notifications');
    }
};
