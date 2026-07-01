<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Client\RequestException;
use RuntimeException;

class ClaudeAgent
{
    protected string $apiKey;
    protected int $timeout;
    protected array $betaHeaders;
    protected string $baseUrl;
    protected ?string $agentId;
    protected string $defaultModel;

    public function __construct()
    {
        $this->apiKey = config('anthropic.api_key');
        if (empty($this->apiKey)) {
            throw new RuntimeException('Anthropic API key is not configured. Please set ANTHROPIC_API_KEY.');
        }

        $this->timeout = config('anthropic.request_timeout', 30);
        $this->betaHeaders = config('anthropic.beta', []);
        $this->baseUrl = env('ANTHROPIC_API_URL', 'https://api.anthropic.com');
        $this->agentId = config('anthropic.agent_id');
        $this->defaultModel = env('ANTHROPIC_DEFAULT_MODEL', 'claude-3.5');
    }

    /**
     * Send a prompt to Claude and return the assistant response.
     *
     * @param string $prompt
     * @param array<string,mixed> $options
     * @return string
     * @throws RequestException
     * @throws RuntimeException
     */
    public function sendPrompt(string $prompt, array $options = []): string
    {
        $data = $this->sendPromptRaw($prompt, $options);

        if (isset($data['completion'])) {
            return (string) $data['completion'];
        }

        if (isset($data['output'])) {
            if (is_string($data['output'])) {
                return $data['output'];
            }
            if (isset($data['output'][0]['content'][0]['text'])) {
                return (string) $data['output'][0]['content'][0]['text'];
            }
        }

        if (isset($data['choices'][0]['text'])) {
            return (string) $data['choices'][0]['text'];
        }

        if (isset($data['result'])) {
            return (string) $data['result'];
        }

        throw new RuntimeException('Unexpected Anthropic response: ' . json_encode($data));
    }

    public function sendPromptRaw(string $prompt, array $options = []): array
    {
        $model = $options['model'] ?? $this->defaultModel;
        $temperature = $options['temperature'] ?? 0.2;
        $maxTokens = $options['max_tokens_to_sample'] ?? 1500;
        $stop = $options['stop'] ?? ["\n\nHuman:"];
        $instructions = $options['instructions'] ?? null;
        $agentId = $options['agent_id'] ?? $this->agentId;

        if ($agentId) {
            $endpoint = sprintf('%s/v1/agents/%s/responses', rtrim($this->baseUrl, '/'), $agentId);
            $payload = array_merge([
                'input' => $this->buildPrompt($prompt, $instructions),
                'temperature' => $temperature,
                'max_tokens_to_sample' => $maxTokens,
                'stop' => $stop,
            ], $options['payload'] ?? []);
        } else {
            $endpoint = rtrim($this->baseUrl, '/') . '/v1/complete';
            $payload = array_merge([
                'model' => $model,
                'prompt' => $this->buildPrompt($prompt, $instructions),
                'temperature' => $temperature,
                'max_tokens_to_sample' => $maxTokens,
                'stop' => $stop,
            ], $options['payload'] ?? []);
        }

        $response = Http::withHeaders($this->buildHeaders())
            ->timeout($this->timeout)
            ->post($endpoint, $payload);

        $response->throw();

        return $response->json();
    }

    public function saveFilesFromAgentResponse(array $response, string $directory = 'private/scripts'): array
    {
        $files = $this->extractFileDefinitions($response);
        if (empty($files)) {
            throw new RuntimeException('No files were found in the Anthropic agent response.');
        }

        $saved = [];
        foreach ($files as $file) {
            $filename = $this->sanitizeFilename($file['name'] ?? $file['filename'] ?? $file['url'] ?? 'file-' . uniqid() . '.txt');
            $content = $this->resolveFileContent($file);
            $path = trim($directory, '/') . '/' . $filename;
            Storage::disk('local')->put($path, $content);
            $saved[] = $path;
        }

        return $saved;
    }

    protected function buildHeaders(): array
    {
        $headers = [
            'Content-Type' => 'application/json',
            'X-API-Key' => $this->apiKey,
            'Anthropic-Version' => '2024-12-17',
        ];

        if (!empty($this->betaHeaders)) {
            $headers['anthropic-beta'] = implode(',', $this->betaHeaders);
        }

        return $headers;
    }

    protected function buildPrompt(string $prompt, ?string $instructions = null): string
    {
        if ($instructions) {
            return trim("System: {$instructions}\n\nHuman: {$prompt}\n\nAssistant:");
        }

        return "Human: {$prompt}\n\nAssistant:";
    }
}
