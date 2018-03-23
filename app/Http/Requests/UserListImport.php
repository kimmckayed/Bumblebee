<?php

namespace App\Http\Requests;

use Flash;
use Input;
use Maatwebsite\Excel\Files\ExcelFile;
use Redirect;

class UserListImport extends ExcelFile {

    public function getFile()
    {
        // Import a fleet file
        $file = Input::file('fleetExcelFile');
        if(!$file->isValid()){
            Flash::error('you don\'t have permissions for adding groups');
            return Redirect::back();
        }
        $time=time();
        $file->move(public_path('uploads/excel'),$time);
        // Return it's location
        return public_path('uploads/excel/').$time;
    }

    public function getFilters()
    {
        return [
            'chunk'
        ];
    }

}