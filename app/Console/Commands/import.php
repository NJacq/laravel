<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Box\Spout\Reader\ReaderFactory;
use Box\Spout\Common\Type;
 

class import extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:name';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
        $this->info('Début du script');
 
        $i = 0;
 
        $fileName = $this->argument('file');
        $fileNamePath = '/tests/'.$fileName;
 
        // ici il faut avoir déclarer un disk "import" dans config/filesystem.php
        $fileNameAbsolutePath = Storage::disk('import')->path($fileNamePath);
 
        $this->line('Load file '.$fileNamePath.'...');
        $this->line('');
 
        $reader = ReaderFactory::create(Type::CSV);
        $reader->setFieldDelimiter('|');
 
        $reader->open($fileNameAbsolutePath); // open CSV file
 
        // parcourir les lignes
        foreach($reader->getSheetIterator() as $sheet) {
 
            $i = 0;
 
            foreach($sheet->getRowIterator() as $row) {
 
                foreach($row as $k=>$v) {
                    $row[$k] = trim($v);
                }
             
                $i++;
 
            }
 
        }
 
        $this->info('Fin du script');
    }
}
