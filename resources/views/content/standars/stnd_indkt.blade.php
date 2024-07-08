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
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody style="color: black">
                        @php($i = 1)
                        @foreach($standars->indikator as $indikator)
                            {{--                            @if ($indikator->target_waktu->where('tahun_target', $tahunTarget)->count())--}}
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
                                        @foreach ($indikator->dokumen_pendukung_indikator as $dokumen)
                                            <li>
                                                <a href="{{URL::asset($dokumen->dokumen_pendukung)}}"
                                                   target="_blank"
                                                   style="color: #0a88f7">{{$dokumen->nama_dokumen}}</a>
                                            </li>
                                        @endforeach
                                    </ul>

                                </td>
                                <td>
                                    <a href="#" class="btn btn-sm btn-secondary"
                                       data-toggle="modal" data-target="#tambahDokumen{{$indikator->id}}">
                                        <i class="fa-solid fa-file-medical"></i></a>
                                </td>
                            </tr>
                            {{--                            @endif--}}
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    @foreach($standars->indikator as $indikator_row)
        <!-- Modal Tambah DOkumen -->
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
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endforeach

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
    </script>
@endsection()
