<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('chat_messages', function (Blueprint $table) {
            $table->foreignId('group_id')->nullable()->constrained()->onDelete('cascade');
            $table->string('message_type')->default('private'); // 'private' ou 'group'

            // Rendre receiver_id nullable pour les messages de groupe
            $table->foreignId('receiver_id')->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('chat_messages', function (Blueprint $table) {
            $table->dropForeign(['group_id']);
            $table->dropColumn(['group_id', 'message_type']);
        });
    }
};
