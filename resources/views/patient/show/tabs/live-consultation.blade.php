<!-- jQuery (required for Toastr) -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<!-- Toastr CSS -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet"/>
<!-- Toastr JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<script>
if (typeof toastr === 'undefined') {
    window.toastr = {
        success: function(msg) { alert(msg); },
        error: function(msg) { alert(msg); }
    };
}
</script>

<div class="tab-content" id="live-consultation">
    <div class="medical-section">
        <div class="stats-grid">
            <div class="card">
                <h3>Total Consultations</h3>
                <div style="font-size: 2rem; font-weight: bold; color: #4A90E2;">{{ $consultationStats['total'] }}</div>
            </div>
            <div class="card">
                <h3>This Month</h3>
                <div style="font-size: 2rem; font-weight: bold; color: #28a745;">{{ $consultationStats['this_month'] }}</div>
            </div>
            <div class="card">
                <h3>Average Duration</h3>
                <div style="font-size: 1.5rem; font-weight: bold;">{{ $consultationStats['average_duration'] > 0 ? round($consultationStats['average_duration']) . ' min' : 'N/A' }}</div>
            </div>
            <div class="card">
                <h3>Next Session</h3>
                <div style="font-size: 1.2rem; font-weight: bold;">{{ $consultationStats['next_session'] ?? 'No upcoming sessions' }}</div>
            </div>
        </div>

        <div class="card">
            <h3>Current Consultation Session</h3>
            <div class="video-call-container">
                @if($activeConsultation)
                    <div style="text-align: center;">
                        <div style="font-size: 4rem; margin-bottom: 1rem;">📹</div>
                        <div style="font-size: 1.2rem;">Active consultation with {{ $activeConsultation->doctor->user->name }}</div>
                        <div style="font-size: 1rem; opacity: 0.7;">Started at {{ $activeConsultation->started_at->format('h:i A') }}</div>
                    </div>
                    <div class="video-controls">
                        <button class="video-btn" style="background: #28a745;" onclick="joinConsultation('{{ $activeConsultation->zoom_join_url }}')">📞 Join</button>
                        <button class="video-btn" style="background: #6c757d;">🎤</button>
                        <button class="video-btn" style="background: #6c757d;">📹</button>
                        <button class="video-btn" style="background: #dc3545;" onclick="endConsultation({{ $activeConsultation->id }})">📞 End</button>
                    </div>
                @else
                    <div style="text-align: center;">
                        <div style="font-size: 4rem; margin-bottom: 1rem;">📹</div>
                        <div style="font-size: 1.2rem;">No active consultation</div>
                        <div style="font-size: 1rem; opacity: 0.7;">Click "Start Consultation" to begin</div>
                    </div>
                    <div class="video-controls">
                        <button class="video-btn" style="background: #6c757d;">📞</button>
                        <button class="video-btn" style="background: #6c757d;">🎤</button>
                        <button class="video-btn" style="background: #6c757d;">📹</button>
                        <button class="video-btn" style="background: #6c757d;">📞</button>
                    </div>
                @endif
            </div>
            <div style="display: flex; gap: 1rem; margin-top: 1rem;">
                <button class="btn btn-success" onclick="showStartConsultationModal()">Start Consultation</button>
                <button class="btn btn-primary" onclick="showScheduleConsultationModal()">Schedule Consultation</button>
                @if($activeConsultation)
                    <button class="btn btn-warning" onclick="joinConsultation('{{ $activeConsultation->zoom_join_url }}')">Join Waiting Room</button>
                @else
                    <button class="btn btn-secondary" disabled>Join Waiting Room</button>
                @endif
            </div>
        </div>

        <div class="table-container">
            <div class="table-title">CONSULTATION HISTORY</div>
            <div class="table-responsive">
                <table class="table table-bordered align-middle">
                    <thead>
                        <tr>
                            <th>Date & Time</th>
                            <th>Doctor</th>
                            <th>Duration</th>
                            <th>Type</th>
                            <th>Status</th>
                            <th>Recording</th>
                            <th>Notes</th>
                            <th>Meeting Link</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($liveConsultations as $consultation)
                            <tr>
                                <td>{{ $consultation->created_at->format('d/m/Y h:i A') }}</td>
                                <td>{{ $consultation->doctor->user->name }}</td>
                                <td>{{ $consultation->getFormattedDuration() }}</td>
                                <td>{{ ucfirst($consultation->consultation_type) }}</td>
                                <td><span class="status-badge {{ $consultation->getStatusBadgeClass() }}">{{ $consultation->getStatusText() }}</span></td>
                                <td>
                                    @if($consultation->recording_url)
                                        <button class="btn btn-primary" style="padding: 0.25rem 0.5rem; font-size: 0.8rem;" onclick="viewRecording('{{ $consultation->recording_url }}')">View</button>
                                    @else
                                        -
                                    @endif
                                </td>
                                <td>
                                    <button class="btn btn-secondary" style="padding: 0.25rem 0.5rem; font-size: 0.8rem;" onclick="viewNotes({{ $consultation->id }})">Notes</button>
                                </td>
                                <td>
                                    @if($consultation->zoom_join_url)
                                        <button class="btn btn-info" style="padding: 0.25rem 0.5rem; font-size: 0.8rem;" onclick="copyMeetingLink('{{ $consultation->zoom_join_url }}')">Copy Link</button>
                                        <button class="btn btn-link" style="padding: 0.25rem 0.5rem; font-size: 0.8rem;" onclick="window.open('{{ $consultation->zoom_join_url }}', '_blank')">Open</button>
                                    @else
                                        -
                                    @endif
                                </td>
                                <td>
                                    @if($consultation->zoom_join_url)
                                        <button class="btn btn-success btn-sm" onclick="sendWhatsApp({{ $consultation->id }})">WhatsApp</button>
                                        <button class="btn btn-primary btn-sm" onclick="sendEmail({{ $consultation->id }})">Email</button>
                                    @else
                                        -
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="9" style="text-align: center; padding: 2rem;">No consultation history found</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Start Consultation Modal -->
<div class="modal fade" id="startConsultationModal" tabindex="-1" aria-labelledby="startConsultationModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="startConsultationModalLabel">Start Instant Consultation</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="startConsultationForm">
                    <input type="hidden" name="patient_id" value="{{ $patient->id }}">
                    <div class="mb-3">
                        <label for="consultation_type" class="form-label">Consultation Type</label>
                        <select class="form-select" id="consultation_type" name="consultation_type" required>
                            <option value="instant">Instant Consultation</option>
                            <option value="follow-up">Follow-up</option>
                            <option value="emergency">Emergency Consultation</option>
                            <option value="second-opinion">Second Opinion</option>
                            <option value="routine">Routine Checkup</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="notes" class="form-label">Notes</label>
                        <textarea class="form-control" id="notes" name="notes" rows="3" placeholder="Brief description of symptoms or reason for consultation"></textarea>
                    </div>
                    <div class="mb-3">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="is_emergency" name="is_emergency" value="1">
                            <label class="form-check-label" for="is_emergency">
                                Emergency Consultation
                            </label>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-success" onclick="startInstantConsultation()">Start Consultation</button>
            </div>
        </div>
    </div>
</div>

<!-- Schedule Consultation Modal -->
<div class="modal fade" id="scheduleConsultationModal" tabindex="-1" aria-labelledby="scheduleConsultationModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="scheduleConsultationModalLabel">Schedule Consultation</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="scheduleConsultationForm">
                    <div class="mb-3">
                        <label for="schedule_consultation_type" class="form-label">Consultation Type</label>
                        <select class="form-select" id="schedule_consultation_type" name="consultation_type" required>
                            <option value="follow-up">Follow-up</option>
                            <option value="initial">Initial Consultation</option>
                            <option value="emergency">Emergency Consultation</option>
                            <option value="second-opinion">Second Opinion</option>
                            <option value="routine">Routine Checkup</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="scheduled_at" class="form-label">Date & Time</label>
                        <input type="datetime-local" class="form-control" id="scheduled_at" name="scheduled_at" required>
                    </div>
                    <div class="mb-3">
                        <label for="duration_minutes" class="form-label">Duration (minutes)</label>
                        <select class="form-select" id="duration_minutes" name="duration_minutes" required>
                            <option value="15">15 minutes</option>
                            <option value="30" selected>30 minutes</option>
                            <option value="45">45 minutes</option>
                            <option value="60">1 hour</option>
                            <option value="90">1.5 hours</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="schedule_notes" class="form-label">Notes</label>
                        <textarea class="form-control" id="schedule_notes" name="notes" rows="3" placeholder="Brief description of symptoms or reason for consultation"></textarea>
                    </div>
                    <div class="mb-3">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="schedule_is_emergency" name="is_emergency" value="1">
                            <label class="form-check-label" for="schedule_is_emergency">
                                Emergency Consultation
                            </label>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" onclick="scheduleConsultation()">Schedule Consultation</button>
            </div>
        </div>
    </div>
</div>

<!-- Notes Modal -->
<div class="modal fade" id="notesModal" tabindex="-1" aria-labelledby="notesModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="notesModalLabel">Consultation Notes</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div id="allNotesSection" style="margin-bottom: 1rem;">
                    <div style="font-weight: bold;">Previous Notes:</div>
                    <div id="notesList"></div>
                    <hr/>
                </div>
                <form id="addNoteForm">
                    <input type="hidden" id="add_note_consultation_id" name="consultation_id">
                    <div class="mb-3">
                        <label for="add_note_notes" class="form-label">Notes</label>
                        <textarea class="form-control" id="add_note_notes" name="notes" rows="3"></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="add_note_diagnosis" class="form-label">Diagnosis</label>
                        <textarea class="form-control" id="add_note_diagnosis" name="diagnosis" rows="2"></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="add_note_prescription" class="form-label">Prescription</label>
                        <textarea class="form-control" id="add_note_prescription" name="prescription" rows="2"></textarea>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" onclick="addNote()">Add Note</button>
            </div>
        </div>
    </div>
</div>

<style>
@media (max-width: 768px) {
    .table-responsive { font-size: 0.95em; }
    .table-responsive th, .table-responsive td { padding: 0.4rem 0.3rem; }
}
</style>

<script>
function showStartConsultationModal() {
    const modal = new bootstrap.Modal(document.getElementById('startConsultationModal'));
    modal.show();
}

function showScheduleConsultationModal() {
    const modal = new bootstrap.Modal(document.getElementById('scheduleConsultationModal'));
    modal.show();
}

function startInstantConsultation() {
    const form = document.getElementById('startConsultationForm');
    const formData = new FormData(form);
    const data = Object.fromEntries(formData.entries());

    // Convert checkbox to boolean
    data.is_emergency = data.is_emergency === '1';

    fetch('/doctor/live-consultations/start-instant', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify(data)
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            toastr.success(data.message);
            bootstrap.Modal.getInstance(document.getElementById('startConsultationModal')).hide();
            setTimeout(() => location.reload(), 1500);
        } else {
            toastr.error(data.message);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        toastr.error('An error occurred while starting the consultation');
    });
}

function scheduleConsultation() {
    const form = document.getElementById('scheduleConsultationForm');
    const formData = new FormData(form);
    const data = Object.fromEntries(formData.entries());

    // Convert checkbox to boolean
    data.is_emergency = data.is_emergency === '1';

    fetch('/doctor/live-consultations/schedule', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify(data)
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            toastr.success(data.message);
            bootstrap.Modal.getInstance(document.getElementById('scheduleConsultationModal')).hide();
            setTimeout(() => location.reload(), 1500);
        } else {
            toastr.error(data.message);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        toastr.error('An error occurred while scheduling the consultation');
    });
}

function joinConsultation(joinUrl) {
    if (joinUrl) {
        window.open(joinUrl, '_blank');
    } else {
        toastr.error('No join URL available');
    }
}

function endConsultation(consultationId) {
    if (confirm('Are you sure you want to end this consultation?')) {
        fetch(`/doctor/live-consultations/${consultationId}/end`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                toastr.success(data.message);
                setTimeout(() => location.reload(), 1500);
            } else {
                toastr.error(data.message);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            toastr.error('An error occurred while ending the consultation');
        });
    }
}

function viewNotes(consultationId) {
    document.getElementById('add_note_consultation_id').value = consultationId;
    // Clear add form
    document.getElementById('add_note_notes').value = '';
    document.getElementById('add_note_diagnosis').value = '';
    document.getElementById('add_note_prescription').value = '';
    // Load all notes via AJAX
    fetch(`/doctor/live-consultations/${consultationId}/notes`)
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            renderNotesList(data.notes, consultationId);
            const modal = new bootstrap.Modal(document.getElementById('notesModal'));
            modal.show();
        } else {
            toastr.error('Failed to load notes');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        toastr.error('An error occurred while loading notes');
    });
}

function renderNotesList(notes, consultationId) {
    const notesList = document.getElementById('notesList');
    if (!notes.length) {
        notesList.innerHTML = '<div class="text-muted">No previous notes.</div>';
        return;
    }
    notesList.innerHTML = notes.map(note => `
        <div class="card mb-2" id="note_${note.id}">
            <div class="card-body">
                <div style="font-size: 0.9rem; color: #888;">
                    <b>${note.author ? note.author.name : 'Unknown'}</b> &middot; ${new Date(note.created_at).toLocaleString()}
                </div>
                <div class="mb-1"><b>Notes:</b> <span class="note-text">${escapeHtml(note.notes || '-')}</span></div>
                <div class="mb-1"><b>Diagnosis:</b> <span class="diagnosis-text">${escapeHtml(note.diagnosis || '-')}</span></div>
                <div class="mb-1"><b>Prescription:</b> <span class="prescription-text">${escapeHtml(note.prescription || '-')}</span></div>
                <div>
                    <button class="btn btn-sm btn-outline-primary" onclick="editNote(${note.id})">Edit</button>
                    <button class="btn btn-sm btn-outline-danger" onclick="deleteNote(${note.id}, ${consultationId})">Delete</button>
                </div>
            </div>
        </div>
    `).join('');
}

function addNote() {
    const consultationId = document.getElementById('add_note_consultation_id').value;
    const form = document.getElementById('addNoteForm');
    const formData = new FormData(form);
    fetch(`/doctor/live-consultations/${consultationId}/notes`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            toastr.success('Note added');
            viewNotes(consultationId);
        } else {
            toastr.error('Failed to add note');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        toastr.error('An error occurred while adding note');
    });
}

function editNote(noteId) {
    const noteCard = document.getElementById(`note_${noteId}`);
    const noteText = noteCard.querySelector('.note-text').textContent;
    const diagnosisText = noteCard.querySelector('.diagnosis-text').textContent;
    const prescriptionText = noteCard.querySelector('.prescription-text').textContent;
    noteCard.querySelector('.card-body').innerHTML = `
        <form id="editNoteForm_${noteId}">
            <div class="mb-1"><b>Notes:</b> <textarea class="form-control" name="notes" rows="2">${noteText}</textarea></div>
            <div class="mb-1"><b>Diagnosis:</b> <textarea class="form-control" name="diagnosis" rows="1">${diagnosisText}</textarea></div>
            <div class="mb-1"><b>Prescription:</b> <textarea class="form-control" name="prescription" rows="1">${prescriptionText}</textarea></div>
            <button type="button" class="btn btn-sm btn-success" onclick="saveEditNote(${noteId})">Save</button>
            <button type="button" class="btn btn-sm btn-secondary" onclick="viewNotes(document.getElementById('add_note_consultation_id').value)">Cancel</button>
        </form>
    `;
}

function saveEditNote(noteId) {
    const form = document.getElementById(`editNoteForm_${noteId}`);
    const formData = new FormData(form);
    fetch(`/doctor/live-consultations/notes/${noteId}`, {
        method: 'PUT',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            toastr.success('Note updated');
            viewNotes(document.getElementById('add_note_consultation_id').value);
        } else {
            toastr.error('Failed to update note');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        toastr.error('An error occurred while updating note');
    });
}

function deleteNote(noteId, consultationId) {
    if (!confirm('Are you sure you want to delete this note?')) return;
    fetch(`/doctor/live-consultations/notes/${noteId}`, {
        method: 'DELETE',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            toastr.success('Note deleted');
            viewNotes(consultationId);
        } else {
            toastr.error('Failed to delete note');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        toastr.error('An error occurred while deleting note');
    });
}

function escapeHtml(text) {
    if (!text) return '';
    return text.replace(/[&<>'"]/g, function (c) {
        return {'&':'&amp;','<':'&lt;','>':'&gt;','\'':'&#39;','"':'&quot;'}[c];
    });
}

function copyMeetingLink(link) {
    navigator.clipboard.writeText(link).then(function() {
        toastr.success('Meeting link copied to clipboard');
    }, function() {
        toastr.error('Failed to copy meeting link');
    });
}

function viewRecording(recordingUrl) {
    if (recordingUrl) {
        window.open(recordingUrl, '_blank');
    } else {
        toastr.error('No recording available');
    }
}

function sendWhatsApp(consultationId) {
    fetch(`/doctor/live-consultations/${consultationId}/send-whatsapp`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success && data.url) {
            toastr.success('WhatsApp message ready');
            window.open(data.url, '_blank');
        } else {
            toastr.error('Failed to prepare WhatsApp message');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        toastr.error('An error occurred while preparing WhatsApp message');
    });
}

function sendEmail(consultationId) {
    fetch(`/doctor/live-consultations/${consultationId}/send-email`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            toastr.success('Email sent to patient');
        } else {
            toastr.error(data.message || 'Failed to send email');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        toastr.error('An error occurred while sending email');
    });
}

// Set minimum datetime for scheduling (current time + 1 hour)
document.addEventListener('DOMContentLoaded', function() {
    const scheduledAtInput = document.getElementById('scheduled_at');
    if (scheduledAtInput) {
        const now = new Date();
        now.setHours(now.getHours() + 1);
        scheduledAtInput.min = now.toISOString().slice(0, 16);
    }
});
</script>

