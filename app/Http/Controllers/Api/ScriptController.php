<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Jobs\GenerateScrapingFiles;
use App\Models\Generation;
use App\Models\Provider;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Process;

class ScriptController extends Controller
{
    public function getChapters(Request $request){

        //  return response()->json($request->provider_id);
        // dd($request->data)

       $provider = Provider::with(['scrapingScripts' => function($query){
            $query->where('scraping_type_id',3)->first();
       }])->findOrFail($request->provider_id);

       $media = $request->media_uri;
       $file = $provider->scrapingScripts->first()->file;

        $process = Process::forever()
        ->run("../analyzor/website_analyzer/analyzor/bin/python3 ../storage/app/private/scripts/".$file . " $media");

        if (!$process->successful()) {
            throw new Exception($process->errorOutput());
        }

        $output = str_replace("\n", "",$process->output());

        // dd(json_decode($output));
        // $str = $this->getJson($output);

        return response()->json(json_decode($output));


    }

    public function addNewSourc(Request $request) {
        $url = $request->url;

        $generation = Generation::create([
            "status" => "pending",
            "prompt" => $url,
        ]);

        $provider = Provider::create([

        ]);

        // $generate = new GenerateScrapingFiles($generation->id, );



    }
}
