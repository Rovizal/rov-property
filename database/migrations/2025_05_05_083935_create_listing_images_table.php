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
        Schema::create('listing_images', function (Blueprint $table) {
            $table->id();
            $table->timestamps();

            $table->string('filename');

            $table->foreignIdFor(
                \App\Models\Listing::class
            )->constrained('listings');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('listing_images');
    }
};
