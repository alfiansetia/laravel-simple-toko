<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Pesanan {{ $data->code }}</title>
    <style>
        table {
            border-spacing: 0;
            border: 1px solid black;
            border-collapse: collapse;
            width: 100%;
        }

        th,
        td {
            border: 1px solid black;
            padding: 6px;
            font-size: 12px;
        }

        th {
            background-color: #eee;
        }
    </style>
</head>

<body>
    <h1 style="text-align: center">{{ config('app.name') }}</h1>
    <h3 style="text-align: center">{{ config('services.company_address') }} ({{ config('services.whatsapp_admin') }})
    </h3>
    <h4>Pemesan : {{ $data->user->name }}/{{ $data->user->whatsapp }}</h4>
    <h4>No Order : {{ $data->code }}</h4>
    <h4>Tanggal/Jam : {{ $data->date }}</h4>
    <h4>Total : {{ hrg($data->total) }}</h4>
    <h4>Status Pesanan : {{ $data->status }}</h4>
    <table>
        <thead>
            <tr>
                <th style="text-align: center">No</th>
                <th>Produk</th>
                <th style="text-align: center">Harga</th>
                <th style="text-align: center">Qty</th>
                <th style="text-align: center">Subtotal</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($data->items as $key => $item)
                <tr>
                    <td style="text-align: center">{{ $key + 1 }}</td>
                    <td>{{ $item->product->name }}</td>
                    <td style="text-align: center">{{ hrg($item->price) }}</td>
                    <td style="text-align: center">{{ $item->qty }}</td>
                    <td style="text-align: center">{{ hrg($item->price * $item->qty) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <br>
    <br>
    <h4 style="text-align: center;">___Terima Kasih___</h4>
</body>

</html>
