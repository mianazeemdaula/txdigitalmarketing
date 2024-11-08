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
        Schema::create('f_b_ads', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('term_trend_id');
            $table->string("ad_id", 20);
            $table->string("page_id", 20);
            $table->string("page_name", 255);
            $table->string("ad_snapshot_url", 500);
            $table->dateTime("ad_creation_time");
            $table->date("ad_delivery_start_time");
            $table->date("ad_delivery_stop_time")->nullable();
            $table->mediumText("ad_creative_bodies")->nullable();
            $table->mediumText("ad_creative_link_captions")->nullable();
            $table->mediumText("ad_creative_link_descriptions")->nullable();
            $table->mediumText("ad_creative_link_titles")->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('f_b_ads');
    }
};
