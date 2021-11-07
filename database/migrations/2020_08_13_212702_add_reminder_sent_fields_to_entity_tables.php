<?php
/**
 * Hype Sri Lanka (https://hypesl.org).
 *
 * @link https://github.com/artslabcreatives/invoiceninja source repository
 *
 * @copyright Copyright (c) 2021. Hype Sri Lanka (https://hypesl.org)
 *
 * @license https://opensource.org/licenses/AAL
 */


use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddReminderSentFieldsToEntityTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('activities', function (Blueprint $table) {
            $table->unsignedInteger('quote_id')->nullable();
        });

        Schema::table('quotes', function (Blueprint $table) {
            $table->date('reminder1_sent')->nullable();
            $table->date('reminder2_sent')->nullable();
            $table->date('reminder3_sent')->nullable();
            $table->date('reminder_last_sent')->nullable();
        });

        Schema::table('invoices', function (Blueprint $table) {
            $table->date('reminder1_sent')->nullable();
            $table->date('reminder2_sent')->nullable();
            $table->date('reminder3_sent')->nullable();
            $table->date('reminder_last_sent')->nullable();
        });

        Schema::table('credits', function (Blueprint $table) {
            $table->date('reminder1_sent')->nullable();
            $table->date('reminder2_sent')->nullable();
            $table->date('reminder3_sent')->nullable();
            $table->date('reminder_last_sent')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
    }
}
