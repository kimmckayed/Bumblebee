<?php namespace App\vendor\zofe\rapyd\DataGrid;

use Illuminate\Support\Facades\View;
use Zofe\Rapyd\DataGrid\DataGrid as ParentDataGrid;
use Zofe\Rapyd\Persistence;
use Zofe\Rapyd\DataGrid\Row;
use Zofe\Rapyd\DataGrid\Column;
use Zofe\Rapyd\DataGrid\Cell;
use Illuminate\Support\Facades\Config;

class DataGrid extends ParentDataGrid
{

    public function buildExcel($file = '', $timestamp = '', $sanitize = true)
    {
          $this->limit = null;
        parent::build();
         $segments = \Request::segments();

        $filename = ($file != '') ? basename($file, '.xls') : end($segments);
        $filename = preg_replace('/[^0-9a-z\._-]/i', '',$filename);
        $filename .= ($timestamp != "") ? date($timestamp) : "";

            $headers  = array(
                'Content-Type' => 'application/vnd.ms-excel',
                'Pragma'=>'no-cache',
                '"Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
                'Content-Disposition' => 'attachment; filename="' . $filename.'"');


        $memberShipsSheet= \Excel::create($filename, function ($excel)   {
            // Set sheets
            $excel->sheet("Memberships", function ($sheet) {
                
// Set auto size for sheet
           

                $sheet->setAutoSize(true);
                
                $sheet->row(1,$this->headers);
                $sheet->row(1, function($row) {

    // call cell manipulation methods
    $row->setFontColor('#FF661B');
    

});
                foreach ($this->data as $tablerow) {
                    $row = new Row($tablerow);

                    foreach ($this->columns as $column) {

                        if (in_array($column->name,array("_edit")))
                            continue;

                        $cell = new Cell($column->name);
                        $value =  str_replace('"', '""',str_replace(PHP_EOL, '', strip_tags($this->getCellValue($column, $tablerow, true))));
                        $cell->value($value);
                        $row->add($cell);
                    }

                    if (count($this->row_callable)) {
                        foreach ($this->row_callable as $callable) {
                            $callable($row);
                        }
                    }

                    $sheet->appendrow($row->toArray());
                }

            });

        });
            return \Response::make($memberShipsSheet->export('xls'), 200, $headers);
    }

}
