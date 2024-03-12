<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Models\FileUpload;
use Illuminate\Support\Facades\Log;

class ProcessCsvUpload implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $file;

    /**
     * Create a new job instance.
     *
     * @param FileUpload $file
     * @return void
     */
    public function __construct(FileUpload $file)
    {
        $this->file = $file;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        // Assuming the CSV file is stored in a public directory and the path is stored in the model
        $csvFilePath = storage_path('app/public/' . $this->file->file_path);

        // Here you can process the CSV file. For demonstration, we'll just log the file name and size.
        Log::info('Processing CSV file for user profile ID: ' . $this->file->id);
        Log::info('File size: ' . filesize($csvFilePath));

        // Example of processing the CSV file
        // $csvData = array_map('str_getcsv', file($csvFilePath));
        // foreach ($csvData as $row) {
        //     // Process each row
        // }
    }
}
