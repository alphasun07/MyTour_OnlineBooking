<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateTable extends Migration
{

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('pcm_users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email');
            $table->timestamp('email_verified_at')->nullable();
            $table->string('phone_number', 16)->nullable();
            $table->string('address', 255)->nullable();
            $table->tinyInteger('gender_id')->default(0);
            $table->date('birthdate')->nullable();
			$table->string('referral_code', 50)->nullable();
            $table->string('password');
            $table->rememberToken();
            $table->softDeletes();
            $table->timestamps();
        });

		Schema::create('pcm_dms_categories', function (Blueprint $table) {
			$table->integer('id', true);
			$table->string('name', 256)->default(0);
			$table->integer('parent_id')->default(null);
			$table->text('description')->default(null);
			$table->string('category_thumb', 256)->default(null);
			$table->string('meta_key', 256)->default(null);
			$table->string('meta_description', 256)->default(null);
			$table->integer('ordering')->default(0);
			$table->boolean('published', 1)->nullable();
			$table->timestamps();
			$table->softDeletes();
		});

		Schema::create('pcm_members', function (Blueprint $table) {
			$table->id();
			$table->string('login_id', 256);
			$table->string('password', 256);
			$table->smallInteger('sort_no')->nullable();
			$table->dateTime('login_date')->nullable();
            $table->string('name');
            $table->timestamp('email_verified_at')->nullable();
            $table->string('phone_number', 16)->nullable();
            $table->string('address', 255)->nullable();
            $table->tinyInteger('gender_id')->default(0);
            $table->date('birthdate')->nullable();
            $table->rememberToken();
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
		Schema::drop('pcm_dms_categories');
		Schema::drop('pcm_members');
		Schema::drop('pcm_users');
	}
}
