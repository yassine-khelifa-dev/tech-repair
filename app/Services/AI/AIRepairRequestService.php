<?php

namespace App\Services\AI;

use OpenAI\Exceptions\RateLimitException;
use OpenAI\Laravel\Facades\OpenAI;
use Illuminate\Support\Facades\Http;


class AIRepairRequestService
{


    public function analyzeRepairRequest(string $issueDescription): array
    {
       $prompt = "
You are a professional smartphone repair technician.

Write a short, friendly and professional reply to the customer based on their repair request.

Rules:
- Thank the customer for contacting us.
- Briefly explain the most likely causes of the issue.
- Clearly mention that these are only possible causes and that the exact problem can only be confirmed after inspecting the device.
- Recommend bringing the device to our repair shop for a professional diagnosis.
- If the issue may involve the motherboard, mention that motherboard repairs usually take between 3 and 15 business days because the device may need to be sent to our laboratory.
- If the issue is likely caused by a replaceable component (battery, charging port, screen, speaker, camera, etc.), mention that repairs are usually completed within 24 hours, depending on parts availability.
- Keep the message reassuring and easy to understand.
- Do not use bullet points.
- Do not use Markdown.
- Do not mention technical details that could confuse the customer.
- Return ONLY the reply text.
- The reply must not exceed 100 words.

Customer repair request:

{$issueDescription}
";

        $response = Http::withToken(config('services.groq.key'))
            ->post('https://api.groq.com/openai/v1/chat/completions', [
                'model' => 'llama-3.3-70b-versatile',
                'messages' => [
                    [
                        'role' => 'system',
                        'content' => 'You are a professional phone repair assistant.',
                    ],
                    [
                        'role' => 'user',
                        'content' => $prompt,
                    ],
                ],
                'temperature' => 0.2,
            ]);

        if ($response->failed()) {
            return [
                'success' => false,
                'message' => 'AI service is unavailable.',
                'error' => $response->json(),
            ];
        }

        $content = $response->json('choices.0.message.content');

        $content = trim($content);

        $content = preg_replace('/^```json/', '', $content);
        $content = preg_replace('/^```/', '', $content);
        $content = preg_replace('/```$/', '', $content);

        $content = trim($content);


        return [
            'success' => true,
            'response' => $content,
        ];
    }


    public function ask(string $issue_description)
    {
        try {
            $response = OpenAI::chat()->create([
                'model' => 'gpt-4o-mini',
                'messages' => [
                    [
                        'role' => 'system',
                        'content' => '
                        You are an experienced smartphone repair technician.
                        Your task is to help another technician review a customer repair request.
                        Return your answer in JSON.
                        The JSON must contain:
                        - summary: a short summary of the customer problem.
                        - possible_causes: an array of possible hardware or software causes.
                        - recommended_checks: an array describing what the technician should inspect first.
                        - suggested_reply: a professional message that can be sent to the customer.
                        Do not invent information that is not mentioned by the customer.
                        '
                    ],
                    [
                        'role' => 'user',
                        'content' => $issue_description
                    ]
                ]
            ]);
            return $response;
        } catch (RateLimitException $e) {
            return 'AI service is temporarily unavailable because the rate limit was exceeded. Please try again later.';
        } catch (\Throwable $e) {
            return 'AI analysis failed. Please review the request manually.';
        }
    }
}
