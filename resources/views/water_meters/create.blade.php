<!DOCTYPE html>
<html>
<head>
    <title>Create Water Meter Reading</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
        img {
            max-width: 100%;
            height: auto;
        }
    </style>
</head>
<body>
    <h1>Create Water Meter Reading</h1>
    @if ($errors->any())
        <div>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <form id="createForm" action="{{ route('water_meters.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div>
            <label for="device_id">Device ID:</label>
            <input type="text" id="device_id" name="device_id" required>
        </div>
        <div>
            <label for="image">Upload Image:</label>
            <input type="file" id="image" name="image" required>
        </div>
        <div id="image-preview" style="display:none;">
            <p>Image Preview:</p>
            <img id="preview-img" src="" alt="Image Preview">
        </div>
        <div>
            <label for="value">Value:</label>
            <input type="number" id="value" name="value" value="{{ old('value') }}" required>
        </div>
        <div>
            <label for="taken_at">Taken At:</label>
            <input type="datetime-local" id="taken_at" name="taken_at" required>
        </div>
        <button type="submit">Submit</button>
    </form>

    <script>
        document.getElementById('image').addEventListener('change', function(event) {
            var file = event.target.files[0];
            if (file) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    document.getElementById('preview-img').src = e.target.result;
                    document.getElementById('image-preview').style.display = 'block';
                };
                reader.readAsDataURL(file);

                var formData = new FormData();
                formData.append('image', file);

                fetch('{{ route('ocr.process') }}', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    if (data.text) {
                        document.getElementById('value').value = parseInt(data.text.replace(/\D/g, ''), 10);
                    } else if (data.error) {
                        alert(data.error);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('OCR processing failed. Please try again.');
                });
            }
        });
    </script>
</body>
</html>
        