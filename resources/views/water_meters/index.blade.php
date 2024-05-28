<!DOCTYPE html>
<html>
<head>
    <title>Water Meter Readings</title>
</head>
<body>
    <h1>Water Meter Readings</h1>
    <a href="{{ route('water_meters.create') }}">Create New Reading</a>
    @if (session('success'))
        <div>
            {{ session('success') }}
        </div>
    @endif
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Device ID</th>
                <th>Value</th>
                <th>Taken At</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($waterMeters as $waterMeter)
                <tr>
                    <td>{{ $waterMeter->id }}</td>
                    <td>{{ $waterMeter->device_id }}</td>
                    <td>{{ $waterMeter->value }}</td>
                    <td>{{ $waterMeter->taken_at }}</td>
                    <td>
                        <a href="{{ route('water_meters.show', $waterMeter->id) }}">View</a>
                        <a href="{{ route('water_meters.edit', $waterMeter->id) }}">Edit</a>
                        <form action="{{ route('water_meters.destroy', $waterMeter->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
