<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
        }

        h2 {
            text-align: center;
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th {
            background: #f0f0f0;
            font-weight: bold;
        }

        th, td {
            border: 1px solid #ccc;
            padding: 6px;
            text-align: left;
        }

        .badge {
            padding: 3px 6px;
            border-radius: 4px;
            color: #fff;
            font-size: 10px;
        }

        .success { background: #28a745; }
        .danger { background: #dc3545; }
        .warning { background: #ffc107; color: #000; }
        .info { background: #007bff; }
    </style>
</head>

<body>

<h2>Reporte de Clientes</h2>

<table>
    <thead>
        <tr>
            <th>Nombre</th>
            <th>Teléfono</th>
            <th>Estado Cliente</th>
            <th>Estado Proceso</th>
            <th>Fecha</th>
        </tr>
    </thead>

    <tbody>
        @foreach($data as $item)
            @php
                $proceso = $item->processes->first();
            @endphp

            <tr>
                <td>{{ $item->Nombre }}</td>
                <td>{{ $item->Telefono }}</td>

                <td>
                    <span class="badge {{ $item->EstadoCustomer === 'Pago' ? 'success' : 'danger' }}">
                        {{ $item->EstadoCustomer }}
                    </span>
                </td>

                <td>
                    @if($proceso)
                        <span class="badge
                            {{ $proceso->Estado === 'Entregado' ? 'success' :
                               ($proceso->Estado === 'Derivado' ? 'info' : 'warning') }}">
                            {{ $proceso->Estado }}
                        </span>
                    @else
                        <span class="badge warning">Sin proceso</span>
                    @endif
                </td>

                <td>
                    {{ $proceso->Fecha ?? '-' }}
                </td>
            </tr>
        @endforeach
    </tbody>

</table>

</body>
</html>