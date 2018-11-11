<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddCoverImageToPosts extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // State the table you're referring to
        Schema::table('posts', function($table) {
            // State the column and the property
            $table->string('cover_image');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // To rollback the column
        Schema::table('posts', function($table) {
            $table->dropColumn('cover_image');
        }); 
    }
}
