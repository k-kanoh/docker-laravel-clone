<?php declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class() extends Migration {
    /**
     * Run the migrations.
     */
    public function up() : void
    {
        Schema::create('favorites', function(Blueprint $table) {
            $table->id();
            $table->unsignedMediumInteger('gen_id');
            $table->unsignedMediumInteger('song_id');
            $table->datetimes();
            $table->softDeletesDatetime();
            $table->index(['gen_id', 'deleted_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down() : void
    {
        Schema::dropIfExists('favorites');
    }
};
