@extends('dashboard.master')


@section('content')
    <div class="container-fluid">

        <!-- Page Heading -->
        <h1 class="h3 mb-2 text-gray-800">Tables</h1>
        <p class="mb-4">DataTables is a third party plugin that is used to generate the demo table below.
            For more information about DataTables, please visit the <a target="_blank" href="https://datatables.net">official
                DataTables documentation</a>.</p>

        <!-- DataTales Example -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">DataTables Example</h6>
            </div>
            <div class="card-body">
                @if (session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif
                <div class="table-responsive">
                    <div id="dataTable_wrapper" class="dataTables_wrapper dt-bootstrap4">
                        <div class="row">
                            <div class="col-sm-12">
                                <table class="table table-bordered dataTable" id="dataTable" width="100%" cellspacing="0"
                                    role="grid" aria-describedby="dataTable_info" style="width: 100%;">
                                    <thead>
                                        <tr role="row">
                                            <th class="sorting sorting_asc" tabindex="0" aria-controls="dataTable"
                                                rowspan="1" colspan="1" aria-sort="ascending"
                                                aria-label="Name: activate to sort column descending" style="width: 59px;">
                                                Id</th>
                                            <th class="sorting sorting_asc" tabindex="0" aria-controls="dataTable"
                                                rowspan="1" colspan="1" aria-sort="ascending"
                                                aria-label="Name: activate to sort column descending" style="width: 59px;">
                                                Name</th>
                                            <th class="sorting" tabindex="0" aria-controls="dataTable" rowspan="1"
                                                colspan="1" aria-label="Position: activate to sort column ascending"
                                                style="width: 59px;">Size</th>
                                            <th class="sorting" tabindex="0" aria-controls="dataTable" rowspan="1"
                                                colspan="1" aria-label="Office: activate to sort column ascending"
                                                style="width: 129px;">User Id</th>
                                            <th class="sorting" tabindex="0" aria-controls="dataTable" rowspan="1"
                                                colspan="1" aria-label="Age: activate to sort column ascending"
                                                style="width: 59px;">Created At</th>
                                            <th class="sorting" tabindex="0" aria-controls="dataTable" rowspan="1"
                                                colspan="1" aria-label="Start date: activate to sort column ascending"
                                                style="width: 122px;">Secet Key</th>
                                            <th class="sorting" tabindex="0" aria-controls="dataTable" rowspan="1"
                                                colspan="1" aria-label="Salary: activate to sort column ascending"
                                                style="width: 109px;">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($files as $file)
                                            <tr class="odd">
                                                <td class="sorting_1">{{ $file->id }}</td>

                                                <td>{{ $file->filename }}</td>
                                                <td>{{ $file->size }}</td>
                                                <td>{{ $file->user_id }}</td>
                                                <td>{{ $file->created_at }}</td>
                                                <td>{{ $file->secret_key }}</td>

                                                <td>
                                                    <a class="btn btn-sm btn-primary"
                                                        href="{{ route('files.edit', $file->id) }}"><i class="fas fa-edit"></i></a>
                                                    <form id="delete-form" action="{{ route('files.destroy', $file->id) }}"
                                                        method="POST" style="display: none;">
                                                        @csrf
                                                        @method('DELETE')
                                                    </form>

                                                    <a href="#" class="btn btn-danger btn-sm"
                                                        onclick="event.preventDefault(); if(confirm('Are you sure you want to delete this file?')) document.getElementById('delete-form').submit();"><i class="fas fa-trash"></i></a>


                                                    <a class="btn btn-sm btn-success btn-copy-link" href="#"><i class="fas fa-link"></i></a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>

    </div>

@endsection


@section('scripts')


    <script>
        // JavaScript to handle copy link button click
        const copyLinkButtons = document.querySelectorAll('.btn-copy-link');

        copyLinkButtons.forEach((button) => {
            button.addEventListener('click', () => {
                const row = button.closest('tr');
                const fileId = row.querySelector('.sorting_1').textContent;
                const link = window.location.origin + '/show/' +
                fileId; // Modify the URL pattern as per your route
                copyToClipboard(link);
                alert('Link copied: ' + link);
            });
        });

        function copyToClipboard(text) {
            const input = document.createElement('textarea');
            input.style.position = 'fixed';
            input.style.opacity = 0;
            input.value = text;
            document.body.appendChild(input);
            input.select();
            document.execCommand('copy');
            document.body.removeChild(input);
        }
    </script>
@stop
