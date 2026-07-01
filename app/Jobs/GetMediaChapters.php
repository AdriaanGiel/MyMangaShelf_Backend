<?php

namespace App\Jobs;

use App\Models\Provider;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Process;
use Illuminate\Support\Facades\Storage;

class GetMediaChapters implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
           $providers = Provider::with(['scrapingScripts' => function($query){
            $query->where('scraping_type_id',3);
       }, "mediaProvider"])->get();


       $chapterList = [];

       foreach($providers as $provider){
            $file = $provider->scrapingScripts->first()->file;

            foreach($provider->mediaProvider as $media){
                $uri = $media->media_uri;


                $chapterList[$media->id] = $this->runProcess($file, $uri);


                sleep(3);
            }

       }

       Storage::disk("local")->put("/chapters" . "/" . "chapters_lists.json", $chapterList);

    }

    private function runProcess($file, $media)
    {

        $process = Process::forever()
        ->run("../analyzor/website_analyzer/analyzor/bin/python3 ../storage/app/private/scripts/".$file . " $media");

        if (!$process->successful()) {
            throw new Exception($process->errorOutput());
        }

        $output = str_replace("\n", "",$process->output());

        // dd(json_decode($output));
        // $str = $this->getJson($output);

        return json_decode($output);

    }
}
