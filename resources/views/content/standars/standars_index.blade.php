@extends('layout.main')
@section('content')
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">{{$title}} Table</h4>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="example" class="display" style="min-width: 845px">
                        <thead>
                        <tr>
                            <th>No.</th>
                            <th>Nama Standar</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody style="color: black">
                        @php($i = 1)
                        @foreach($standars as $standar)
                            <tr>
                                <td>{{$i++}}</td>
                                <td>{{$standar->nama_standar}}</td>
                                <td>
                                    <a class="btn btn-info mb-1" href="#" data-toggle="modal"
                                       data-target="#editStandar{{$standar->id}}"><i
                                            class="fa fa-edit"></i></a>

                                    <a class="btn btn-info mb-1" data-toggle="modal"
                                       data-target="#pilihTahunTarget{{$standar->id}}"
                                       href="#"><i class="fa fa-eye"></i></a>

                                    <a class="btn btn-info mb-1" data-toggle="modal"
                                       data-target="#exportPdf{{$standar->id}}"
                                       href="#"><i class="fa fa-file-pdf-o"></i></a>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    @foreach($standars as $standar_row)
        <!-- Modal Edit Standar -->
        <div class="modal fade" id="editStandar{{$standar_row->id}}">
            <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Edit data standar</h5>
                        <button type="button" class="close" data-dismiss="modal"><span>&times;</span>
                        </button>
                    </div>
                    <form action="{{route('standar.edit', $standar_row->id)}}" method="post"
                          enctype="multipart/form-data">
                        @csrf
                        <div class="modal-body">
                            <div class="form-group row">
                                <label style="color: #222f3e" class="col-lg-2 col-form-label" for="val-username">Nama
                                    Standar
                                    <span class="text-danger">*</span>
                                </label>
                                <div class="col">
                                    <input type="text" name="nama_standar" class="form-control input-rounded"
                                           value="{{$standar_row->nama_standar}}" required>
                                </div>
                            </div>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endforeach

    @foreach($standars as $standar_row)
        <!-- Modal Pilih Tahun Target -->
        <div class="modal fade" id="pilihTahunTarget{{$standar_row->id}}">
            <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Pilih Tahun Target</h5>
                        <button type="button" class="close" data-dismiss="modal"><span>&times;</span>
                        </button>
                    </div>
                    <form action="{{route('stndr.indktr.index', [$standar_row->nama_standar, $standar_row->id])}}"
                          method="get">
                        @csrf
                        <div class="modal-body">
                            <div class="form-group row">
                                <label style="color: #222f3e" class="col-lg-2 col-form-label" for="val-username">Pilih
                                    Tahun Target
                                </label>
                                <div class="col">
                                    <select class="form-control" name="tahun_target" required>
                                        <option selected>Pilih Tahun Target</option>
                                        @foreach($target_waktu as $targetWaktu)
                                            <option
                                                value="{{$targetWaktu->tahun_target}}">{{$targetWaktu->tahun_target}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Pilih</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endforeach

    @foreach($standars as $standar_row)
        <!-- Modal Pilih Tahun Target -->
        <div class="modal fade" id="exportPdf{{$standar_row->id}}">
            <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Pilih Tahun Target</h5>
                        <button type="button" class="close" data-dismiss="modal"><span>&times;</span>
                        </button>
                    </div>
                    <form action="{{route('export.pdf.index', [$standar_row->nama_standar, $standar_row->id])}}"
                          method="get">
                        @csrf
                        <div class="modal-body">
                            <div class="form-group row">
                                <label style="color: #222f3e" class="col-lg-2 col-form-label" for="val-username">Pilih
                                    Tahun Awal
                                </label>
                                <div class="col">
                                    <select class="form-control" name="tahun_awal" required>
                                        <option selected>Pilih Tahun Target</option>
                                        @foreach($target_waktu as $targetWaktu)
                                            <option
                                                value="{{$targetWaktu->tahun_target}}">{{$targetWaktu->tahun_target}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label style="color: #222f3e" class="col-lg-2 col-form-label" for="val-username">Pilih
                                    Tahun Akhir
                                </label>
                                <div class="col">
                                    <select class="form-control" name="tahun_akhir" required>
                                        <option selected>Pilih Tahun Target</option>
                                        @foreach($target_waktu as $targetWaktu)
                                            <option
                                                value="{{$targetWaktu->tahun_target}}">{{$targetWaktu->tahun_target}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Pilih</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endforeach


    <script>
        @if(session('message-edit'))

            toastr.options = {
            positionClass: "toast-top-right",
            timeOut: 5e3,
            closeButton: !0,
            debug: !1,
            newestOnTop: !0,
            progressBar: !0,
            preventDuplicates: !0,
            onclick: null,
            showDuration: "300",
            hideDuration: "1000",
            extendedTimeOut: "1000",
            showEasing: "swing",
            hideEasing: "linear",
            showMethod: "fadeIn",
            hideMethod: "fadeOut",
            tapToDismiss: !1
        }
        toastr.success("{{session('message-edit')}}", "Success")
        @endif

            @if(session('message-fail-get-indktr'))

            toastr.options = {
            positionClass: "toast-top-right",
            timeOut: 5e3,
            closeButton: !0,
            debug: !1,
            newestOnTop: !0,
            progressBar: !0,
            preventDuplicates: !0,
            onclick: null,
            showDuration: "300",
            hideDuration: "1000",
            extendedTimeOut: "1000",
            showEasing: "swing",
            hideEasing: "linear",
            showMethod: "fadeIn",
            hideMethod: "fadeOut",
            tapToDismiss: !1
        }
        toastr.error("{{session('message-fail-get-indktr')}}", "Failed")
        @endif
    </script>

@endsection
