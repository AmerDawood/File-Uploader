@extends('dashboard.master')






@section('content')


<div class="container-fluid" style="padding-top: 60px">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Upload File</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('files.store') }}" enctype="multipart/form-data">
                        @csrf

                        <div class="form-group">
                            <label for="file">Choose File</label>
                            <div class="custom-file">
                                <input type="file" class="custom-file-input @error('file') is-invalid @enderror" id="file" name="file" accept=".pdf,.doc,.docx,.xls,.xlsx,.png,.jpeg,.jpg">
                                @error('file')
                                <small class="invalid-feedback">{{ $message }}</small>
                                @enderror

                                <label class="custom-file-label" for="file">Choose file</label>
                            </div>

                        </div>


                        <button type="submit" class="btn btn-primary">Upload</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>


@endsection
