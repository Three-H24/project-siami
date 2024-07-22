@extends('layout.main')
@section('content')
    <div class="col">
        <form action="{{route('ami.dashboard.filter')}}" method="get">
            @csrf
            <div class="col">
                <div class="row ">
                    <div class="col-2">
                        <div class="form-group row">
                            <select class="form-control" name="tahun_target" required>
                                <option>Pilih Tahun Target</option>
                                @foreach($targets as $targetWaktu)
                                    <option
                                        value="{{$targetWaktu->tahun_target}}" {{isset($tahunTarget) && $tahunTarget == $targetWaktu->tahun_target ? 'selected' : ''}}>{{$targetWaktu->tahun_target}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="col-3">
                        <div class="form-group row">
                            <select class="form-control ml-1" name="standar" required>
                                <option>Pilih Standar</option>
                                @foreach($standars as $standar)
                                    <option
                                        value="{{$standar->id}}" {{isset($standarId) && $standarId == $standar->id ? 'selected' : ''}}>{{$standar->nama_standar}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="col-2">
                        <button type="submit" class="btn btn-primary ">Submit</button>
                    </div>

                </div>
            </div>
        </form>

        <div class="row">
            @if(isset($dataChart))
                <div class="col-lg-6 col-sm-6">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">{{ $standars->find($standarId)->nama_standar }}
                                | AMI {{ $tahunTarget }}</h4>
                        </div>
                        <div class="card-body">
                            <canvas id="barChart_1-{{Str::slug($standars->find($standarId)->nama_standar)}}"></canvas>
                        </div>
                    </div>
                </div>
            @endif

            @if(isset($dataChart))
                <script>
                    var ctx = document.getElementById('barChart_1-{{Str::slug($standars->find($standarId)->nama_standar)}}').getContext('2d');

                    new Chart(ctx, {
                        type: 'bar',
                        data: {
                            defaultFontFamily: 'Poppins',
                            labels: ['Tercapai', 'Tidak Tercapai'],
                            datasets: [
                                {
                                    label: 'AMI {{$tahunTarget}}',
                                    data: [{{ $dataChart['total_tercapai'] }}, {{ $dataChart['total_tidak_tercapai'] }}],
                                    borderColor: ['#8854d0', '#c0392b'],
                                    borderWidth: "1",
                                    backgroundColor: ['#9980FA', '#e74c3c']
                                }
                            ]
                        },
                        options: {
                            scales: {
                                y: {
                                    beginAtZero: true
                                }
                            }
                        }
                    });
                </script>
            @endif

        </div>
    </div>

@endsection()
