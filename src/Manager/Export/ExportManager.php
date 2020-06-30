<?php

namespace App\Manager\Export;

use Symfony\Component\Mercure\Publisher;
use Symfony\Component\Mercure\Update;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use App\Manager\UserManager;

class ExportManager
{
    public function __construct(
        UserManager $userManager
    ) {
        $this->userManager = $userManager;
    }
    /**
     * 
     */
    public function exportXlsx( array $fields, array $datas, string $name )
    {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->fromArray(
            $fields,   // The data to set
            NULL,        // Array values with this value will not be set
            'A1'         // Top left coordinate of the worksheet range where
                         //    we want to set these values (default is A1)
        );
        $sheet->fromArray(
            $datas,   // The data to set
            NULL,        // Array values with this value will not be set
            'A2'         // Top left coordinate of the worksheet range where
                         //    we want to set these values (default is A1)
        );

        $writer = new Xlsx($spreadsheet);
        $writer->save($name.'.xlsx');
    }
}