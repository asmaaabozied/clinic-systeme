@extends('layouts.app') {{-- لو عندك layout أساسي --}}

@section('content')
<div class="container">
    <h1>OPD View - Patient View</h1>

    {{-- زر إضافة مريض --}}
    <div style="margin-bottom: 20px;">
        <a href="{{ route('patients.create') }}" class="btn btn-primary">إضافة مريض</a>
    </div>

    {{-- شريط البحث --}}
    <div style="margin-bottom: 20px;">
        <input type="text" id="searchInput" placeholder="Search..." class="form-control" onkeyup="filterTable()">
    </div>

    {{-- جدول المرضى --}}
    <table class="table table-bordered" id="patientsTable">
        <thead>
            <tr>
                <th>OPD No</th>
                <th>Patient Name</th>
                <th>Case ID</th>
                <th>Appointment Date</th>
                <th>Consultant</th>
                <th>Reference</th>
                <th>Symptoms</th>
                <th>Previous Medical Issue</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach($patients as $patient)
            <tr>
                <td>{{ $patient->opd_no }}</td>
                <td>{{ $patient->name }}</td>
                <td>{{ $patient->case_id }}</td>
                <td>{{ $patient->appointment_date }}</td>
                <td>{{ $patient->consultant }}</td>
                <td>{{ $patient->reference ?? '-' }}</td>
                <td>{{ $patient->symptoms }}</td>
                <td>{{ $patient->previous_medical_issue ?? '-' }}</td>
                <td>
                    <a href="{{ route('patients.show', $patient->id) }}" class="btn btn-info btn-sm">عرض</a>
                    <a href="{{ route('patients.edit', $patient->id) }}" class="btn btn-warning btn-sm">تعديل</a>
                    <form action="{{ route('patients.destroy', $patient->id) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('هل أنت متأكد من الحذف؟')">حذف</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

{{-- سكربت بحث بسيط --}}
<script>
function filterTable() {
    const input = document.getElementById('searchInput');
    const filter = input.value.toLowerCase();
    const table = document.getElementById('patientsTable');
    const trs = table.getElementsByTagName('tr');

    for (let i = 1; i < trs.length; i++) {
        const row = trs[i];
        const text = row.textContent.toLowerCase();
        row.style.display = text.includes(filter) ? '' : 'none';
    }
}
</script>
@endsection
