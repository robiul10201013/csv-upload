<?php

namespace App\Jobs;

use App\Events\CsvProcessingProgress;
use App\Models\Employee;
use Exception;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use League\Csv\Reader;
use Illuminate\Support\Facades\Cache;


class ProcessFile implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $file;
    protected $batchSize = 500;

    /**
     * Create a new job instance.
     */
    public function __construct($file)
    {
        $this->file = $file;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {


        // try {

            $this->file->status = "processing";
            $this->file->save();

            // Read and process the CSV file
            $csv = Reader::createFromPath(storage_path('app/csv/' . $this->file->file_name), 'r');
            $csv->setHeaderOffset(0);

            $totalRows = count($csv);
            Log::info($totalRows);
            $processedRows = 0;

            $data = [];




            foreach ($csv->getRecords() as $record) {

                // Use the UNIQUE_KEY column to identify existing records
                $uniqueKey = $record['Emp ID'];

                // Data to upsert
                $data[] = [
                    'emp_id' => $record['Emp ID'],
                    'name_prefix' => $record['Name Prefix'],
                    'first_name' => $record['First Name'],
                    'middle_initial' => $record['Middle Initial'],
                    'last_name' => $record['Last Name'],
                    'gender' => $record['Gender'],
                    'email' => $record['E Mail'],
                    'date_of_birth' => $record['Date of Birth'],
                    'time_of_birth' => $record['Time of Birth'],
                    'age_in_years' => $record['Age in Yrs.'],
                    'date_of_joining' => $record['Date of Joining'],
                    'age_in_company_years' => $record['Age in Company (Years)'],
                    'phone_no' => $record['Phone No.'],
                    'place_name' => $record['Place Name'],
                    'county' => $record['County'],
                    'city' => $record['City'],
                    'zip' => $record['Zip'],
                    'region' => $record['Region'],
                    'user_name' => $record['User Name'],
                ];

                Log::info($data);

                if (count($data) >= $this->batchSize) {
                    Employee::upsert($data, ['emp_id'], ['name_prefix', 'first_name', 'middle_initial', 'last_name', 'gender', 'email',
                        'date_of_birth', 'time_of_birth', 'age_in_years', 'date_of_joining', 'age_in_company_years', 'phone_no', 'place_name', 'county', 'city',
                        'zip', 'region', 'user_name']);

                    $processedRows += count($data);

                    $progress = ($processedRows / $totalRows) * 100;
                    Cache::put('upload_progress_' . $this->file->file_name, $progress, 3600);

                    event(new CsvProcessingProgress($this->file->file_name, $progress));

                    $data = [];
                }
            }

            // Perform the final upsert operation for any remaining rows in the data array
            if (!empty($data)) {
                Employee::upsert($data, ['emp_id'], ['name_prefix', 'first_name', 'middle_initial', 'last_name', 'gender', 'email',
                    'date_of_birth', 'time_of_birth', 'age_in_years', 'date_of_joining', 'age_in_company_years', 'phone_no', 'place_name', 'county', 'city',
                    'zip', 'region', 'user_name']);
                $processedRows += count($data);
            }

            // Remove progress from the cache when processing is complete
            Cache::forget('upload_progress_' . $this->file->file_name);

            $this->file->status = "complete";
            $this->file->save();
            Log::info('Processing file: ' . $this->file);

    }
}
