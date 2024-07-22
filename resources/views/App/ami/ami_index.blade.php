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
                                    <option value="{{$standar->id}}" {{isset($standarId) && $standarId == $standar->id ? 'selected' : ''}}>{{$standar->nama_standar}}</option>
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
                    <table class="table table-bordered table-striped table-responsive-lg">
                        <thead style="text-align: center; color: black">
                        <tr>
                            <th>No.</th>
                            <th>Nama Standar</th>
                            <th>Butir Indikator</th>
                            <th>Tahun Target</th>
                            <th>Dokumen/Data Pendukung</th>
                            <th>Capaian</th>
                            <th>Keterangan Capaian</th>
                            <th>Faktor Pendukung</th>
                            <th>Faktor Penghambat</th>
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
                                <td>{{$ami->indikator->butir_indikator}}</td>
                                <td>{{$ami->target_waktu->tahun_target}}</td>
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
                                <td>{{$ami->tanggal_audit}}</td>
                                <td>{{$ami->user_audit}}</td>
                                @if(session('roleUserLogin') === 'admin')
                                    <td>
                                        <a class="btn btn-info mb-1" href="#" data-toggle="modal"
                                           data-backdrop="static" data-keyboard="false"
                                           data-target="#editAMI{{$ami->id}}"><i
                                                class="fa fa-edit"></i></a>
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
                                       for="val-username">Tahun
                                    Target
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
                                    <textarea name="faktor_penghambat" class="form-control" required rows="4"></textarea>
                                </div>
                            </div>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-success">Simpan</button>
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
    </script>
@endsection()
