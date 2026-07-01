<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class ClaudeAgentService
{
    protected string $systemPrompt;

    public function __construct()
    {
        // Get the agent structure from markdown file
        $this->systemPrompt = file_get_contents(
            resource_path('agent/og-manga-scraper.md')
        );
    }

    /**
     * Method to send url and generate scraping files
     * @param  string $url - manga website
     */
    public function generate(string $url): array
    {
        try{
            $response = Http::timeout(300)
                        ->withHeaders([
                            'x-api-key' => config('claude.api_key'),
                            'anthropic-version' => '2023-06-01',
                            'content-type' => 'application/json',
                        ])
                        ->post('https://api.anthropic.com/v1/messages', [
                            'model' => config('claude.model'),
                            'max_tokens' => 100000,

                            'system' => [
                                            [
                                                'type' => 'text',
                                                'text' => $this->systemPrompt,
                                                'cache_control' => [
                                                    'type' => 'ephemeral'
                                                ]
                                            ]
                                        ],

                            'messages' => [
                                [
                                    'role' => 'user',
                                    'content' => $url,
                                ],
                            ],

                            'tools' => [
                                [
                                    'name' => 'generate_files',
                                    'description' => 'Return generated files',

                                    'input_schema' => [
                                        'type' => 'object',
                                        'properties' => [
                                            'files' => [
                                                'type' => 'array',
                                                'items' => [
                                                    'type' => 'object',
                                                    'properties' => [
                                                        'filename' => [
                                                            'type' => 'string'
                                                        ],
                                                        'path' => [
                                                            'type' => 'string'
                                                        ],
                                                        'content' => [
                                                            'type' => 'string'
                                                        ],
                                                    ],
                                                    'required' => [
                                                        'filename',
                                                        'path',
                                                        'content',
                                                    ],
                                                ],
                                            ],
                                        ],
                                        'required' => [
                                            'files',
                                        ],
                                    ],
                                ],
                            ],

                            'tool_choice' => [
                                'type' => 'tool',
                                'name' => 'generate_files',
                            ],
                        ]);

            logger()->info('Status: '.$response->status());
            logger()->info($response->body());

            if ($response->failed()) {
                throw new \Exception($response->body());
            }

            $data = $response->json();

            return $data;


        }catch(\Throwable $e){

            dd([
                'class' => get_class($e),
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            throw $e;
        }

    }
}
