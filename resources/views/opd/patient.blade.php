@extends('opd.layout.app')

@section('title', 'Patient Dashboard')

@section('header')
    <h3 class="mb-4">Patient Information</h3>
@endsection

@section('content')
       <!-- Main Content -->
      <div class="col-md-9 p-4">
        <!-- Header -->
   
		<div class="main-header">
  <!--<h4>PLASTIC SURGEON CLINIC MANAGEMENT</h4>-->
 <h2>
  PLASTIC SURGEON<br>
  <span>CLINIC MANAGEMENT</span>
</h2>


 
  <div class="d-flex align-items-center gap-3">
  <button class="icon-btn"><i class="bi bi-search"></i></button>
  <button class="icon-btn"><i class="bi bi-plus-circle"></i></button>

  <div class="dropdown">
    <a href="#" class="icon-container dropdown-toggle text-dark" role="button" data-bs-toggle="dropdown" aria-expanded="false">
      <i class="bi bi-person-circle"></i>
    </a>
    <ul class="dropdown-menu dropdown-menu-end">
      <li><a class="dropdown-item" href="#">View Profile</a></li>
      <li><a class="dropdown-item" href="#">Settings</a></li>
      <li><hr class="dropdown-divider"></li>
      <li><a class="dropdown-item" href="#">Logout</a></li>
    </ul>
  </div>
</div>

</div>


    
		
		
 
 
			 
				
				
				
				

  <div class="card p-4 mb-4">
  <div class="row align-items-stretch">
    
    <!-- صورة المريض -->
    <div class="col-12 col-md-4 mb-3 mb-md-0">
      <img 
        src="https://randomuser.me/api/portraits/men/75.jpg" 
        alt="John Smith"
        class="img-fluid rounded w-100 h-100"
        style="object-fit: cover; min-height: 200px;">
    </div>

    <!-- بيانات المريض -->
    <div class="col-12 col-md-8 d-flex align-items-start">
      <div class="w-100 d-flex flex-column justify-content-between" style="min-height: 200px;">
       <br>
        <div>
          <strong class="fs-5">Patient:</strong><br>
          {{--<span class="fs-4 fw-semibold">John Smith</span>--}}
          <span class="fs-4 fw-semibold">{{$patient->name}}</span>
        </div>
 <br> <br> <br>
        <div class="d-flex flex-wrap gap-5">
          <div>
            <strong class="fs-5">Age</strong><br>
           {{--<span class="fs-4">45</span> --}}
            <span class="fs-4">  {{ \Carbon\Carbon::parse($patient->date_of_birth)->age }}</span> 
         
           </div>
          <div>
            <strong class="fs-5">Date of Birth</strong><br>
            {{--<span class="fs-4">02/14/1979</span>--}}
              <span class="fs-4">{{$patient->date_of_birth}}</span>
          </div>
        </div>

      </div>
    </div>

  </div>
</div>








 
		
		
		
		 <div class="section-title">Pre-Op Evaluation</div>
		    <div class="card p-3 mb-4">
         
          <ul>
            <li>Vital signs</li>
            <li>Risk assessment</li>
          </ul>
        </div>
		
		
		

       
		
 





 <div class="mb-4">
  <div class="section-title mb-3">Previous Procedures & Treatment History</div>

  <div class="row g-4 justify-content-start">
    <!-- كرت الصورة + الزر -->
    <div class="col-12 col-md-4 d-flex justify-content-center">
      <div class="text-center" style="width: 220px;">
        <img src="https://randomuser.me/api/portraits/women/65.jpg" class="img-thumbnail mb-2 w-100" style="height: 160px; object-fit: cover;">
        <button class="btn btn-blue btn-sm w-100">
          <i class="bi bi-diagram-3"></i>Templated <br> Surgery Plan
        </button>
      </div>
    </div>

    <!-- كرت ثاني -->
    <div class="col-12 col-md-4 d-flex justify-content-center">
      <div class="text-center" style="width: 220px;">
        <img src="https://randomuser.me/api/portraits/women/66.jpg" class="img-thumbnail mb-2 w-100" style="height: 160px; object-fit: cover;">
        <button class="btn btn-blue btn-sm w-100">
          <i class="bi bi-images"></i> Before & After <br> Image Integra-
        </button>
      </div>
    </div>
  </div>
</div>





        <!-- Procedure Notes -->
		 <div class="section-title">Procedure Planning & Notes</div>
        <div class="card p-3">
          <!--<div class="section-title">Procedure Planning & Notes</div>-->
          <div class="form-check">
            <input class="form-check-input" type="checkbox" checked>
            <label class="form-check-label fw-bold">
              Auto-generated Consent Form & Patient Signature
            </label>
          </div>
        </div>
      </div>
	  <!-- Main Content -->
@endsection
