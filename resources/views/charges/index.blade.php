@extends('layouts.admin')

@section('content')
<div class="container bg-white p-4 shadow"">
    <h1>Charges</h1>
    <a href="{{ route('charges.create') }}" class="btn btn-primary mb-3">Add Charge</a>
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Charge Type</th>
                <th>Charge Category</th>
                <th>Unit Type</th>
                <th>Name</th>
                <th>Tax</th>
                <th>Tax %</th>
                <th>Standard Charge</th>
                <th>Description</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($charges as $charge)
                <tr>
                    <td>{{ $charge->id }}</td>
                    <td>{{ $charge->chargeType ? $charge->chargeType->name : '' }}</td>
                    <td>{{ $charge->chargeCategory ? $charge->chargeCategory->name : '' }}</td>
                    <td>{{ $charge->unitType ? $charge->unitType->name : '' }}</td>
                    <td>{{ $charge->charge_name }}</td>
                    <td>{{ $charge->tax ? $charge->tax->name : '' }}</td>
                    <td>{{ $charge->tax_percentage }}</td>
                    <td>{{ $charge->standard_charge }}</td>
                    <td>{{ $charge->description }}</td>
                    <td>
                        <a href="{{ route('charges.show', $charge) }}" class="btn btn-info btn-sm">View</a>
                        <a href="{{ route('charges.edit', $charge) }}" class="btn btn-warning btn-sm">Edit</a>
                        <form action="{{ route('charges.destroy', $charge) }}" method="POST" style="display:inline-block;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
