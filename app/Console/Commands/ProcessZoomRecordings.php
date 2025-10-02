<?php

namespace App\Console\Commands;

use App\Models\LiveConsultation;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class ProcessZoomRecordings extends Command
{
    protected $signature = 'zoom:process-recordings';
    protected $description = 'Process Zoom recording webhooks and update consultation records';

    public function handle()
    {
        $this->info('Processing Zoom recordings...');

        // Get consultations that might have recordings
        $consultations = LiveConsultation::where('status', 'completed')
            ->where('is_recorded', false)
            ->whereNotNull('zoom_meeting_id')
            ->get();

        foreach ($consultations as $consultation) {
            $this->processConsultationRecording($consultation);
        }

        $this->info('Zoom recordings processing completed.');
    }

    private function processConsultationRecording(LiveConsultation $consultation)
    {
        try {
            // In a real implementation, you would:
            // 1. Call Zoom API to get recording details for the meeting
            // 2. Download or get the recording URL
            // 3. Update the consultation record

            // For now, we'll simulate this process
            $this->info("Processing recording for consultation ID: {$consultation->id}");

            // Simulate API call delay
            sleep(1);

            // Update consultation with recording info (simulated)
            $consultation->update([
                'is_recorded' => true,
                'recording_url' => 'https://zoom.us/recording/' . $consultation->zoom_meeting_id,
                'recording_id' => 'rec_' . $consultation->zoom_meeting_id,
            ]);

            $this->info("Updated consultation {$consultation->id} with recording info");

        } catch (\Exception $e) {
            Log::error("Error processing recording for consultation {$consultation->id}: " . $e->getMessage());
            $this->error("Error processing consultation {$consultation->id}: " . $e->getMessage());
        }
    }
} 