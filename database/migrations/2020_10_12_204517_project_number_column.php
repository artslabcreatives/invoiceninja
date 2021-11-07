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
use Illuminate\Support\Facades\Schema;

class ProjectNumberColumn extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('projects', function ($table) {
            $table->string('number')->nullable();
            $table->unique(['company_id', 'number']);
        });

        Schema::table('expenses', function ($t) {
            $t->renameColumn('expense_date', 'date');
        });

        Schema::table('expense_categories', function ($t) {
            $t->boolean('is_deleted')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
