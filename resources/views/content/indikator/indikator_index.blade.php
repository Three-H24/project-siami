@extends('layout.main')
@section('content')
    <div class="col">
        <form action="{{ route('indikator.index') }}" method="GET">
            @csrf
            <div class="col">
                <div class="row">
                    <div class="col-3">
                        <div class="form-group row">
                            <select class="form-control ml-1" name="standar_id">
                                <option value="">-- Pilih Standar --</option>
                                @foreach($allStandar as $standar)
                                    <option value="{{$standar->id}}" {{isset($standarId) && $standarId == $standar->id ? 'selected' : ''}}>{{$standar->nama_standar}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="col-3">
                        <button class="btn btn-primary" type="submit">Filter</button>
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
                    <table id="example" class="display" style="min-width: 845px">
                        <thead>
                        <tr>
                            <th>No.</th>
                            <th>Nama Standar</th>
                            <th>Butir Indikator</th>
                            <th>Satuan</th>
                            <th>Target/Waktu</th>
                            <th>Dokumen Pendukung</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody style="color: black">
                        @php($i = 1)
                        @foreach($indikators as $indikator)
                            <tr>
                                <td>{{$i++}}</td>
                                <td>{{$indikator->standar->nama_standar}}</td>
                                <td>{{$indikator->butir_indikator}}</td>
                                <td>{{$indikator->satuan}}</td>
                                <td>
                                    @foreach($indikator->target_waktu as $target)
                                        <p>{{$target->tahun_target}}: <strong>{{$target->keterangan_target}}</strong>
                                        </p>
                                    @endforeach
                                </td>
                                <td>
                                    @foreach($indikator->dokumen_pendukung as $doc)
                                        <a href="{{URL::asset($doc->dokumen_pendukung)}}" target="_blank"
                                           style="color: #0a88f7">{{$doc->nama_dokumen}}</a>
                                        <br>
                                    @endforeach
                                </td>
                                <td>
                                    <a class="btn btn-info mb-1" href="#" data-toggle="modal"
                                       data-backdrop="static" data-keyboard="false"
                                       data-target="#editIndikator{{$indikator->id}}"><i
                                                class="fa-regular fa-edit"></i>
                                    </a>

                                    <a class="btn btn-info mb-1" href="#" data-toggle="modal"
                                       data-backdrop="static" data-keyboard="false"
                                       data-target="#tambahTarget{{$indikator->id}}"><i
                                                class="mdi mdi-calendar-plus"></i></a>

                                    <a class="btn btn-info mb-1" href="#" data-toggle="modal"
                                       data-backdrop="static" data-keyboard="false"
                                       data-target="#editTahunTarget{{$indikator->id}}"><i
                                                class="mdi mdi-calendar-edit"></i>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        @foreach($indikators as $indikator_row)
            <!-- Modal Edit Indikator -->
            <div class="modal fade" id="editIndikator{{$indikator_row->id}}">
                <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Edit data indikator</h5>
                            <button type="button" class="close" data-dismiss="modal"><span>&times;</span>
                            </button>
                        </div>
                        <form action="{{route('indikator.edit', $indikator_row->id)}}" method="post"
                              enctype="multipart/form-data">
                            @csrf
                            <div class="modal-body">
                                <div class="form-group row">
                                    <label style="color: #222f3e" class="col-lg-2 col-form-label" for="val-username">Butir
                                        Indikator
                                        <span class="text-danger">*</span>
                                    </label>
                                    <div class="col">
                                    <textarea name="butir_indikator" class="form-control"
                                              rows="4">{{$indikator_row->butir_indikator}}</textarea>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label style="color: #222f3e" class="col-lg-2 col-form-label" for="val-username">Satuan
                                        Indikator
                                        <span class="text-danger">*</span>
                                    </label>
                                    <div class="col">
                                        <input type="text" name="satuan"
                                               class="form-control input-rounded"
                                               value="{{$indikator_row->satuan}}" required>
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

        @foreach($indikators as $indikator_row)
            <!-- Modal Tambah Tahun Target Indikator -->
            <div class="modal fade" id="tambahTarget{{$indikator_row->id}}">
                <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Tambah target</h5>
                            <button type="button" class="close" data-dismiss="modal"><span>&times;</span>
                            </button>
                        </div>
                        <form action="{{route('indikator.add.target', $indikator_row->id)}}" method="post"
                              enctype="multipart/form-data">
                            @csrf
                            <div class="modal-body">
                                <div class="form-group row">
                                    <label style="color: #222f3e" class="col-lg-2 col-form-label" for="val-username">Butir
                                        Indikator
                                        <span class="text-danger">*</span>
                                    </label>
                                    <div class="col">
                                    <textarea name="butir_indikator" class="form-control" rows="4"
                                              readonly>{{$indikator_row->butir_indikator}}</textarea>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label style="color: #222f3e" class="col-lg-2 col-form-label" for="val-username">Target
                                        waktu
                                        <span class="text-danger">*</span>
                                    </label>
                                    <div class="col">
                                        <input type="number" name="tanggal_target"
                                               class="form-control input-rounded" placeholder="Masukan tahun target...">
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label style="color: #222f3e" class="col-lg-2 col-form-label" for="val-username">Keterangan
                                        Target
                                        <span class="text-danger">*</span>
                                    </label>
                                    <div class="col">
                                        <input type="text" name="keterangan_target"
                                               class="form-control input-rounded"
                                               placeholder="Masukan keterangan target..." required>
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

        @foreach($indikators as $indikator_row)
            <!-- Modal Edit Tahun Target -->
            <div class="modal fade" id="editTahunTarget{{$indikator_row->id}}">
                <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Edit Tahun Target</h5>
                            <button type="button" class="close" data-dismiss="modal"><span>&times;</span>
                            </button>
                        </div>
                        <form action="{{route('indikator.edit.tahun.target', $indikator_row->id)}}" method="post"
                              enctype="multipart/form-data">
                            @csrf
                            <div class="modal-body">
                                <div class="form-group row">
                                    <label style="color: #222f3e" class="col-lg-2 col-form-label" for="val-username">Pilih
                                        Target
                                        <span class="text-danger">*</span>
                                    </label>
                                    <div class="col">
                                        <select class="form-control" name="target_waktu" required>
                                            <option value="">Pilih Tahun Target</option>
                                            @foreach($indikator_row->target_waktu as $targetWaktu)
                                                <option
                                                        value="{{$targetWaktu->id}}">{{$targetWaktu->tahun_target}}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label style="color: #222f3e" class="col-lg-2 col-form-label" for="val-username">Keterangan
                                        Target Baru
                                        <span class="text-danger">*</span>
                                    </label>
                                    <div class="col">
                                        <input type="text" name="keterangan_target"
                                               class="form-control input-rounded"
                                               placeholder="Masukan keterangan target baru..." required>
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
    </div>

    <script>
        @if(session('message'))

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
        toastr.success("{{session('message')}}", "Success")
        @endif

                @if(session('message-target'))

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
        toastr.success("{{session('message-target')}}", "Success")
        @endif

            @if($errors->any())
                @foreach($errors->all() as $error)

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

                    toastr.error("{{$error}}", "Failed")
                @endforeach
            @endif

                @if(session('message-fail-add-target'))

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
        toastr.error("{{session('message-fail-add-target')}}", "Failed")
        @endif

                @if(session('message-edit-tahun'))

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
        toastr.success("{{session('message-edit-tahun')}}", "Success")
        @endif
    </script>
@endsection()
