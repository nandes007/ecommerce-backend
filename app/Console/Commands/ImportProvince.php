<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class ImportProvince extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:province';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import Province';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $file_path = resource_path("csvs/provinces.csv");
        $file_contents = file_get_contents($file_path);
        $file_contents = str_replace("\r", "", $file_contents);
        $rows = explode("\n", $file_contents);

        foreach ($rows as $index => $row) {
            $column = str_getcsv($row);

            if ($index == 0) {
                continue;
            }

            try {
                $province = $column[1];
            } catch (\Exception $e) {
                $this->error("CANNOT GET FILE FROM CSV");
                continue;
            }

//            $province = new Province
        }
    }
}
