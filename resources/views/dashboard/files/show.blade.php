<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">

<link rel="stylesheet" href="{{ asset('site/assets/style.css') }}">
</head>
<body>
    <div class="container">
                    @if (session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
            @endif
        <h1>
          Making the <code>&lt;details&gt;</code> element look and behave like a modal<sup>(kinda..)</sup>
        </h1>

        <h4>{{ $file->filename }}</h4>
           <form action="{{ route('download.file') }}" method="POST">
            @csrf
            <input type="hidden" name="fileId" value="{{ $file->id }}">
            <div class="input-group input-group-sm mb-3">
                <span class="input-group-text" id="inputGroup-sizing-sm">Secret Key</span>
                <input type="text" name="secretKey" class="form-control @error('secretKey') is-invalid @enderror" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm">
                @error('secretKey')
                <small class="invalid-feedback">{{ $message }}</small>
                @enderror
              </div>
            <button type="submit" class="btn btn-success" >Download File</button>
        </form>


      </div>



</body>
</html>
