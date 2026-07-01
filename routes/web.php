<?php

use App\Http\Controllers\Api\FolderApiController;
use App\Http\Controllers\Api\MediaController;
use App\Http\Controllers\Api\ProviderController;
use App\Http\Controllers\Api\UserMediaListController;
use App\Http\Controllers\Api\UserMediaListApiController;
use App\Models\ChapterList;
use App\Models\Media;
use App\Models\Provider;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Process;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;
use Laravel\Fortify\Features;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canRegister' => Features::enabled(Features::registration()),
    ]);
})->name('home');

Route::get('dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('manga', function () {
    return Inertia::render('MangaIndex');
})->name('manga');

Route::get('manga/{id}', function ($id) {
    $media = \App\Models\Media::with(['authors', 'tags', 'providers'])->findOrFail($id);

    // dd($media);

    return Inertia::render('MangaDetail', ['media' => $media]);
})->name('manga.detail');

Route::get('/test-anthropic', function () {

    // // return Http::get('https://api.anthropic.com')->body();
    //       $providers = Provider::with(['scrapingScripts' => function($query){
    //         $query->where('scraping_type_id',3);
    //    }, "mediaProvider"])->get();

    //  $chapterList = [];

    //    foreach($providers as $provider){
    //         $file = $provider->scrapingScripts->first()->file;

    //         foreach($provider->mediaProvider as $media){
    //             $uri = $media->media_uri;


    //             $chapterList[$media->id] = runProcess($file, $uri);


    //             sleep(3);
    //         }

    //    }

    //     Storage::disk("local")->put("/chapters" . "/" . "chapters_lists.json", json_encode($chapterList));

    $media = Media::has("providers")->with(["providers" => function($query){
        $query->with(["mediaProvider" => function($q){
            $q->where("media_id", "=", 12)->with(["chapterList"]);
        }]);
    }])->findOrFail(12);


    dd($media->providers);



});



    function runProcess($file, $media)
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

require __DIR__.'/settings.php';
