<!DOCTYPE html>
<html lang="">
    <head>
        <title>Upload File</title>
    </head>

    <body>

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <form action="/upload" method="post" enctype="multipart/form-data">
        @csrf
        <input type="file" name="file">
        <button type="submit">Tải lên</button>
    </form>

    <img src="{{ $image }}" alt="" />

    </body>
</html>
