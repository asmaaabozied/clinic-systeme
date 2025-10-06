<div class="tab-content" id="timeline">
    <div class="medical-section">
        <div class="card">
            <h3>Patient Medical Timeline</h3>
            <div class="timeline">
                <div class="timeline-item">
                    <div class="timeline-date">06/05/2025 - 08:30 PM</div>
                    <div class="timeline-title">Tooth Extraction Surgery</div>
                    <div>Successfully completed tooth extraction procedure. Patient tolerated procedure well. Post-operative instructions provided.</div>
                </div>

                <div class="timeline-item">
                    <div class="timeline-date">06/05/2025 - 03:00 PM</div>
                    <div class="timeline-title">Live Consultation</div>
                    <div>Follow-up consultation with Dr. Sonia Bush. Discussed surgery preparation and post-operative care. Patient cleared for surgery.</div>
                </div>

                <div class="timeline-item">
                    <div class="timeline-date">05/05/2025 - 09:00 AM</div>
                    <div class="timeline-title">Lab Results Available</div>
                    <div>Complete Blood Count results received. Hemoglobin: 12.5 g/dL (Normal), WBC: 11,200/μL (Slightly elevated), Platelets: Normal.</div>
                </div>

                <div class="timeline-item">
                    <div class="timeline-date">04/05/2025 - 10:30 AM</div>
                    <div class="timeline-title">Typhoid Test - Positive</div>
                    <div>Typhoid IgM test returned positive. Treatment plan adjusted. Antibiotic therapy initiated.</div>
                </div>

                <div class="timeline-item">
                    <div class="timeline-date">01/05/2025 - 02:00 PM</div>
                    <div class="timeline-title">Medication Started</div>
                    <div>Started on Alprovit (1 tablet twice daily) and BICASOL (0.5 tablet once daily). Patient education provided on medication compliance.</div>
                </div>

                <div class="timeline-item">
                    <div class="timeline-date">28/04/2025 - 10:30 AM</div>
                    <div class="timeline-title">Initial Consultation</div>
                    <div>Patient presented with complaints of stomach pain and general malaise. Physical examination conducted. Lab tests ordered.</div>
                </div>

                <div class="timeline-item">
                    <div class="timeline-date">15/04/2025 - 02:00 PM</div>
                    <div class="timeline-title">Emergency Visit</div>
                    <div>Patient brought to emergency department with severe abdominal pain. Diagnosed with acute gastritis. Emergency treatment provided.</div>
                </div>

                <div class="timeline-item">
                    <div class="timeline-date">10/04/2025 - 09:00 AM</div>
                    <div class="timeline-title">Patient Registration</div>
                    <div>New patient registered in hospital system. Medical history documented. Insurance verification completed.</div>
                </div>
            </div>
        </div>

        <div class="card">
            <h3>Add Timeline Entry</h3>
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; margin-top: 1rem;">
                <div class="form-group">
                    <label class="form-label">Entry Type</label>
                    <select class="form-input">
                        <option>Consultation</option>
                        <option>Surgery</option>
                        <option>Lab Result</option>
                        <option>Medication</option>
                        <option>Emergency</option>
                        <option>Other</option>
                    </select>
                </div>
                <div class="form-group">
                    <label class="form-label">Date & Time</label>
                    <input type="datetime-local" class="form-input">
                </div>
            </div>
            <div class="form-group" style="margin-top: 1rem;">
                <label class="form-label">Title</label>
                <input type="text" class="form-input" placeholder="Enter timeline entry title">
            </div>
            <div class="form-group">
                <label class="form-label">Description</label>
                <textarea class="form-input" rows="3" placeholder="Enter detailed description of the event"></textarea>
            </div>
            <button class="btn btn-primary" style="margin-top: 1rem;">Add Entry</button>
        </div>
    </div>
</div>
