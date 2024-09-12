<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (!Schema::hasTable('sse_notify')) {
            Schema::create('sse_notify', static function (Blueprint $table) {
                $table->uuid('id')->default(DB::raw('public.uuid_generate_v4()'))->primary();
                $table->string('event');
                $table->string('type');
                $table->jsonb('data');
                $table->boolean('read')->default(false);
                $table->foreignUuid('user_id');
                $table->timestamps();
            });
        }
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sse_notify');
    }
};
