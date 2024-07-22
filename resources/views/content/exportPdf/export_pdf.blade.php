<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Export PDF | {{$title}}</title>

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
<h3 style="text-align: left; background-color: yellow; padding-left: 5px">INDIKATOR PENCAPAIAN {{$title}}</h3>
<table>
    <thead>
    <tr style="text-align: center">
        <th rowspan="2">Butir Pernyataan</th>
        <th rowspan="2">Indikator</th>
        <th rowspan="2">Satuan</th>
        <th colspan="{{$totalYear}}">Target/Waktu</th>
        <th rowspan="2">Dokumen Pendukung</th>
    </tr>
    </thead>
    <tbody>
    <tr>
        @for ($year = $startYear; $year <= $endYear; $year++)
            <th class="nowrap">{{ $year }}/{{ $year + 1 }}</th>
        @endfor
    </tr>
    @php($i = 1)
    @foreach ($standars->indikator as $indikator)
        <tr>
            <td style="text-align: center">{{$i++}}</td>
            <td>{{ $indikator->butir_indikator }}</td>
            <td>{{ $indikator->satuan }}</td>
            @for ($year = $startYear; $year <= $endYear; $year++)
                <td class="nowrap">
                    @if ($indikator->target_waktu->contains('tahun_target', $year))
                        ada
                    @else
                        -
                    @endif
                </td>
            @endfor
            <td>
                @foreach ($indikator->dokumen_pendukung as $dokumen)
                    {{$dokumen->nama_dokumen}}
                @endforeach

            </td>
        </tr>
    @endforeach
    </tbody>
</table>
</body>
</html>
