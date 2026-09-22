<?php

namespace App\Services\AI;

use App\Models\RepairTicket;
use OpenAI\Exceptions\RateLimitException;
use OpenAI\Laravel\Facades\OpenAI;
use Illuminate\Support\Facades\Http;


class AIRepairRequestService
{


    public function analyzeRepairLog(
        RepairTicket $ticket,
        ?string $new_log,
        string $new_status,
    ): array {
        $newLog = trim($new_log ?? '');

        $previousLogs = $ticket->logs
            ->pluck('message')
            ->filter()
            ->implode("\n");

        $oldStatus = $ticket->status;

        $newLogPrompt = $newLog === ''
            ? "No new technician note was provided. Generate the update using only the previous customer-visible logs and the status change."
            : "New technician note:\n{$newLog}";

        $prompt = "
            You are an AI assistant for a professional phone repair shop.
            Your task is to convert an internal technician note into a short, clear, and professional update for the customer.
            Context:
            Initial customer issue:
            {$ticket->issue_description}
            Previous customer-visible repair logs (oldest to newest):
            {$previousLogs}
            Previous repair status:
            {$oldStatus}
            New repair status:
            {$new_status}
            ,
            {$newLogPrompt}
            Instructions:
            - Understand the complete repair history before writing the message.
            - Focus ONLY on the latest progress.
            - Do NOT repeat information already communicated in previous logs unless it is necessary for understanding the current update.
            - Mention the status change naturally if it helps the customer understand the progress.
            - Use simple, non-technical language.
            - Never invent information or make assumptions.
            - Do not promise repair completion dates unless explicitly mentioned.
            - Do not expose internal notes, diagnostic procedures, or technical uncertainty.
            - If the device is still under diagnosis, explain that the inspection is continuing.
            - If parts are required, explain that the repair is waiting for the necessary parts.
            - If the motherboard is being repaired, explain it in customer-friendly language.
            - Keep the tone professional, reassuring, and concise.
            - Maximum 2–3 short sentences (about 40-60 words).
            - Return ONLY the final customer message with no title, quotation marks, or additional explanation.
            ";
        $response = Http::withToken(config('services.groq.key'))
            ->post('https://api.groq.com/openai/v1/chat/completions', [
                'model' => 'openai/gpt-oss-120b',
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
                'model' => 'openai/gpt-oss-120b',

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
}
