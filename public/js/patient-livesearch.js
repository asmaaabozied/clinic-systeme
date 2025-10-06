document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('patient-search-input');
    const tableBody = document.getElementById('patients-table-body');
    let timer = null;

    if (!searchInput) return;

    searchInput.addEventListener('input', function() {
        clearTimeout(timer);
        timer = setTimeout(function() {
            const query = searchInput.value;
            fetch(`/patients/livesearch?q=${encodeURIComponent(query)}`)
                .then(response => response.json())
                .then(data => {
                    tableBody.innerHTML = '';
                    if (data.length === 0) {
                        tableBody.innerHTML = `<tr><td colspan="11" class="text-center">No patients found</td></tr>`;
                        return;
                    }
                    data.forEach(patient => {
                        tableBody.innerHTML += `
                        <tr>
                            <td>${patient.id}</td>
                            <td>${patient.first_name}</td>
                            <td>${patient.last_name}</td>
                            <td>${patient.email ?? ''}</td>
                            <td>${patient.phone ?? ''}</td>
                            <td>${patient.gender ?? ''}</td>
                            <td>${patient.birth_date ?? ''}</td>
                            <td>${patient.address ?? ''}</td>
                            <td>${patient.blood_type ?? ''}</td>
                            <td>${patient.note ?? ''}</td>
                            <td>
                                <a href="/patients/${patient.id}/edit" class="btn btn-sm btn-warning">Edit</a>
                                <form action="/patients/${patient.id}" method="POST" style="display:inline-block;">
                                    <input type="hidden" name="_token" value="${window.csrfToken}">
                                    <input type="hidden" name="_method" value="DELETE">
                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
                                </form>
                            </td>
                        </tr>
                        `;
                    });
                });
        }, 300);
    });
});
