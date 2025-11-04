<!DOCTYPE html>
<html>
<head>
    <title>Nieuwe Reservering</title>
    <style>
        form input, form button {
            display: block;
            margin: 10px 0;
            padding: 5px;
        }
        .error {
            color: red;
            margin-bottom: 15px;
        }
    </style>
</head>
<body>
    <h1>Nieuwe Reservering</h1>

    <!-- Foutmeldingen tonen -->
    @if($errors->any())
        <div class="error">
            {{ $errors->first() }}
        </div>
    @endif

    <form action="/reservations" method="POST">
        @csrf
        <input type="text" name="employee_name" placeholder="Naam medewerker" value="{{ old('employee_name') }}" required>
        <input type="text" name="item_name" placeholder="Item" value="{{ old('item_name') }}" required>
        <input type="date" name="date" value="{{ old('date') }}" required>
        <input type="time" name="time" value="{{ old('time') }}" required>
        <button type="submit">Reserveren</button>
    </form>

    <!-- Terug naar home knop -->
    <form action="/" method="get" style="margin-top:20px;">
        <button type="submit">Terug naar overzicht</button>
    </form>
</body>
</html>
