@extends('dashboard', [
    'title' => 'Edit Data Cuti',
    'pageTitle' => 'Edit Data Cuti',
])

@section('content')
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Edit Data Cuti</div>
                    <div class="card-body">
                        <form action="{{ route('manajer.cuti.update', $cuti->no_cuti) }}" method="POST">
                            @csrf
                            @method('PUT')

                            <div class="form-group">
                                <label for="npp">Karyawan</label>
                                <select name="npp" class="form-control" readonly disabled>
                                    @foreach ($employee as $emp)
                                        <option value="{{ $cuti->npp }}"
                                            {{ isset($cuti) && $cuti->npp == $emp->npp ? 'selected' : '' }}>
                                            {{ $emp->npp }} | {{ $emp->nama_emp }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="id_jenis_cuti">Jenis Cuti</label>
                                <select name="id_jenis_cuti" class="form-control" readonly disabled>
                                    @foreach ($jenisCuti as $jenis)
                                        <option value="{{ $jenis->id_jenis_cuti }}"
                                            {{ $cuti->id_jenis_cuti == $jenis->id ? 'selected' : '' }}>
                                            {{ $jenis->nama_cuti }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="tgl_pengajuan">Tanggal Pengajuan</label>
                                <input type="date" name="tgl_pengajuan" class="form-control"
                                    value="{{ $cuti->tgl_pengajuan }}" required readonly>
                            </div>
                            <div class="form-group">
                                <label for="tgl_awal">Tanggal Awal</label>
                                <input type="date" name="tgl_awal" class="form-control" value="{{ $cuti->tgl_awal }}"
                                    required readonly>
                            </div>
                            <div class="form-group">
                                <label for="tgl_akhir">Tanggal Akhir</label>
                                <input type="date" name="tgl_akhir" class="form-control" value="{{ $cuti->tgl_akhir }}"
                                    required readonly>
                            </div>
                            <div class="form-group">
                                <label for="durasi">Durasi Cuti</label>
                                <input type="number" name="durasi" class="form-control" value="{{ $cuti->durasi }}"
                                    required readonly>
                            </div>
                            <div class="form-group">
                                <label for="keterangan">Keterangan</label>
                                <textarea name="keterangan" class="form-control" required readonly>{{ $cuti->keterangan }}</textarea>
                            </div>
                            <div class="form-group">
                                <label for="stt_cuti">Status Cuti</label>
                                <select name="stt_cuti" class="form-control" required>
                                    <option value="Pending" {{ $cuti->stt_cuti == 'Pending' ? 'selected' : '' }}>Pending
                                    </option>
                                    <option value="Approved" {{ $cuti->stt_cuti == 'Approved' ? 'selected' : '' }}>Approved
                                    </option>
                                    <option value="Rejected" {{ $cuti->stt_cuti == 'Rejected' ? 'selected' : '' }}>Rejected
                                    </option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="ket_reject">Keterangan Reject</label>
                                <textarea name="ket_reject" class="form-control">{{ $cuti->ket_reject }}</textarea>
                            </div>
                            <button type="submit" class="btn btn-primary">Update</button>
                            <a href="{{ route('hrd.cuti') }}" class="btn btn-secondary">Batal</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
