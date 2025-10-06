<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Plastic Surgeon Clinic Management</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
 
  <style>
    body {
      background-color: #f8f9fa;
      font-family: "Segoe UI", sans-serif;
    }
    .sidebar {
      background-color: #f5f7fb;
      height: 100vh;
      padding: 20px;
      border-right: 1px solid #dee2e6;
    }
    .sidebar h5 {
      font-size: 0.85rem;
      color: #6c757d;
      margin-bottom: 2.5rem;
      text-transform: uppercase;
      line-height: 1.4;
    }
    .sidebar .nav-link {
      color: #111;
      font-weight: 500;
      padding: 12px 10px;
      display: flex;
      align-items: center;
      gap: 10px;
      border-radius: 8px;
      font-size: 0.95rem;
    }
    .sidebar .nav-link.active {
      background-color: #e3eafc;
      color: #0d6efd;
    }
    .main-header {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-bottom: 2rem;
    }
    .main-header h4 {
      font-weight: bold;
      font-size: 1.1rem;
    }
    .icon-btn {
      background: none;
      border: none;
      font-size: 1.3rem;
      color: #333;
      margin-left: 10px;
    }
    .dropdown-toggle::after {
      display: none;
    }
    .profile-icon {
      width: 36px;
      height: 36px;
      border-radius: 50%;
      object-fit: cover;
      margin-left: 10px;
      cursor: pointer;
    }
    .dropdown-menu {
      right: 0;
      left: auto;
    }
    .card.patient-card {
      display: flex;
      align-items: center;
      gap: 1.5rem;
    }
    .card.patient-card img {
      width: 90px;
      height: 90px;
      border-radius: 50%;
      object-fit: cover;
    }
    .patient-details p {
      margin: 0;
      font-size: 0.95rem;
    }
    .section-title {
      font-size: 1.1rem;
      font-weight: 600;
      margin-bottom: 0.75rem;
    }
    .img-thumbnail {
      border: none;
      border-radius: 10px;
      width: 120px;
      height: 120px;
      object-fit: cover;
    }
    .btn-blue {
      background-color: #2563eb;
      color: white;
      border-radius: 8px;
      padding: 10px 16px;
      font-weight: 500;
      display: flex;
      align-items: center;
      gap: 8px;
    }
    .btn-blue:hover {
      background-color: #1d4ed8;
    }
    .form-check-label {
      font-size: 0.95rem;
    }
	
	  .icon-btn {
    width: 40px;
    height: 40px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    border: none;
    background-color: transparent;
    font-size: 1.2rem;
    padding: 0;
    cursor: pointer;
  }

  .icon-btn:hover {
    background-color: #f0f0f0;
    border-radius: 50%;
  }

  .icon-container {
    width: 40px;
    height: 40px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    font-size: 1.2rem;
    cursor: pointer;
  }

  .icon-container:hover {
    background-color: #f0f0f0;
    border-radius: 50%;
  }

  </style>
</head>
<body>
  <div class="container-fluid">
    <div class="row">
      <!-- Sidebar -->
      <div class="col-md-3 sidebar">
        <h5><b>PLASTIC SURGEON</b><br>CLINIC MANAGEMENT</h5>
        <nav class="nav flex-column">
          <a class="nav-link active" href="#"><i class="bi bi-person-badge"></i> Patient Overview</a>
          <a class="nav-link" href="#"><i class="bi bi-journal-medical"></i> Procedure Planning & Notes</a>
          <a class="nav-link" href="#"><i class="bi bi-camera-reels"></i> Imaging & 3D Simulation</a>
 		  <a class="nav-link" href="{{ route('lab-radiology.lab') }}"><i class="bi bi-clipboard-pulse"></i> 11Lab & Radiology Requests</a>

          <a class="nav-link" href="#"><i class="bi bi-capsule"></i> Inventory & Pharmacy</a>
          <a class="nav-link" href="#"><i class="bi bi-calendar-check"></i> Appointments & Workflow</a>
          <a class="nav-link" href="#"><i class="bi bi-receipt"></i> Billing & Insurance</a>
          <a class="nav-link" href="#"><i class="bi bi-chat-dots"></i> Messaging & Telemedicine</a>
        </nav>
      </div>

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
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
