@extends('backend.layouts.master')

@section('title')
    Dashboard
@endsection

@push('admin_style')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/dataTables.bootstrap5.min.css">

    <style>
        .dataTables_length {
            padding: 20px 0;
        }
    </style>
@endpush

@section('admin_content')
    <div class="row">
        <div class="col-12">
            <h1>Welcome to Dashboard</h1>
        </div>
    </div>
@endsection

@push('admin_script')
@endpush
