<!DOCTYPE html>
<html>
<head>
    <title>Reserveringssysteem</title>
    <style>
        table {
            border-collapse: collapse;
            width: 100%;
            margin-top: 20px;
        }
        th, td {
            border: 1px solid #999;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #eee;
        }
        a, button {
            margin-right: 5px;
        }
        .success {
            color: green;
        }
        .error {
            color: red;
        }
    </style>
</head>
<body>
    <h1>Reserveringssysteem</h1>

@if(session('success'))
    <div style="color: green; margin-bottom: 15px;">
        {{ session('success') }}
    </div>
@endif

@if($errors->any())
    <div style="color: red; margin-bottom: 15px;">
        {{ $errors->first() }}
    </div>
@endif


    <!-- Link naar nieuwe reservering -->
    <a href="/reservations/create">Nieuwe Reservering</a>

    <!-- Tabel met reserveringen -->
    <table>
        <thead>
            <tr>
                <th>Medewerker</th>
                <th>Item</th>
                <th>Datum</th>
                <th>Tijd</th>
                <th>Acties</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach($reservations as $reservation)
                <tr>
                    <td>{{ $reservation->employee_name }}</td>
                    <td>{{ $reservation->inventaris }}</td>
                    <td>{{ $reservation->date }}</td>
                    <td>{{ $reservation->time }}</td>
                    <td>{{ $reservation->status }}</td>
                    <td>
                        <a href="/reservations/{{ $reservation->id }}/edit">Bewerken</a>
                        <form action="/reservations/{{ $reservation->id }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" onclick="return confirm('Weet je het zeker?')">Verwijderen</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
