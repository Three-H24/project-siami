@extends('layout.main')
@section('content')
    <div class="col">
        <form action="{{route('ami.filter')}}" method="get">
            @csrf
            <div class="col">
                <div class="row ">
                    <div class="col-2">
                        <div class="form-group row">
                            <select class="form-control" name="tahun_target" required>
                                <option selected>Pilih Tahun Target</option>
                                @foreach($target_waktu as $targetWaktu)
                                    <option
                                        value="{{$targetWaktu->tahun_target}}">{{$targetWaktu->tahun_target}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="col-3">
                        <div class="form-group row">
                            <select class="form-control ml-1" name="standar" required>
                                <option selected>Pilih Standar</option>
                                @foreach($standars as $standar)
                                    <option value="{{$standar->id}}">{{$standar->nama_standar}}</option>
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

        <div class="card">
            <div class="card-header">
                <h4 class="card-title">{{$title}} Table</h4>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="example" class="display" style="min-width: 894px; text-align: center">
                        <thead>
                        <tr>
                            <th>No.</th>
                            <th>Nama Standar</th>
                            <th>Tahun Target</th>
                            <th>Dokumen/Data Pendukung AMI</th>
                            <th>Capaian</th>
                            <th>Keterangan Capaian</th>
                            <th>Faktor Pendukung</th>
                            <th>Faktor Penghambat</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody style="color: black">
                        @php($i = 1)
                        @foreach($amies as $ami)
                            <tr>
                                <td>{{$i++}}</td>
                                <td>{{}}</td>
                                <td>{{}}</td>
                                <td>{{}}</td>
                                <td>{{}}</td>
                                <td>{{}}</td>
                                <td>{{}}</td>
                                <td>{{}}</td>
                                <td>{{}}</td>
                                <td></td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection()
