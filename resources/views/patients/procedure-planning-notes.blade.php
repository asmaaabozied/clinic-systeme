@extends('layouts.admin')

@section('content')
<style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, sans-serif;
            background-color: #f8f9fa;
            color: #333;
            line-height: 1.6;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }

        .header {
            background: white;
            padding: 20px;
            border-radius: 12px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            margin-bottom: 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .header h1 {
            color: #2c3e50;
            font-size: 24px;
            font-weight: 600;
        }

        .patient-info {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .patient-avatar {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            background-color: #e9ecef;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            color: #6c757d;
        }

        .main-content {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
        }

        .card {
            background: white;
            border-radius: 12px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            overflow: hidden;
        }

        .card-header {
            background: #f8f9fa;
            padding: 15px 20px;
            border-bottom: 1px solid #e9ecef;
            font-weight: 600;
            color: #2c3e50;
        }

        .card-body {
            padding: 20px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            margin-bottom: 5px;
            font-weight: 500;
            color: #495057;
        }

        .form-control {
            width: 100%;
            padding: 10px 12px;
            border: 1px solid #ced4da;
            border-radius: 6px;
            font-size: 14px;
            transition: border-color 0.3s ease;
        }

        .form-control:focus {
            outline: none;
            border-color: #4285f4;
            box-shadow: 0 0 0 2px rgba(66, 133, 244, 0.2);
        }

        textarea.form-control {
            resize: vertical;
            min-height: 100px;
        }

        .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 15px;
        }

        .btn {
            padding: 10px 20px;
            border: none;
            border-radius: 6px;
            font-size: 14px;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-block;
            text-align: center;
        }

        .btn-primary {
            background-color: #4285f4;
            color: white;
        }

        .btn-primary:hover {
            background-color: #3367d6;
        }

        .btn-secondary {
            background-color: #6c757d;
            color: white;
        }

        .btn-secondary:hover {
            background-color: #5a6268;
        }

        .btn-outline {
            background-color: transparent;
            color: #4285f4;
            border: 1px solid #4285f4;
        }

        .btn-outline:hover {
            background-color: #4285f4;
            color: white;
        }

        .btn-group {
            display: flex;
            gap: 10px;
            margin-top: 20px;
        }

        .template-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 10px;
        }

        .template-item {
            padding: 15px;
            border: 1px solid #e9ecef;
            border-radius: 8px;
            cursor: pointer;
            transition: all 0.3s ease;
            text-align: center;
        }

        .template-item:hover {
            border-color: #4285f4;
            background-color: #f8f9ff;
        }

        .template-item.active {
            border-color: #4285f4;
            background-color: #e3f2fd;
        }

        .risk-assessment {
            background: #fff3cd;
            border: 1px solid #ffeaa7;
            border-radius: 8px;
            padding: 15px;
            margin-bottom: 20px;
        }

        .risk-assessment h4 {
            color: #856404;
            margin-bottom: 10px;
        }

        .risk-level {
            display: inline-block;
            padding: 4px 8px;
            border-radius: 4px;
            font-size: 12px;
            font-weight: 500;
        }

        .risk-low { background-color: #d4edda; color: #155724; }
        .risk-medium { background-color: #fff3cd; color: #856404; }
        .risk-high { background-color: #f8d7da; color: #721c24; }

        .notes-section {
            grid-column: 1 / -1;
        }

        .notes-tabs {
            display: flex;
            border-bottom: 1px solid #e9ecef;
            margin-bottom: 20px;
        }

        .notes-tab {
            padding: 10px 20px;
            cursor: pointer;
            border-bottom: 2px solid transparent;
            transition: all 0.3s ease;
        }

        .notes-tab.active {
            border-bottom-color: #4285f4;
            color: #4285f4;
        }

        .tab-content {
            display: none;
        }

        .tab-content.active {
            display: block;
        }

        .attachment-area {
            border: 2px dashed #ced4da;
            border-radius: 8px;
            padding: 30px;
            text-align: center;
            margin-bottom: 20px;
            transition: all 0.3s ease;
        }

        .attachment-area:hover {
            border-color: #4285f4;
            background-color: #f8f9ff;
        }

        .attachment-list {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
        }

        .attachment-item {
            background: #f8f9fa;
            padding: 8px 12px;
            border-radius: 6px;
            font-size: 12px;
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .status-indicator {
            display: inline-block;
            width: 8px;
            height: 8px;
            border-radius: 50%;
            margin-left: 10px;
        }

        .status-draft { background-color: #ffc107; }
        .status-approved { background-color: #28a745; }
        .status-review { background-color: #17a2b8; }

        @media (max-width: 768px) {
            .main-content {
                grid-template-columns: 1fr;
            }
            
            .form-row {
                grid-template-columns: 1fr;
            }
            
            .template-grid {
                grid-template-columns: 1fr;
            }
        }

</style>
    <div class="container">
        <div class="header">
            <h1>Procedure Planning & Notes</h1>
            <div class="patient-info">
                <div class="patient-avatar">JS</div>
                <div>
                    <div><strong>John Smith</strong></div>
                    <div style="font-size: 14px; color: #6c757d;">Age 45 • DOB: 02/14/1979</div>
                </div>
            </div>
        </div>

        <div class="main-content">
            <div class="card">
                <div class="card-header">Procedure Details</div>
                <div class="card-body">
                    <div class="form-group">
                        <label for="procedure-type">Procedure Type</label>
                        <select id="procedure-type" class="form-control">
                            <option value="">Select Procedure</option>
                            <option value="rhinoplasty">Rhinoplasty</option>
                            <option value="facelift">Facelift</option>
                            <option value="breast-augmentation">Breast Augmentation</option>
                            <option value="liposuction">Liposuction</option>
                            <option value="tummy-tuck">Tummy Tuck</option>
                            <option value="blepharoplasty">Blepharoplasty</option>
                            <option value="other">Other</option>
                        </select>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label for="scheduled-date">Scheduled Date</label>
                            <input type="date" id="scheduled-date" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="estimated-duration">Est. Duration (hours)</label>
                            <input type="number" id="estimated-duration" class="form-control" step="0.5" min="0.5">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="surgeon">Primary Surgeon</label>
                        <select id="surgeon" class="form-control">
                            <option value="">Select Surgeon</option>
                            <option value="dr-smith">Dr. Sarah Smith</option>
                            <option value="dr-jones">Dr. Michael Jones</option>
                            <option value="dr-williams">Dr. Emily Williams</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="anesthesia-type">Anesthesia Type</label>
                        <select id="anesthesia-type" class="form-control">
                            <option value="">Select Type</option>
                            <option value="local">Local Anesthesia</option>
                            <option value="sedation">IV Sedation</option>
                            <option value="general">General Anesthesia</option>
                        </select>
                    </div>

                    <div class="risk-assessment">
                        <h4>Risk Assessment</h4>
                        <div>Overall Risk Level: <span class="risk-level risk-low">Low</span></div>
                        <div style="margin-top: 10px; font-size: 14px;">
                            No significant risk factors identified. Standard precautions apply.
                        </div>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-header">Procedure Templates</div>
                <div class="card-body">
                    <div class="template-grid">
                        <div class="template-item" data-template="standard">
                            <div style="font-weight: 500;">Standard Template</div>
                            <div style="font-size: 12px; color: #6c757d;">Basic procedure plan</div>
                        </div>
                        <div class="template-item" data-template="complex">
                            <div style="font-weight: 500;">Complex Template</div>
                            <div style="font-size: 12px; color: #6c757d;">Detailed multi-step plan</div>
                        </div>
                        <div class="template-item" data-template="revision">
                            <div style="font-weight: 500;">Revision Template</div>
                            <div style="font-size: 12px; color: #6c757d;">Secondary procedure</div>
                        </div>
                        <div class="template-item" data-template="custom">
                            <div style="font-weight: 500;">Custom Template</div>
                            <div style="font-size: 12px; color: #6c757d;">Build from scratch</div>
                        </div>
                    </div>

                    <div class="form-group" style="margin-top: 20px;">
                        <label for="technique">Surgical Technique</label>
                        <textarea id="technique" class="form-control" placeholder="Describe the surgical approach and technique..."></textarea>
                    </div>

                    <div class="form-group">
                        <label for="materials">Materials & Implants</label>
                        <textarea id="materials" class="form-control" placeholder="List materials, implants, or special equipment needed..."></textarea>
                    </div>
                </div>
            </div>

            <div class="card notes-section">
                <div class="card-header">
                    <div class="notes-tabs">
                        <div class="notes-tab active" data-tab="pre-op">Pre-Op Notes</div>
                        <div class="notes-tab" data-tab="intra-op">Intra-Op Notes</div>
                        <div class="notes-tab" data-tab="post-op">Post-Op Notes</div>
                        <div class="notes-tab" data-tab="follow-up">Follow-up</div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="tab-content active" id="pre-op">
                        <div class="form-group">
                            <label for="pre-op-assessment">Pre-Operative Assessment</label>
                            <textarea id="pre-op-assessment" class="form-control" style="min-height: 120px;" placeholder="Patient condition, vital signs, pre-op checklist..."></textarea>
                        </div>
                        <div class="form-group">
                            <label for="pre-op-instructions">Patient Instructions</label>
                            <textarea id="pre-op-instructions" class="form-control" placeholder="Pre-operative instructions given to patient..."></textarea>
                        </div>
                    </div>

                    <div class="tab-content" id="intra-op">
                        <div class="form-group">
                            <label for="procedure-notes">Procedure Notes</label>
                            <textarea id="procedure-notes" class="form-control" style="min-height: 120px;" placeholder="Detailed operative notes, complications, observations..."></textarea>
                        </div>
                        <div class="form-group">
                            <label for="complications">Complications</label>
                            <textarea id="complications" class="form-control" placeholder="Any complications encountered during procedure..."></textarea>
                        </div>
                    </div>

                    <div class="tab-content" id="post-op">
                        <div class="form-group">
                            <label for="post-op-care">Post-Operative Care</label>
                            <textarea id="post-op-care" class="form-control" style="min-height: 120px;" placeholder="Recovery instructions, wound care, medications..."></textarea>
                        </div>
                        <div class="form-group">
                            <label for="discharge-instructions">Discharge Instructions</label>
                            <textarea id="discharge-instructions" class="form-control" placeholder="Instructions for patient discharge..."></textarea>
                        </div>
                    </div>

                    <div class="tab-content" id="follow-up">
                        <div class="form-group">
                            <label for="follow-up-schedule">Follow-up Schedule</label>
                            <textarea id="follow-up-schedule" class="form-control" placeholder="Schedule for follow-up appointments..."></textarea>
                        </div>
                        <div class="form-group">
                            <label for="recovery-notes">Recovery Notes</label>
                            <textarea id="recovery-notes" class="form-control" style="min-height: 120px;" placeholder="Patient recovery progress, healing notes..."></textarea>
                        </div>
                    </div>

                    <div class="attachment-area" onclick="document.getElementById('file-input').click()">
                        <div>📎 Click to attach files or drag and drop</div>
                        <div style="font-size: 12px; color: #6c757d; margin-top: 5px;">
                            Images, documents, consent forms
                        </div>
                        <input type="file" id="file-input" multiple style="display: none;" accept="image/*,.pdf,.doc,.docx">
                    </div>

                    <div class="attachment-list" id="attachment-list">
                        <!-- Attachments will be displayed here -->
                    </div>
                </div>
            </div>
        </div>

        <div class="btn-group" style="justify-content: center; margin-top: 30px;">
            <button class="btn btn-outline" onclick="saveDraft()">Save as Draft</button>
            <button class="btn btn-secondary" onclick="generateConsent()">Generate Consent</button>
            <button class="btn btn-primary" onclick="savePlan()">Save & Complete</button>
        </div>
    </div>

    <script>
        // Tab functionality
        document.querySelectorAll('.notes-tab').forEach(tab => {
            tab.addEventListener('click', function() {
                const targetTab = this.dataset.tab;
                
                // Remove active class from all tabs and content
                document.querySelectorAll('.notes-tab').forEach(t => t.classList.remove('active'));
                document.querySelectorAll('.tab-content').forEach(c => c.classList.remove('active'));
                
                // Add active class to clicked tab and corresponding content
                this.classList.add('active');
                document.getElementById(targetTab).classList.add('active');
            });
        });

        // Template selection
        document.querySelectorAll('.template-item').forEach(item => {
            item.addEventListener('click', function() {
                document.querySelectorAll('.template-item').forEach(t => t.classList.remove('active'));
                this.classList.add('active');
                
                const template = this.dataset.template;
                loadTemplate(template);
            });
        });

        function loadTemplate(template) {
            const templates = {
                standard: {
                    technique: "Standard approach with minimal invasive techniques",
                    materials: "Standard surgical instruments, sutures, dressings"
                },
                complex: {
                    technique: "Multi-stage approach with advanced reconstruction techniques",
                    materials: "Specialized instruments, implants, mesh materials, advanced sutures"
                },
                revision: {
                    technique: "Revision approach addressing previous surgical site",
                    materials: "Revision-specific instruments, scar tissue management tools"
                },
                custom: {
                    technique: "",
                    materials: ""
                }
            };

            if (templates[template]) {
                document.getElementById('technique').value = templates[template].technique;
                document.getElementById('materials').value = templates[template].materials;
            }
        }

        // File upload handling
        document.getElementById('file-input').addEventListener('change', function(e) {
            const files = Array.from(e.target.files);
            displayAttachments(files);
        });

        function displayAttachments(files) {
            const attachmentList = document.getElementById('attachment-list');
            
            files.forEach(file => {
                const attachmentItem = document.createElement('div');
                attachmentItem.className = 'attachment-item';
                attachmentItem.innerHTML = `
                    <span>📄 ${file.name}</span>
                    <span onclick="removeAttachment(this)" style="cursor: pointer; color: #dc3545;">✕</span>
                `;
                attachmentList.appendChild(attachmentItem);
            });
        }

        function removeAttachment(element) {
            element.parentElement.remove();
        }

        // Form validation
        function validateForm() {
            const requiredFields = ['procedure-type', 'scheduled-date', 'surgeon'];
            let isValid = true;
            
            requiredFields.forEach(fieldId => {
                const field = document.getElementById(fieldId);
                if (!field.value.trim()) {
                    field.style.borderColor = '#dc3545';
                    isValid = false;
                } else {
                    field.style.borderColor = '#ced4da';
                }
            });
            
            return isValid;
        }

        // Save functions
        function saveDraft() {
            const formData = collectFormData();
            formData.status = 'draft';
            
            // Simulate saving
            console.log('Saving draft:', formData);
            showNotification('Draft saved successfully', 'success');
        }

        function savePlan() {
            if (!validateForm()) {
                showNotification('Please fill in all required fields', 'error');
                return;
            }
            
            const formData = collectFormData();
            formData.status = 'completed';
            
            // Simulate saving
            console.log('Saving plan:', formData);
            showNotification('Procedure plan saved successfully', 'success');
        }

        function generateConsent() {
            if (!validateForm()) {
                showNotification('Please complete procedure details before generating consent', 'error');
                return;
            }
            
            // Simulate consent generation
            console.log('Generating consent form...');
            showNotification('Consent form generated successfully', 'success');
        }

        function collectFormData() {
            return {
                procedureType: document.getElementById('procedure-type').value,
                scheduledDate: document.getElementById('scheduled-date').value,
                estimatedDuration: document.getElementById('estimated-duration').value,
                surgeon: document.getElementById('surgeon').value,
                anesthesiaType: document.getElementById('anesthesia-type').value,
                technique: document.getElementById('technique').value,
                materials: document.getElementById('materials').value,
                preOpAssessment: document.getElementById('pre-op-assessment').value,
                preOpInstructions: document.getElementById('pre-op-instructions').value,
                procedureNotes: document.getElementById('procedure-notes').value,
                complications: document.getElementById('complications').value,
                postOpCare: document.getElementById('post-op-care').value,
                dischargeInstructions: document.getElementById('discharge-instructions').value,
                followUpSchedule: document.getElementById('follow-up-schedule').value,
                recoveryNotes: document.getElementById('recovery-notes').value,
                timestamp: new Date().toISOString()
            };
        }

        function showNotification(message, type) {
            const notification = document.createElement('div');
            notification.style.cssText = `
                position: fixed;
                top: 20px;
                right: 20px;
                padding: 15px 20px;
                border-radius: 6px;
                color: white;
                font-weight: 500;
                z-index: 1000;
                animation: slideIn 0.3s ease;
                background-color: ${type === 'success' ? '#28a745' : '#dc3545'};
            `;
            notification.textContent = message;
            
            document.body.appendChild(notification);
            
            setTimeout(() => {
                notification.remove();
            }, 3000);
        }

        // Auto-save functionality
        let autoSaveTimer;
        document.addEventListener('input', function() {
            clearTimeout(autoSaveTimer);
            autoSaveTimer = setTimeout(saveDraft, 30000); // Auto-save after 30 seconds of inactivity
        });

        // Initialize form with current date
        document.getElementById('scheduled-date').valueAsDate = new Date();
    </script>

@endsection
