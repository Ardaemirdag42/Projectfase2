<!DOCTYPE html>
<html>
<head>
    <title>Reservering Bewerken</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        .form-group {
            margin-bottom: 15px;
        }
        label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }
        input, select {
            padding: 8px;
            width: 320px;
            border: 1px solid #ccc;
            border-radius: 4px;
            display: block;
        }
        button {
            margin-top: 15px;
            padding: 10px 20px;
            background-color: #1d4ed8;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        button:hover {
            background-color: #2563eb;
        }
        .error {
            color: red;
            margin-bottom: 15px;
        }
    </style>
</head>
<body>
    <h1>Reservering Bewerken</h1>

    <!-- Foutmeldingen -->
    @if($errors->any())
        <div class="error">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="/reservations/{{ $reservation->id }}" method="POST">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label>Medewerker:</label>
            <input type="text" name="employee_name" value="{{ $reservation->employee_name }}" required>
        </div>

        <div class="form-group">
            <label>Inventaris Item:</label>
            <select name="inventaris" required>
                <option value="">-- Kies een item --</option>
                @foreach($inventarisItems as $item)
                    <option value="{{ $item->naam }}" 
                        {{ (old('inventaris', $reservation->inventaris) == $item->naam) ? 'selected' : '' }}>
                        {{ $item->naam }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label>Datum:</label>
            <input type="date" name="date" value="{{ $reservation->date }}" required>
        </div>

        <div class="form-group">
            <label>Tijd:</label>
            <input type="time" name="time" value="{{ $reservation->time }}" required>
        </div>

        <div class="form-group">
            <label>Status:</label>
            <select name="status" required>
                <option value="Bevestigd" {{ $reservation->status == 'Bevestigd' ? 'selected' : '' }}>Bevestigd</option>
                <option value="Geannuleerd" {{ $reservation->status == 'Geannuleerd' ? 'selected' : '' }}>Geannuleerd</option>
                <option value="In Afwachting" {{ $reservation->status == 'In Afwachting' ? 'selected' : '' }}>In Afwachting</option>
            </select>
        </div>

        <button type="submit">Opslaan</button>
    </form>

    <p><a href="/">Terug naar overzicht</a></p>
</body>
</html>
