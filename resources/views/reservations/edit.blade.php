<!DOCTYPE html>
<html>
<head>
    <title>Reservering Bewerken</title>
    <style>
        label {
            display: block;
            margin-top: 10px;
        }
        input {
            padding: 5px;
            width: 300px;
        }
        button {
            margin-top: 15px;
            padding: 7px 15px;
        }
        .error {
            color: red;
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

        <label>Medewerker:</label>
        <input type="text" name="employee_name" value="{{ $reservation->employee_name }}" required>

        <label>Item:</label>
        <input type="text" name="item_name" value="{{ $reservation->item_name }}" required>

        <label>Datum:</label>
        <input type="date" name="date" value="{{ $reservation->date }}" required>

        <label>Tijd:</label>
        <input type="time" name="time" value="{{ $reservation->time }}" required>

        <label>Status:</label>
        <select name="status" required>
            <option value="Bevestigd" {{ $reservation->status == 'Bevestigd' ? 'selected' : '' }}>Bevestigd</option>
            <option value="Geannuleerd" {{ $reservation->status == 'Geannuleerd' ? 'selected' : '' }}>Geannuleerd</option>
            <option value="In Afwachting" {{ $reservation->status == 'In Afwachting' ? 'selected' : '' }}>In Afwachting</option>
        </select>

        <button type="submit">Opslaan</button>
    </form>

    <p><a href="/">Terug naar overzicht</a></p>
</body>
</html>
