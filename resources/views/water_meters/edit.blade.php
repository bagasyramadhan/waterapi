<!DOCTYPE html>
<html>
<head>
    <title>Edit Water Meter Reading</title>
</head>
<body>
    <h1>Edit Water Meter Reading</h1>
    @if ($errors->any())
        <div>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <form action="{{ route('water_meters.update', $waterMeter->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div>
            <label for="device_id">Device ID:</label>
            <input type="text" id="device_id" name="device_id" value="{{ $waterMeter->device_id }}" required>
        </div>
        <div>
            <label for="value">Value:</label>
            <input type="number" id="value" name="value" value="{{ $waterMeter->value }}" required>
        </div>
        <div>
            <label for="taken_at">Taken At:</label>
            <input type="datetime-local" id="taken_at" name="taken_at" value="{{ $waterMeter->taken_at->format('Y-m-d\TH:i') }}" required>
        </div>
        <button type="submit">Submit</button>
    </form>
</body>
</html>
