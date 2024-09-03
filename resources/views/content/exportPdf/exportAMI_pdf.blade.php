<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Export AMI PDF | {{$title}}</title>

    <style>
        table {
            width: 100%;
            border-collapse: collapse;
            font-family: Arial, sans-serif;
            font-size: 12px;
        }

        th, td {
            border: 1px solid black;
            padding: 8px;
        }

        th {
            background-color: #f2f2f2;
        }

        .nowrap {
            white-space: nowrap;
        }
    </style>

</head>
<body>
<h2 style="text-align: center; font-weight: bold">Laporan Hasil Audit Mutu Internal</h2>
<h3 style="text-align: center;">INDIKATOR PENCAPAIAN {{$title}}</h3>
<p>Tahun Target: {{$tahunTarget}}</p>
<table>
    <thead>
    <tr style="text-align: center">
        <th>Butir Pernyataan</th>
        <th>Indikator</th>
        <th>Satuan</th>
        <th>Tahun Target/Waktu</th>
        <th>Target</th>
        @foreach ($selectedColumns as $kolom)
            <th>{{ ucwords(str_replace('_', ' ', $kolom)) }}</th>
        @endforeach
        <th>Dokumen Pendukung</th>
    </tr>
    </thead>
    <tbody>
    @php($i = 1)
    @foreach ($amies as $ami)
        <tr>
            <td style="text-align: center">{{$i++}}</td>
            <td>{{ $ami->indikator->butir_indikator }}</td>
            <td>{{ $ami->indikator->satuan }}</td>
            <td>{{ $tahunTarget }}</td>
            <td>
               {{ $ami->target_waktu->keterangan_target }}
            </td>
            @foreach ($selectedColumns as $kolom)
                <td>{{ $ami->$kolom ?? '-' }}</td>
            @endforeach
            <td>
                @foreach ($ami->indikator->dokumen_pendukung as $dokumen)
                    {{$dokumen->nama_dokumen}}
                @endforeach
            </td>
        </tr>
    @endforeach
    </tbody>
</table>
</body>
</html>
