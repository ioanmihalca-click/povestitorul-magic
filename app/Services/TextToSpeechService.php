<?php

namespace App\Services;

use Illuminate\Support\Str;
use OpenAI\Laravel\Facades\OpenAI;
use Illuminate\Support\Facades\Log;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;

class TextToSpeechService
{
    public function generateAudio(string $text): ?string
    {
        try {
            // Generate audio using OpenAI TTS
            $response = OpenAI::audio()->speech([
                'model' => 'tts-1',
                'voice' => 'nova',
                'input' => $text,
            ]);

            // Save the audio file temporarily
            $tempFile = storage_path('app/temp/') . Str::random(40) . '.mp3';
            file_put_contents($tempFile, $response);

            // Upload to Cloudinary
            $uploadedAudio = Cloudinary::uploadFile($tempFile, [
                'folder' => 'povestitorul_magic/audio',
                'public_id' => 'story_audio_' . time() . '_' . Str::random(10),
                'resource_type' => 'video' // Cloudinary uses 'video' type for audio files
            ]);

            // Delete temporary file
            unlink($tempFile);

            return $uploadedAudio->getSecurePath();
        } catch (\Exception $e) {
            Log::error('Error generating audio: ' . $e->getMessage());
            return null;
        }
    }
}