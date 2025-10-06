
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
          <a class="nav-link active" href="{{route('opd.show',[$patient->appointments->last()->id])}}"><i class="bi bi-person-badge"></i> Patient Overview</a>
          <a class="nav-link" href="#"><i class="bi bi-journal-medical"></i> Procedure Planning & Notes</a>
          <a class="nav-link" href="#"><i class="bi bi-camera-reels"></i> Imaging & 3D Simulation</a>
 		  <a class="nav-link" href="{{ route('lab-radiology.lab',[$patient->appointments->last()->id]) }}"><i class="bi bi-clipboard-pulse"></i> Lab & Radiology Requests</a>

          <a class="nav-link" href="#"><i class="bi bi-capsule"></i> Inventory & Pharmacy</a>
          <a class="nav-link" href="#"><i class="bi bi-calendar-check"></i> Appointments & Workflow</a>
          <a class="nav-link" href="#"><i class="bi bi-receipt"></i> Billing & Insurance</a>
          <a class="nav-link" href="#"><i class="bi bi-chat-dots"></i> Messaging & Telemedicine</a>
        </nav>
      </div>



                  @yield('content')


                     </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
