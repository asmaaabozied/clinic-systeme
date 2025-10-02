<?php

namespace App\Http\Controllers;

use App\Models\LiveConsultation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ZoomWebhookController extends Controller
{
    public function handleWebhook(Request $request)
    {
        $payload = $request->all();
        $event = $payload['event'] ?? null;

        Log::info('Zoom webhook received', ['event' => $event, 'payload' => $payload]);

        switch ($event) {
            case 'recording.completed':
                return $this->handleRecordingCompleted($payload);
            
            case 'meeting.ended':
                return $this->handleMeetingEnded($payload);
            
            case 'meeting.started':
                return $this->handleMeetingStarted($payload);
            
            default:
                Log::info('Unhandled Zoom webhook event', ['event' => $event]);
                return response()->json(['status' => 'ignored']);
        }
    }

    private function handleRecordingCompleted($payload)
    {
        $meetingId = $payload['object']['id'] ?? null;
        $recordingFiles = $payload['object']['recording_files'] ?? [];

        if (!$meetingId) {
            Log::error('No meeting ID in recording completed webhook');
            return response()->json(['status' => 'error'], 400);
        }

        // Find consultation by Zoom meeting ID
        $consultation = LiveConsultation::where('zoom_meeting_id', $meetingId)->first();

        if (!$consultation) {
            Log::warning('No consultation found for meeting ID: ' . $meetingId);
            return response()->json(['status' => 'not_found']);
        }

        // Find the best quality recording file
        $recordingUrl = null;
        $recordingId = null;

        foreach ($recordingFiles as $file) {
            if ($file['file_type'] === 'MP4' && $file['recording_type'] === 'shared_screen_with_speaker_view') {
                $recordingUrl = $file['download_url'] ?? $file['play_url'];
                $recordingId = $file['id'];
                break;
            }
        }

        // If no shared screen recording, get any MP4 file
        if (!$recordingUrl) {
            foreach ($recordingFiles as $file) {
                if ($file['file_type'] === 'MP4') {
                    $recordingUrl = $file['download_url'] ?? $file['play_url'];
                    $recordingId = $file['id'];
                    break;
                }
            }
        }

        if ($recordingUrl) {
            $consultation->update([
                'is_recorded' => true,
                'recording_url' => $recordingUrl,
                'recording_id' => $recordingId,
            ]);

            Log::info('Updated consultation with recording', [
                'consultation_id' => $consultation->id,
                'recording_url' => $recordingUrl
            ]);
        }

        return response()->json(['status' => 'success']);
    }

    private function handleMeetingEnded($payload)
    {
        $meetingId = $payload['object']['id'] ?? null;

        if (!$meetingId) {
            Log::error('No meeting ID in meeting ended webhook');
            return response()->json(['status' => 'error'], 400);
        }

        $consultation = LiveConsultation::where('zoom_meeting_id', $meetingId)
            ->where('status', 'active')
            ->first();

        if ($consultation) {
            $consultation->endConsultation();
            Log::info('Meeting ended, consultation marked as completed', [
                'consultation_id' => $consultation->id
            ]);
        }

        return response()->json(['status' => 'success']);
    }

    private function handleMeetingStarted($payload)
    {
        $meetingId = $payload['object']['id'] ?? null;

        if (!$meetingId) {
            Log::error('No meeting ID in meeting started webhook');
            return response()->json(['status' => 'error'], 400);
        }

        $consultation = LiveConsultation::where('zoom_meeting_id', $meetingId)
            ->where('status', 'scheduled')
            ->first();

        if ($consultation) {
            $consultation->startConsultation();
            Log::info('Meeting started, consultation marked as active', [
                'consultation_id' => $consultation->id
            ]);
        }

        return response()->json(['status' => 'success']);
    }
} 