<p>Dear {{ $patient->name }},</p>
<p>We are pleased to confirm your online consultation with Dr. {{ $doctor->name }}.</p>
<p><b>Appointment Details:</b><br>
- <b>Date & Time:</b> {{ $meetingDateTime }}<br>
- <b>Meeting Link:</b> <a href="{{ $meetingLink }}">{{ $meetingLink }}</a>
</p>
<p>Please click the link above to join your consultation at the scheduled time. If you have any questions or need to reschedule, please reply to this email.</p>
<p>Best regards,<br>{{ $clinicName }} Team</p> 