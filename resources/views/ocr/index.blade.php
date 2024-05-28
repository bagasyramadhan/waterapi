<!DOCTYPE html>
<html>
<head>
    <title>OCR Upload</title>
</head>
<body>
    <h1>Upload Image for OCR</h1>
    @if ($errors->any())
        <div>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <form action="/ocr" method="post" enctype="multipart/form-data">
        @csrf
        <label for="image">Choose image:</label>
        <input type="file" name="image" id="image" required>
        <button type="submit">Upload</button>
    </form>
</body>
</html>
