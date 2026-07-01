<?php

namespace Tests\Feature;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Process;
use Tests\TestCase;

class PythonScriptTest extends TestCase
{

    function test_pythons_get_chapters()
    {
        $files = [
            ["qimanga.com-b7277335-8164-4c5f-8a68-1b22fb90f423-get_chapters.py", "https://qimanga.com/series/the-ember-knight"],
            ["asurascans-a3f5b721-e730-4eb6-928d-2a106f3647f3-get_chapters.py","https://asurascans.com/comics/nano-machine"],
            ["lagoonscans-e74b3d32-d872-4753-9a3b-2856bb7b1d6f-get_chapters.py","https://lagoonscans.com/manga/nano-machine/"]
        ];


        // $cd = Process::forever()->run("ls");

        // dd($cd);

        $process = Process::forever()
        ->run("./analyzor/website_analyzer/analyzor/bin/python3 ./storage/app/private/scripts/". $files[0][0] . " " . $files[0][1]);


        $this->assertTrue(
            $process->successful(),
            'Python script failed: ' . $process->errorOutput()
        );

        $output = trim($process->output());
        $output = str_replace("\n", "",$process->output());

        $this->assertNotEmpty(
            $output,
            'Python script returned no data.'
        );

         $decoded = json_decode($output, true);

        $this->assertNotNull(
            $decoded,
            'Output is not valid JSON: ' . $output
        );
        // dd(json_decode($output));
        // $str = $this->getJson($output);

        dump($decoded);

        $this->assertNotEmpty(
            $decoded,
            'JSON output is empty.'
        );


    }
}
