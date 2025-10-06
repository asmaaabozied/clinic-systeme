<div class="d-flex gap-2">
    <button type="button" class="btn btn-sm btn-outline-warning" 
            onclick="editMedicineCategory({{ $medicineCategory->id }}, '{{ $medicineCategory->name }}')">
        <i class="ri-edit-line"></i> Edit
    </button>
    <button type="button" class="btn btn-sm btn-outline-danger" 
            onclick="deleteMedicineCategory({{ $medicineCategory->id }})">
        <i class="ri-delete-bin-line"></i> Delete
    </button>
</div> 