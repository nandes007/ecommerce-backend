<?php

namespace App\Console\Commands;

use App\Models\City;
use Illuminate\Console\Command;

class ImportCity extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:city';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import City';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $file_path = resource_path("csvs/cities.csv");
        $file_contents = file_get_contents($file_path);
        $file_contents = str_replace("\r", "", $file_contents);
        $rows = explode("\n", $file_contents);

        foreach ($rows as $index => $row) {
            $column = str_getcsv($row);

            if ($index == 0) {
                continue;
            }

            try {
                $province_id = $column[0];
                $city = $column[1];
            } catch (\Exception $e) {
                $this->error("CANNOT GET FILE FROM CSV");
                continue;
            }

            $dataToInsert = [
                'province_id' => $province_id,
                'name' => $city
            ];

            City::create($dataToInsert);
            $this->info("CITY HAS BEEN IMPORT SUCCESSFULLY");
        }
    }
}
