@extends('backend.layouts.master')

@section('title')
    Testimonial Index
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
        <h1>Testimonial List Table</h1>
        <div class="col-12">
            <div class="d-flex justify-content-end">
                <a href="{{ route('testimonial.create') }}" class="btn btn-primary" height="50" width="80">
                    <i class="fas fa-plus-circle"></i>
                    Add New Testimonial
                </a>
            </div>
        </div>
        <div class="col-12">
            <div class="table-responsive my-2">
                <table class="table table-bordered table-striped" id="dataTable">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Last Modified</th>
                            <th scope="col">Client Image</th>
                            <th scope="col">Client Name</th>
                            <th scope="col">Client Designation</th>
                            <th scope="col">Options</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($testimonials as $testimonial)
                            <tr>
                                <th scope="row">{{ $testimonials->firstItem() + $loop->index }}</th>
                                <td>{{ $testimonial->updated_at->format('d M Y') }}</td>
                                <td>
                                    <img src="{{ asset($testimonial->client_image) }}" alt="image"
                                        class="img-fluid rounded-circle" height="100" width="120">
                                </td>
                                <td>{{ $testimonial->client_name }}</td>
                                <td>{{ $testimonial->client_designation }}</td>
                                <td>
                                    <div class="dropdown">
                                        <button class="btn btn-secondary dropdown-toggle" type="button"
                                            data-bs-toggle="dropdown" aria-expanded="false">
                                            setting
                                        </button>
                                        <ul class="dropdown-menu">
                                            <li><a class="dropdown-item"
                                                    href="{{ route('testimonial.edit', $testimonial->client_name_slug) }}">
                                                    <i class="fas fa-edit"></i> Edit</a></li>
                                            <li>
                                                <form
                                                    action="{{ route('testimonial.destroy', $testimonial->client_name_slug) }}"
                                                    method="post">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button class="dropdown-item show_confirm" type="submit"><i
                                                            class="fas fa-trash"></i> Delete</a></button>
                                                </form>
                                            </li>
                                        </ul>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

@push('admin_script')
    <script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.12.1/js/dataTables.bootstrap5.min.js"></script>

    <script>
        $(document).ready(function() {
            $('#dataTable').DataTable({
                pagingType: 'first_last_numbers',
            });
        });
    </script>
@endpush
