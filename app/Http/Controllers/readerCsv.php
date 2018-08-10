<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Customer;
use Box\Spout\Reader\ReaderFactory;
use Box\Spout\Writer\WriterFactory;
use Box\Spout\Common\Type;

class readerCsv extends Controller
{
    public function index()
    {
        return view('csv');
    }
    public function upload(Request $request)
    {
        if ($request->hasFile('file')) {
            $file = $request->file('file');// get file
            $reader = ReaderFactory::create(Type::CSV); 
            $reader->open($file);
            // loop semua sheet dan dapatkan sheet orders
            foreach ($reader->getSheetIterator() as $sheet) {
                if ($sheet->getName() === 'Orders') {
                    $this->readOrderSheet($sheet);// baca sheet orders
                }
            }
            $reader->close();
        }
    }
    
    public function readOrderSheet($sheet)
    {

        foreach ($sheet->getRowIterator() as $idx => $row) {
            if ($idx>1) { 
                $data = [];
                $customer = new Customer();
                $customer->fill($data);
                $customer->save(); 
            }
        }
    }
    public function exportExcel()
    {
        $title = [];
        $fileName = 'sommaire.csv';
        $writer = WriterFactory::create(Type::CSV); 
        $customers = Customer::all(); 
        
        $writer->openToBrowser($fileName); 
        $writer->addRow($title); 
        foreach ($customers as $idx => $data) {
            $writer->addRow($data->toArray()); 
        }
        $writer->close();
    }
}
