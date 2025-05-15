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
    Schema::table('answers', function (Blueprint $table) {
        // Menghapus foreign key lama
        $table->dropForeign(['question_id']);
        
        // Menambahkan foreign key baru dengan ON DELETE CASCADE
        $table->foreign('question_id')
              ->references('id')->on('questions')
              ->onDelete('cascade');
    });
}

public function down()
{
    Schema::table('answers', function (Blueprint $table) {
        // Menghapus foreign key dengan cascade delete
        $table->dropForeign(['question_id']);
        
        // Menambahkan foreign key tanpa cascade
        $table->foreign('question_id')
              ->references('id')->on('questions');
    });
}

};
