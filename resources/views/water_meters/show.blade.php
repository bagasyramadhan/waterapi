<!DOCTYPE html>
<html>
<head>
    <title>Water Meter Reading</title>
</head>
<body>
    <h1>Water Meter Reading</h1>
    <p>ID: {{ $waterMeter->id }}</p>
    <p>Device ID: {{ $waterMeter->device_id }}</p>
    <p>Value: {{ $waterMeter->value }}</p>
    <p>Taken At: {{ $waterMeter->taken_at }}</p>
    <a href="{{ route('water_meters.index') }}">Back to list</a>
</body>
</html>
