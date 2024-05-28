<!DOCTYPE html>
<html>
<head>
    <title>OCR Result</title>
</head>
<body>
    <h1>OCR Result</h1>
    <p>Hasil Ekstraksi OCR : {{ $text }}</p>
    <img src="{{ $imageUrl }}" alt="Uploaded Image">
    <a href="/ocr">Upload another image</a>
</body>
</html>
