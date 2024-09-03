@extends('layout.main')
@section('content')
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title" style="text-transform: uppercase">Indikator Pencapaian {{$title}}</h4>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped table-responsive-lg">
                        <thead style="text-align: center; color: black">
                        <tr>
                            <th>Butir Pernyataan</th>
                            <th>Indikator</th>
                            <th>Satuan</th>
                            <th>Tahun Target</th>
                            <th>Target</th>
                            <th>Dokumen Pendukung</th>
                            @if(session('roleUserLogin') === 'admin' || session('roleUserLogin') === 'auditor')
                                <th>Action</th>
                            @endif
                        </tr>
                        </thead>
                        <tbody style="color: black">
                        @php($i = 1)
                        @foreach($standars->indikator as $indikator)
                            <tr>
                                <td style="text-align: center">{{$i++}}</td>
                                <td>{{$indikator->butir_indikator}}</td>
                                <td>{{$indikator->satuan}}</td>
                                <td>
                                    @foreach ($indikator->target_waktu as $target)
                                        @if ($target->tahun_target == $tahunTarget)
                                            {{ $target->tahun_target }}
                                        @endif
                                    @endforeach
                                </td>
                                <td>
                                    @foreach ($indikator->target_waktu as $target)
                                        @if ($target->tahun_target == $tahunTarget)
                                            {{ $target->keterangan_target }}
                                        @endif
                                    @endforeach
                                </td>
                                <td>
                                    <ul>
                                        @foreach ($indikator->dokumen_pendukung as $dokumen)
                                            <li>
                                                <a href="{{URL::asset($dokumen->dokumen_pendukung)}}"
                                                   target="_blank"
                                                   style="color: #0a88f7">{{$dokumen->nama_dokumen}}</a>
                                            </li>
                                        @endforeach
                                    </ul>
                                </td>
                                @if(session('roleUserLogin') === 'admin' || session('roleUserLogin') === 'auditor')
                                    <td>
                                        @if(session('roleUserLogin') === 'admin')
                                            <a href="#" class="btn btn-secondary mb-1" title="Tambah dokumen pendukung" data-toggle="modal"
                                               data-backdrop="static" data-keyboard="false"
                                               data-target="#tambahDokumen{{$indikator->id}}">
                                                <i class="fa-solid fa-file-medical"></i></a>
                                        @endif

                                        @if(session('roleUserLogin') === 'auditor')
                                            <a href="#" class="btn btn-success mb-1" title="Proses audit" data-backdrop="static"
                                               data-keyboard="false"
                                               data-toggle="modal" data-target="#prosesAudit{{$indikator->id}}">
                                                <i class="mdi mdi-file-check"></i></a>
                                            @foreach($indikator->target_waktu as $targetWaktu)
                                                @foreach($targetWaktu->ami as $ami)
                                                    <a href="#" class="btn btn-warning mb-1"
                                                       data-backdrop="static" title="Edit capaian"
                                                       data-keyboard="false"
                                                       data-toggle="modal" data-target="#editCapaian{{$ami->id}}">
                                                        <i class="fa-solid fa-file-pen"></i></a>
                                                @endforeach
                                            @endforeach
                                        @endif
                                    </td>
                                @endif
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    @foreach($standars->indikator as $indikator_row)
        <!-- Modal Tambah Dokumen -->
        <div class="modal fade" id="tambahDokumen{{$indikator_row->id}}">
            <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Tambah data dokumen</h5>
                        <button type="button" class="close" data-dismiss="modal"><span>&times;</span>
                        </button>
                    </div>
                    <form
                        action="{{route('indikator.add.doc.pendukung', $indikator_row->id)}}" method="post"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="modal-body">
                            <div class="form-group row">
                                <label style="color: #222f3e" class="col-lg-2 col-form-label" for="val-username">Butir
                                    Indikator
                                    <span class="text-danger">*</span>
                                </label>
                                <div class="col">
                                        <textarea name="butir_indikator" class="form-control" readonly
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
                                           value="{{$indikator_row->satuan}}" readonly>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label style="color: #222f3e" class="col-lg-2 col-form-label" for="val-username">Tahun
                                    Target
                                    <span class="text-danger">*</span>
                                </label>
                                <div class="col">
                                    @foreach ($indikator_row->target_waktu as $target)
                                        @if ($target->tahun_target == $tahunTarget)
                                            <input type="text" name="tahun_target"
                                                   class="form-control input-rounded"
                                                   value="{{$target->tahun_target}}" readonly>

                                            <input type="hidden" name="target_id" value="{{$target->id}}">
                                        @endif
                                    @endforeach
                                </div>
                            </div>

                            <div class="form-group row">
                                <label style="color: #222f3e" class="col-lg-2 col-form-label" for="val-username">Dokumen
                                    Pendukung
                                    <span class="text-danger">*</span>
                                </label>
                                <div class="col">
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">Upload</span>
                                        </div>
                                        <div class="custom-file">
                                            <input type="file" class="custom-file-input" name="dokumen_pendukung[]"
                                                   multiple>
                                            <label class="custom-file-label">Choose file</label>
                                        </div>
                                    </div>
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

    @foreach($standars->indikator as $indikator_row)
        <!-- Modal Formulir Audit -->
        <div class="modal fade" id="prosesAudit{{$indikator_row->id}}">
            <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Proses Audit</h5>
                        <button type="button" class="close" data-dismiss="modal"><span>&times;</span>
                        </button>
                    </div>
                    <form
                        action="{{route('ami.proses.audit', [$standars->id, $indikator_row->id])}}" method="post">
                        @csrf
                        <div class="modal-body">
                            <div class="form-group row">
                                <label style="color: #222f3e" class="col-lg-2 col-form-label" for="val-username">Nama
                                    Standar
                                    <span class="text-danger">*</span>
                                </label>
                                <div class="col">
                                    <input type="text" name="satuan"
                                           class="form-control input-rounded"
                                           value="{{$standars->nama_standar}}" readonly>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label style="color: #222f3e" class="col-lg-2 col-form-label" for="val-username">Butir
                                    Indikator
                                    <span class="text-danger">*</span>
                                </label>
                                <div class="col">
                                        <textarea name="butir_indikator" class="form-control" readonly
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
                                           value="{{$indikator_row->satuan}}" readonly>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label style="color: #222f3e" class="col-lg-2 col-form-label" for="val-username">Tahun
                                    Target
                                    <span class="text-danger">*</span>
                                </label>
                                <div class="col">
                                    @foreach ($indikator_row->target_waktu as $target)
                                        @if ($target->tahun_target == $tahunTarget)
                                            <input type="text" name="tahun_target"
                                                   class="form-control input-rounded"
                                                   value="{{$target->tahun_target}}" readonly>

                                            <input type="hidden" name="target_id" value="{{$target->id}}">
                                        @endif
                                    @endforeach
                                </div>
                            </div>

                            <div class="form-group row">
                                <label style="color: #222f3e" class="col-lg-2 col-form-label" for="val-username">Capaian
                                    <span class="text-danger">*</span>
                                </label>
                                <div class="col">
                                    <select class="form-control" name="capaian" required>
                                        <option value="">Pilih Capaian...</option>
                                        <option value="Tercapai">Tercapai</option>
                                        <option value="Tidak Tercapai">Tidak Tercapai</option>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label style="color: #222f3e" class="col-lg-2 col-form-label" for="val-username">Keterangan
                                    Capaian
                                    <span class="text-danger">*</span>
                                </label>
                                <div class="col">
                                        <textarea name="keterangan_capaian" class="form-control" required
                                                  rows="4"></textarea>
                                </div>
                            </div>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger" data-dismiss="modal">Batal <span class="btn-icon-right"><i class="fa fa-close"></i></span></button>
                            <button type="submit" class="btn btn-success">Proses <span class="btn-icon-right"><i class="fa fa-save"></i></span></button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        @foreach($indikator_row->target_waktu as $targetWaktu)
            @foreach($targetWaktu->ami as $ami)
                <!-- Modal Edit hasil Audit -->
                <div class="modal fade" id="editCapaian{{$ami->id}}">
                    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Edit hasil audit</h5>
                                <button type="button" class="close" data-dismiss="modal"><span>&times;</span>
                                </button>
                            </div>
                            <form
                                action="{{route('ami.edit.audit', $ami->id)}}"
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
                                                   value="{{$standars->nama_standar}}" readonly>
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
                                                  rows="4">{{$indikator_row->butir_indikator}}</textarea>
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
                                                   value="{{$indikator_row->satuan}}" readonly>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label style="color: #222f3e" class="col-lg-2 col-form-label"
                                               for="val-username">Tahun
                                            Target
                                            <span class="text-danger">*</span>
                                        </label>
                                        <div class="col">
                                            @foreach ($indikator_row->target_waktu as $target)
                                                @if ($target->tahun_target == $tahunTarget)
                                                    <input type="text" name="tahun_target"
                                                           class="form-control input-rounded"
                                                           value="{{$target->tahun_target}}" readonly>

                                                    <input type="hidden" name="target_id" value="{{$target->id}}">
                                                @endif
                                            @endforeach
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label style="color: #222f3e" class="col-lg-2 col-form-label"
                                               for="val-username">Capaian
                                            <span class="text-danger">*</span>
                                        </label>
                                        <div class="col">
                                            <select class="form-control" name="capaian" required>
                                                <option value="">Pilih Capaian...</option>
                                                @foreach($indikator_row->target_waktu as $targetWaktu)
                                                    @foreach($targetWaktu->ami as $ami)
                                                        <option
                                                            value="Tercapai" {{$ami->capaian == 'Tercapai' ? 'selected':''}}>
                                                            Tercapai
                                                        </option>
                                                        <option
                                                            value="Tidak Tercapai" {{$ami->capaian == 'Tidak Tercapai' ? 'selected':''}}>
                                                            Tidak Tercapai
                                                        </option>
                                                    @endforeach
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label style="color: #222f3e" class="col-lg-2 col-form-label"
                                               for="val-username">Keterangan
                                            Capaian
                                            <span class="text-danger">*</span>
                                        </label>
                                        <div class="col">
                                            @foreach($indikator_row->target_waktu as $targetWaktu)
                                                @foreach($targetWaktu->ami as $ami)
                                                    <textarea name="keterangan_capaian" class="form-control" required
                                                              rows="4">{{$ami->keterangan_capaian}}</textarea>
                                                @endforeach
                                            @endforeach
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
        @endforeach

    @endforeach

    <script>
        @if(session('message-edit-capaian-audit'))

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
        toastr.success("{{session('message-edit-capaian-audit')}}", "Success")
        @endif

            @if(session('message-fail'))

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
        toastr.error("{{session('message-fail')}}", "Failed")
        @endif

            @if(session('message-audit'))

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
        toastr.success("{{session('message-audit')}}", "Success")
        @endif

            @if(session('message-fail-audit'))

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
        toastr.error("{{session('message-fail-audit')}}", "Failed")
        @endif
    </script>
@endsection()
