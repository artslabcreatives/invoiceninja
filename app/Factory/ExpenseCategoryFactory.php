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

use App\Models\ExpenseCategory;

class ExpenseCategoryFactory
{
    public static function create(int $company_id, int $user_id) :ExpenseCategory
    {
        $expense = new ExpenseCategory();
        $expense->user_id = $user_id;
        $expense->company_id = $company_id;
        $expense->name = '';
        $expense->is_deleted = false;
        $expense->color = '';
        
        return $expense;
    }
}
