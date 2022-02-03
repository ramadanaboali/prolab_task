<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInfosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('infos', function (Blueprint $table) {
            $table->id();
            $table->string('main_color')->nullable();
            $table->string('secondary_color')->nullable();
            $table->string('main_font_color')->nullable();
            $table->string('secondary_font_color')->nullable();
            $table->string('name_ar')->nullable();
            $table->string('name_en')->nullable();
            $table->string('email')->nullable();
            $table->string('email_message')->nullable();
            $table->string('phone')->nullable();
            $table->string('phone_message')->nullable();
            $table->string('app_version')->nullable();
            $table->text('fb_link')->nullable();
            $table->text('tw_link')->nullable();
            $table->text('in_link')->nullable();
            $table->text('insta_link')->nullable();
            $table->text('website_link')->nullable();
            $table->text('address')->nullable();
            $table->longText('bio_en')->nullable();
            $table->longText('bio_ar')->nullable();
            $table->longText('privacy_en')->nullable();
            $table->longText('privacy_ar')->nullable();
            $table->longText('agreement_en')->nullable();
            $table->longText('agreement_ar')->nullable();
            $table->string('logo_en')->nullable();
            $table->string('logo_ar')->nullable();
            $table->string('icon')->nullable();
            $table->text('appStore_link')->nullable();
            $table->text('googlePlay_link')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('infos');
    }
}
