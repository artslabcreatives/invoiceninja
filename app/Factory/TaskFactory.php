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

namespace App\Factory;

use App\Models\Task;

class TaskFactory
{
    public static function create($company_id, $user_id) :Task
    {
        $task = new Task;

        $task->description = '';
        //$task->rate = '';
        $task->company_id = $company_id;
        $task->user_id = $user_id;
        $task->time_log = '[]';
        $task->is_running = false;
        $task->is_deleted = false;
        $task->duration = 0;

        return $task;
    }
}
