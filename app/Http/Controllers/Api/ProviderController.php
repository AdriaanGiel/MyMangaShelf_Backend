<?php

namespace App\Http\Controllers\Api;
use Illuminate\Support\Str;

use Illuminate\Support\Facades\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;

use App\Http\Controllers\Controller;
use App\Jobs\GenerateScrapingFiles;
use App\Models\Generation;
use App\Models\Provider;
use App\Services\ClaudeAgentService;
use Dflydev\DotAccessData\Data;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

use function PHPUnit\Framework\matches;

class ProviderController extends Controller
{
    public function index() {
        $providers = Provider::all();
        return response()->json($providers);
    }



    public function store(Request $request){
        $url = $request->provider;

        if(!$this->urlExists($url)){
            return response()->json(["error" => "$url website is offline"]);
        }

        $str = Str::of($url);
        $start = $str->explode(".");

        $name = Str::of($start[0])->explode("https://")[1];

        if($this->checkIfExistInDatabase($name) !== null){
            return response()->json([
               "error_message" => "This website is already added."
            ]);
        }

        $generation = null;

        DB::transaction(function() use ($name, $url, &$generation) {

            $provider = Provider::create([
                    "name" => $name,
                    'logo' => 'https://via.placeholder.com/100x100?text=' . $name ,
                    'website' => $url,
                    'online' => true,
                ]);

                $generation = Generation::create([
                    'prompt' => $url,
                    'status' => 'pending',
                ]);

                GenerateScrapingFiles::dispatch($generation->id, $provider);
            });


        return response()->json([
            'id' => $generation->id,
            'status' => 'pending',
        ]);


    }

    private function checkIfExistInDatabase($name){
        $check = Provider::where("name", "=", $name)->first();

        return $check;
    }

    private function getJson($text){
        $pattern = '
                /
                \{              # { character
                    (?:         # non-capturing group
                        [^{}]   # anything that is not a { or }
                        |       # OR
                        (?R)    # recurses the entire pattern
                    )*          # previous group zero or more times
                \}              # } character
                /x
                ';

        preg_match_all($pattern, $text, $matches);
        return $matches[0];
    }


    public function urlExists($url=NULL){
        if($url == NULL) return false;
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_TIMEOUT, 5);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $data = curl_exec($ch);
        $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        return $httpcode >= 200 && $httpcode < 300;
    }

}
