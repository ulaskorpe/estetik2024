<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Helpers\GeneralHelper;
use Illuminate\Support\Facades\Storage;
class UploadFilesJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    protected $category;
    protected $files;

    /**
     * Create a new job instance.
     */
    public function __construct($category,   $files)
    {
        $this->category = $category;
        $this->files = $files;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {    
        $var = "";
   
        // foreach (  $this->files  as $file) {
        //     $fileName = basename($file);
        //     $var.=$fileName;
        //     // Upload the file to the storage disk
        //    Storage::disk('public/files/categories/' )->put($fileName, file_get_contents($file));

        // }

        // Log::channel('data_check')->info( $var);
    }
}
 