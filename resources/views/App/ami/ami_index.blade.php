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
                                <option>Pilih Tahun Target</option>
                                @foreach($target_waktu as $targetWaktu)
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

                    <div class="col">
                        <button type="submit" class="btn btn-primary">Submit</button>

                        <a class="btn btn-warning" title="Export PDF" data-toggle="modal"
                           data-backdrop="static" data-keyboard="false" style="float: right;"
                           data-target="#exportPdf" href="#">Export PDF <span class="btn-icon-right"><i class="fa fa-file-pdf-o"></i></span></a>
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
                    <table class="table table-bordered table-striped table-responsive-lg">
                        <thead style="text-align: center; color: black">
                        <tr>
                            <th>No.</th>
                            <th>Nama Standar</th>
                            <th>Butir Indikator</th>
                            <th>Tahun Target/Waktu</th>
                            <th>Target</th>
                            <th>Dokumen/Data Pendukung</th>
                            <th>Capaian</th>
                            <th>Keterangan Capaian</th>
                            <th>Faktor Pendukung</th>
                            <th>Faktor Penghambat</th>
                            <th>Peningkatan</th>
                            <th>Tanggal Audit</th>
                            <th>User Audit</th>
                            @if(session('roleUserLogin') === 'admin')
                                <th>Action</th>
                            @endif
                        </tr>
                        </thead>
                        <tbody style="color: black">
                        @php($i = 1)
                        @forelse($amies as $ami)
                            <tr>
                                <td>{{$i++}}</td>
                                <td>{{$ami->standars->nama_standar}}</td>
                                <td>
                                    {{str_word_count($ami->indikator->butir_indikator) > 60 ?
                                        substr($ami->indikator->butir_indikator,0,200)."[...]" : $ami->indikator->butir_indikator}}
                                </td>
                                <td>{{$ami->target_waktu->tahun_target}}</td>
                                <td>{{$ami->target_waktu->keterangan_target}}</td>
                                <td>
                                    @foreach($ami->indikator->dokumen_pendukung as $doc)
                                        <a href="{{URL::asset($doc->dokumen_pendukung)}}" target="_blank"
                                           style="color: #0a88f7">{{$doc->nama_dokumen}}</a>
                                        <br>
                                    @endforeach
                                </td>
                                <td>{{$ami->capaian}}</td>
                                <td>{{$ami->keterangan_capaian}}</td>
                                <td>{{$ami->faktor_pendukung}}</td>
                                <td>{{$ami->faktor_penghambat}}</td>
                                <td>{{$ami->keterangan_peningkatan}}</td>
                                <td>{{$ami->tanggal_audit}}</td>
                                <td>{{$ami->user_audit}}</td>
                                @if(session('roleUserLogin') === 'admin')
                                    <td>
                                        <a class="btn btn-info mb-1" title="Edit AMI" href="#" data-toggle="modal"
                                           data-backdrop="static" data-keyboard="false"
                                           data-target="#editAMI{{$ami->id}}"><span><i
                                                    class="fa fa-edit"></i></span></a>

                                        @if($ami->capaian === "Tercapai")
                                            <a class="btn btn-success" title="Peningkatan" href="#" data-toggle="modal"
                                               data-backdrop="static" data-keyboard="false"
                                               data-target="#peningkatan{{$ami->id}}">
                                                <i class="fa fa-thumbs-up"></i></a>
                                        @endif
                                    </td>
                                @endif
                            </tr>
                        @empty
                            <tr>
                                <td colspan="11" class="text-center">Data tidak ditemukan!</td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    @foreach($amies as $ami_row)
        <!-- Modal Edit AMI -->
        <div class="modal fade" id="editAMI{{$ami_row->id}}">
            <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Edit AMI</h5>
                        <button type="button" class="close" data-dismiss="modal"><span>&times;</span>
                        </button>
                    </div>
                    <form
                        action="{{route('ami.edit', $ami_row->id)}}"
                        method="post">
                        @csrf
                        <div class="modal-body">
                            <div class="form-group row">
                                <label style="color: #222f3e" class="col-lg-2 col-form-label"
                                       for="val-username">Nama
                                    Standar
                                    <span class="text-danger">*</span>
                                </label>
                                <div class="col">
                                    <input type="text" name="satuan"
                                           class="form-control input-rounded"
                                           value="{{$ami_row->standars->nama_standar}}" readonly>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label style="color: #222f3e" class="col-lg-2 col-form-label"
                                       for="val-username">Butir
                                    Indikator
                                    <span class="text-danger">*</span>
                                </label>
                                <div class="col">
                                        <textarea name="butir_indikator" class="form-control" readonly
                                                  rows="4">{{$ami_row->indikator->butir_indikator}}</textarea>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label style="color: #222f3e" class="col-lg-2 col-form-label"
                                       for="val-username">Satuan
                                    Indikator
                                    <span class="text-danger">*</span>
                                </label>
                                <div class="col">
                                    <input type="text" name="satuan"
                                           class="form-control input-rounded"
                                           value="{{$ami_row->indikator->satuan}}" readonly>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label style="color: #222f3e" class="col-lg-2 col-form-label"
                                       for="val-username">Tahun
                                    Target
                                    <span class="text-danger">*</span>
                                </label>
                                <div class="col">
                                    <input type="text" name="tahun_target"
                                           class="form-control input-rounded"
                                           value="{{$ami_row->target_waktu->tahun_target}}" readonly>

                                    <input type="hidden" name="target_id" value="{{$ami_row->target_waktu->id}}">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label style="color: #222f3e" class="col-lg-2 col-form-label"
                                       for="val-username">Capaian
                                    <span class="text-danger">*</span>
                                </label>
                                <div class="col">
                                    <input type="text" name="tahun_target"
                                           class="form-control input-rounded"
                                           value="{{$ami_row->capaian}}" disabled>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label style="color: #222f3e" class="col-lg-2 col-form-label"
                                       for="val-username">Keterangan
                                    Capaian
                                    <span class="text-danger">*</span>
                                </label>
                                <div class="col">
                                    <textarea name="keterangan_capaian" class="form-control" disabled
                                              rows="4">{{$ami_row->keterangan_capaian}}</textarea>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label style="color: #222f3e" class="col-lg-2 col-form-label"
                                       for="val-username">Faktor Pendukung
                                    <span class="text-danger">*</span>
                                </label>
                                <div class="col">
                                    <textarea name="faktor_pendukung" class="form-control" required rows="4"></textarea>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label style="color: #222f3e" class="col-lg-2 col-form-label"
                                       for="val-username">Faktor Penghambat
                                    <span class="text-danger">*</span>
                                </label>
                                <div class="col">
                                    <textarea name="faktor_penghambat" class="form-control" required
                                              rows="4"></textarea>
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

        <!-- Modal Export to PDF -->
        <div class="modal fade" id="exportPdf">
            <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Export PDF</h5>
                        <button type="button" class="close" data-dismiss="modal"><span>&times;</span>
                        </button>
                    </div>
                    <form action="{{route('export.ami.pdf')}}" method="get">
                        @csrf
                        <div class="modal-body">
                            <div class="form-group row">
                                <label style="color: #222f3e" class="col-lg-2 col-form-label" for="val-username">Pilih
                                    Tahun Target
                                    <span class="text-danger">*</span>
                                </label>
                                <div class="col">
                                    <select class="form-control" name="tahun_target" required>
                                        <option value="" selected>Pilih Tahun Target</option>
                                        @foreach($target_waktu as $targetWaktu)
                                            <option
                                                value="{{$targetWaktu->tahun_target}}">{{$targetWaktu->tahun_target}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label style="color: #222f3e" class="col-lg-2 col-form-label" for="val-username">Pilih
                                    Standar
                                    <span class="text-danger">*</span>
                                </label>
                                <div class="col">
                                    <select class="form-control" name="standars" required>
                                        <option value="" selected>Pilih Standar</option>
                                        @foreach($standars as $standar)
                                            <option value="{{$standar->id}}">{{$standar->nama_standar}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="form-group row" style="color: #222f3e">
                                <div class="col-sm-2">Pilih kolom <span class="text-danger">*</span></div>
                                <div class="col">
                                    <div class="form-check form-check-inline">
                                        <label class="form-check-label">
                                            <input type="checkbox" name="kolom[]" class="form-check-input" value="capaian">Capaian
                                        </label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <label class="form-check-label">
                                            <input type="checkbox" name="kolom[]" class="form-check-input" value="keterangan_capaian">
                                            Keterangan Capaian
                                        </label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <label class="form-check-label">
                                            <input type="checkbox" name="kolom[]" class="form-check-input" value="faktor_penghambat">
                                            Faktor Penghambat
                                        </label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <label class="form-check-label">
                                            <input type="checkbox" name="kolom[]" class="form-check-input" value="faktor_pendukung">
                                            Faktor Pendukung
                                        </label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <label class="form-check-label">
                                            <input type="checkbox" name="kolom[]" class="form-check-input" value="keterangan_peningkatan">
                                            Peningkatan
                                        </label>
                                    </div>
                                </div>

                            </div>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger" data-dismiss="modal">Batal <span class="btn-icon-right"><i class="fa fa-close"></i></span></button>
                            <button type="submit" class="btn btn-success">Export <span class="btn-icon-right"><i class="fa fa-file-pdf-o"></i></span></button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Modal Tambah Keterangan Peningkatan -->
        <div class="modal fade" id="peningkatan{{$ami_row->id}}">
            <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Tambah Keterangan Peningkatan</h5>
                        <button type="button" class="close" data-dismiss="modal"><span>&times;</span>
                        </button>
                    </div>
                    <form action="{{route('ami.keterangan.peningkatan', $ami_row->id)}}" method="post">
                        @csrf
                        <div class="modal-body">

                            <div class="form-group row">
                                <label style="color: #222f3e" class="col-lg-2 col-form-label"
                                       for="val-username">Nama
                                    Standar
                                    <span class="text-danger">*</span>
                                </label>
                                <div class="col">
                                    <input type="text" name="satuan"
                                           class="form-control input-rounded"
                                           value="{{$ami_row->standars->nama_standar}}" readonly>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label style="color: #222f3e" class="col-lg-2 col-form-label"
                                       for="val-username">Butir
                                    Indikator
                                    <span class="text-danger">*</span>
                                </label>
                                <div class="col">
                                        <textarea name="butir_indikator" class="form-control" readonly
                                                  rows="4">{{$ami_row->indikator->butir_indikator}}</textarea>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label style="color: #222f3e" class="col-lg-2 col-form-label"
                                       for="val-username">Satuan
                                    Indikator
                                    <span class="text-danger">*</span>
                                </label>
                                <div class="col">
                                    <input type="text" name="satuan"
                                           class="form-control input-rounded"
                                           value="{{$ami_row->indikator->satuan}}" readonly>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label style="color: #222f3e" class="col-lg-2 col-form-label"
                                       for="val-username">Tahun
                                    Target
                                    <span class="text-danger">*</span>
                                </label>
                                <div class="col">
                                    <input type="text" name="tahun_target"
                                           class="form-control input-rounded"
                                           value="{{$ami_row->target_waktu->tahun_target}}" readonly>

                                    <input type="hidden" name="target_id" value="{{$ami_row->target_waktu->id}}">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label style="color: #222f3e" class="col-lg-2 col-form-label"
                                       for="val-username">Capaian
                                    <span class="text-danger">*</span>
                                </label>
                                <div class="col">
                                    <input type="text" name="tahun_target"
                                           class="form-control input-rounded"
                                           value="{{$ami_row->capaian}}" disabled>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label style="color: #222f3e" class="col-lg-2 col-form-label"
                                       for="val-username">Peningkatan
                                    <span class="text-danger">*</span>
                                </label>
                                <div class="col">
                                    <textarea name="keterangan_peningkatan" class="form-control" required
                                              rows="4"></textarea>
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

    @endforeach

    <script>
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

            @if(session('message-edit-ami'))

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
        toastr.success("{{session('message-edit-ami')}}", "Success")
        @endif

            @if(session('message-peningkatan-ami'))

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
        toastr.success("{{session('message-peningkatan-ami')}}", "Success")
        @endif
    </script>
@endsection()
