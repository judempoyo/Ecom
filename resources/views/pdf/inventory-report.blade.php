<!DOCTYPE html>
<html>
<head>
    <title>Rapport d'inventaire</title>
    <style>
        body { font-family: Arial, sans-serif; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
        .header { text-align: center; margin-bottom: 20px; }
        .period { margin-bottom: 20px; }
    </style>
</head>
<body>
    <div class="header">
        <h1>Rapport d'inventaire</h1>
        <div class="period">
            Période du {{ \Carbon\Carbon::parse($start_date)->format('d/m/Y') }} 
            au {{ \Carbon\Carbon::parse($end_date)->format('d/m/Y') }}
        </div>
    </div>

    <table>
        <thead>
            <tr>
                <th>Date</th>
                <th>Produit</th>
                <th>Quantité</th>
                <th>Type</th>
                <th>Notes</th>
            </tr>
        </thead>
        <tbody>
            @foreach($inventories as $inventory)
            <tr>
                <td>{{ $inventory->created_at->format('d/m/Y H:i') }}</td>
                <td>{{ $inventory->product->name }}</td>
                <td>{{ $inventory->quantity }}</td>
                <td>{{ $inventory->movement_type === 'in' ? 'Entrée' : 'Sortie' }}</td>
                <td>{{ $inventory->notes }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>