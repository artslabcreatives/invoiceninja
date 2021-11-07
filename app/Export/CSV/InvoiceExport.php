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

namespace App\Export\CSV;

use App\Models\Company;
use Excel;

class InvoiceExport
{
    private $company;

    public function __construct(Company $company)
    {
        $this->company = $company;
    }

    public function export()
    {
        // $fileName = 'test.csv';
        
        // $data = $this->company->invoices->get();

  //       return Excel::create($fileName, function ($excel) use ($data) {
  //           $excel->sheet('', function ($sheet) use ($data) {
  //               $sheet->loadView('export', $data);
  //           });
  //       })->download('csv');
    }
}
