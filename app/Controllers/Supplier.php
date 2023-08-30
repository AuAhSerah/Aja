<?php

namespace App\Controllers;

use App\Libraries\GroceryCrud;

class Supplier extends BaseController
{

    public function index()
    {
        $crud = new GroceryCrud();
        $crud->setTable('supplier');
        $crud->setTheme('datatables');
        $crud->setLanguage('Indonesian');
        $crud->columns(['name', 'no_supplier', 'gender', 'address', 'email', 'phone']);
        $crud->unsetColumns(['created_at', 'updated_at']);
        $crud->unsetAddFields(['created_at', 'updated_at']);
        $crud->unsetEditFields(['created_at', 'updated_at']);
        // $crud->setRelation('officeCode', 'offices', 'city');
        // $crud->unsetAdd();
        // $crud->unsetEdit();
        // $crud->unsetDelete();
        // $crud->unsetExport();
        // $crud->unsetPrint();
        $crud->setRule('name', 'Nama', 'required', ['required' => '{field} harus diisi!']);
        $crud->displayAs(array(
            'name' => 'Nama',
            'gender' => 'L/P',
            'address' => 'Alamat',
            'phone' => 'Telp',
        ));
        // $crud->where('deleted_at', null);
        $output = $crud->render();
        $data = [
            'title' => 'Data Supplier',
            'result' => $output
        ];
        return view('supplier/index', $data);
    }
}
