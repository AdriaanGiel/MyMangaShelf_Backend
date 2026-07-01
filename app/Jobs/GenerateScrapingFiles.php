<?php

namespace App\Jobs;

use App\Models\Generation;
use App\Models\Provider;
use App\Models\ScrapingScript;
use App\Services\ClaudeAgentService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Storage;

class GenerateScrapingFiles implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct(public int $generationId, public Provider $provider)
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(ClaudeAgentService $claude): void
    {
        try{
            $generation = Generation::findOrFail(
                $this->generationId
            );

            $generation->update([
                'status' => 'processing'
            ]);

            $result = $claude->generate(
                $generation->prompt
            );

            $generation->update([
                'status' => 'completed',
                'result' => json_encode($result),
            ]);


            $toolUse = collect($result['content'] ?? [])
                ->firstWhere('type', 'tool_use');

            $files = $toolUse['input']['files'];

            foreach($files as $file){

                    ScrapingScript::create([
                        'file' => $file["filename"],
                        'scraping_type_id' => $file["type_id"],
                        "provider_id" => $this->provider->id
                        ]);


                Storage::disk("local")->put("/scripts" . "/" . $file["filename"], $file["content"]);
            }

        }catch (\Throwable $e){

            $generation->update([
                'status' => 'failed',
                'error' => $e->getMessage(),
            ]);
            throw $e;
        }

    }
}
