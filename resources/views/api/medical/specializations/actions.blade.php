<div class="d-flex gap-2">
    <button type="button" class="btn btn-sm btn-outline-primary" 
            onclick="showDoctors({{ $specialization->id }})">
        <i class="ri-user-line"></i> Doctors
    </button>
    <button type="button" class="btn btn-sm btn-outline-warning" 
            onclick="editSpecialization({{ $specialization->id }}, '{{ $specialization->name }}')">
        <i class="ri-edit-line"></i> Edit
    </button>
    <button type="button" class="btn btn-sm btn-outline-danger" 
            onclick="deleteSpecialization({{ $specialization->id }})">
        <i class="ri-delete-bin-line"></i> Delete
    </button>
</div> 