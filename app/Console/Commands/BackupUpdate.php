<?php
/**
 * Hype Sri Lanka (https://hypesl.org).
 *
 * @link https://github.com/artslabcreatives/invoiceninja source repository
 *
 * @copyright Copyright (c) 2021. Hype Sri Lanka (https://hypesl.org)
 *
 * @license https://www.elastic.co/licensing/elastic-license
 */

namespace App\Console\Commands;

use App\Libraries\MultiDB;
use App\Models\Backup;
use App\Models\Design;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use stdClass;

class BackupUpdate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ninja:backup-update';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Shift backups from DB to storage';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        //always return state to first DB

        $current_db = config('database.default');

        if (! config('ninja.db.multi_db_enabled')) {
            $this->handleOnDb();
        } else {

            //multiDB environment, need to
            foreach (MultiDB::$dbs as $db) {
                MultiDB::setDB($db);

                $this->handleOnDb();
            }

        MultiDB::setDB($current_db);
        
        }


    }

    private function handleOnDb()
    {

        Backup::whereHas('activity')->whereNotNull('html_backup')->cursor()->each(function($backup){

            if($backup->activity->client()->exists()){

                $client = $backup->activity->client;
                $backup->storeRemotely($backup->html_backup, $client);

            }

        });

    }
}
