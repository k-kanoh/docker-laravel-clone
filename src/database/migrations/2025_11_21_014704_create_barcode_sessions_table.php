<?php declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up() : void
    {
        Schema::create('barcode_sessions', function(Blueprint $table) {
            $table->id();
            $table->string('session_id', 36)->unique();
            $table->string('create_ip', 45)->nullable();
            $table->string('create_host')->nullable();
            $table->json('scanned_data')->nullable();
            $table->string('scanner_ip', 45)->nullable();
            $table->string('scanner_host')->nullable();
            $table->datetimes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down() : void
    {
        Schema::dropIfExists('barcode_sessions');
    }
};
