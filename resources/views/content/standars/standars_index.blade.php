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
                                    @if(session('roleUserLogin') === 'admin')
                                        <a class="btn btn-info mb-1" title="Edit Standar" href="#" data-toggle="modal"
                                           data-backdrop="static" data-keyboard="false"
                                           data-target="#editStandar{{$standar->id}}"><i
                                                class="fa fa-edit"></i></a>
                                    @endif

                                    <a class="btn btn-primary mb-1" title="Pilih Tahun Target" data-toggle="modal"
                                       data-target="#pilihTahunTarget{{$standar->id}}"
                                       href="#"><i class="fa fa-eye"></i></a>

                                    <a class="btn btn-warning mb-1" title="Export PDF" data-toggle="modal"
                                       data-backdrop="static" data-keyboard="false"
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
                            <button type="button" class="btn btn-danger" data-dismiss="modal">Batal <span class="btn-icon-right"><i class="fa fa-close"></i></span></button>
                            <button type="submit" class="btn btn-success">Simpan <span class="btn-icon-right"><i class="fa fa-save"></i></span></button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

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
                            <button type="button" class="btn btn-danger" data-dismiss="modal">Batal <span class="btn-icon-right"><i class="fa fa-close"></i></span></button>
                            <button type="submit" class="btn btn-secondary">Pilih <span class="btn-icon-right"><i class="fa fa-check"></i></span></button>
                        </div>
                    </form>
                </div>
            </div>
        </div>


        <!-- Modal Export to PDF -->
        <div class="modal fade" id="exportPdf{{$standar_row->id}}">
            <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Pilih Tahun Target</h5>
                        <button type="button" class="close" data-dismiss="modal"><span>&times;</span>
                        </button>
                    </div>
                    <form action="{{route('export.standar.pdf', [$standar_row->nama_standar, $standar_row->id])}}"
                          method="get">
                        @csrf
                        <div class="modal-body">
                            <div class="form-group row">
                                <label style="color: #222f3e" class="col-lg-2 col-form-label" for="val-username">Pilih
                                    Tahun Awal
                                    <span class="text-danger">*</span>
                                </label>
                                <div class="col">
                                    <select class="form-control" name="tahun_awal" required>
                                        <option value="">Pilih Tahun Target</option>
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
                                    <span class="text-danger">*</span>
                                </label>
                                <div class="col">
                                    <select class="form-control" name="tahun_akhir" required>
                                        <option value="">Pilih Tahun Target</option>
                                        @foreach($target_waktu as $targetWaktu)
                                            <option
                                                value="{{$targetWaktu->tahun_target}}">{{$targetWaktu->tahun_target}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger" data-dismiss="modal">Batal <span class="btn-icon-right"><i class="fa fa-close"></i></span></button>
                            <button type="submit" class="btn btn-primary">Export <span class="btn-icon-right"><i class="fa fa-file-pdf-o"></i></span></button>
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

            @if(session('message-fail-export'))

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
        toastr.error("{{session('message-fail-export')}}", "Failed")
        @endif
    </script>

@endsection
