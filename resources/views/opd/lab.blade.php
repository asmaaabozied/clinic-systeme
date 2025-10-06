@extends('opd.layout.app')

@section('title', 'Patient Dashboard')

@section('header')
    <h3 class="mb-4">Patient Information</h3>
@endsection

@section('content')
{{-- 
  <!-- <div class="col-md-9 p-4">
<div class="container mt-3">
    <div class="row align-items-end gy-2">
    
        <div class="col-md-3">
            <label for="medicine" class="form-label">category</label>
            <select class="form-select" id="medicine" name="medicine[]">
                <option selected>Select</option>
             </select>
        </div>
        <div class="col-md-3">
            <label for="dose" class="form-label">radiology subcategories</label>
            <select class="form-select" id="dose" name="dose[]">
                <option selected>Select</option>
             </select>
        </div>
        <div class="col-md-3">
            <label for="interval" class="form-label">body part examined</label>
            <select class="form-select" id="interval" name="interval[]">
                <option selected>Select</option>
             </select>
        </div>
        <div class="col-md-3">
            <label for="duration" class="form-label">clinical indecation</label>
            <select class="form-select" id="duration" name="duration[]">
                <option selected>Select</option>
             </select>
        </div>
       
    </div>
</div>
</div> -->
--}}

<div class="col-md-9 p-4">
    <div id="formContainer" class="container mt-3">
        <div class="row align-items-end gy-2 form-group">
            <div class="col-md-3">
                <label class="form-label">Category</label>
                <select class="form-select" name="category[]">
                    <option selected>Select</option>
                    <!-- Options here -->
                </select>
            </div>
            <div class="col-md-3">
                <label class="form-label">Radiology Subcategories</label>
                <select class="form-select" name="subcategory[]">
                    <option selected>Select</option>
                    <!-- Options here -->
                </select>
            </div>
            <div class="col-md-3">
                <label class="form-label">Body Part Examined</label>
                <select class="form-select" name="body_part[]">
                    <option selected>Select</option>
                    <!-- Options here -->
                </select>
            </div>
            {{--<div class="col-md-3">
                <label class="form-label">Clinical Indication</label>
                <select class="form-select" name="indication[]">
                    <option selected>Select</option>
                 </select>
            </div>--}}
            <div class="col-md-3">
           <label class="form-label">Clinical Indication</label>
          <input type="text" class="form-control" name="indication[]" placeholder="Enter clinical indication">
          </div>

        </div>
    </div>

    <!-- زر الإضافة -->
    <div class="text-end mt-3">
        <button type="button" class="btn btn-success" id="addRowBtn">+ Add Record</button>
    </div>
</div>

<!-- jQuery (لو مش ضايفه بالفعل) -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
    $(document).ready(function () {
        $('#addRowBtn').click(function () {
            let newRow = `
            <div class="row align-items-end gy-2 form-group mt-3">
                <div class="col-md-3">
                    <select class="form-select" name="category[]">
                        <option selected>Select</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <select class="form-select" name="subcategory[]">
                        <option selected>Select</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <select class="form-select" name="body_part[]">
                        <option selected>Select</option>
                    </select>
                </div>
                  <div class="col-md-3">
           <input type="text" class="form-control" name="indication[]" placeholder="Enter clinical indication">
          </div>
            </div>
            `;
            $('#formContainer').append(newRow);
        });
    });
</script>


@endsection
