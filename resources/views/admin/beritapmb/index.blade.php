@extends('layouts.app')

@section('content')

<div class="container py-4">

<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="fw-bold text-success">Berita PMB</h2>

    <a href="{{ route('beritapmb.create') }}"
       class="btn btn-success">
        Tambah Berita PMB
    </a>
</div>

@if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

<div class="card shadow-sm border-0">
    <div class="card-body">

        <div class="table-responsive">

            <table class="table table-bordered table-hover align-middle">

                <thead class="table-success">
                    <tr>
                        <th width="60">No</th>
                        <th width="100">Gambar</th>
                        <th>Judul</th>
                        <th width="120">Penulis</th>
                        <th width="120">Kategori</th>
                        <th width="100">Video</th>
                        <th width="100">PDF</th>
                        <th width="170">Publish</th>
                        <th width="220">Aksi</th>
                    </tr>
                </thead>

                <tbody>

                @forelse($beritas as $item)

                    <tr>

                        <td>
                            {{ $loop->iteration }}
                        </td>

                        <td>

                            @if($item->gambar)

                                <img src="{{ asset('uploads/beritapmb/gambar/'.$item->gambar) }}"
                                     class="img-thumbnail"
                                     style="width:80px;height:60px;object-fit:cover;">

                            @else

                                <span class="text-muted">-</span>

                            @endif

                        </td>

                        <td>

                            <strong>
                                {{ $item->judul }}
                            </strong>

                            <br>

                            <small class="text-muted">
                                {{ $item->slug }}
                            </small>

                        </td>

                        <td>
                            {{ $item->penulis }}
                        </td>

                        <td>

                            <span class="badge bg-success">
                                {{ $item->kategori }}
                            </span>

                        </td>

                        <td>

                            @if($item->video)
                                @php
                                    $videoUrl = \Illuminate\Support\Str::startsWith($item->video, ['http://', 'https://']) 
                                        ? $item->video 
                                        : asset('uploads/beritapmb/video/'.$item->video);
                                @endphp

                                @if(\Illuminate\Support\Str::contains($item->video, ['youtube.com', 'youtu.be']))
                                    <a href="{{ $videoUrl }}" target="_blank" class="btn btn-outline-danger btn-sm d-inline-flex align-items-center gap-1">
                                        <i class="fab fa-youtube"></i> YouTube
                                    </a>
                                @elseif(\Illuminate\Support\Str::contains($item->video, 'tiktok.com'))
                                    <a href="{{ $videoUrl }}" target="_blank" class="btn btn-outline-dark btn-sm d-inline-flex align-items-center gap-1">
                                        <i class="fab fa-tiktok"></i> TikTok
                                    </a>
                                @else
                                    <a href="{{ $videoUrl }}" target="_blank" class="btn btn-success btn-sm">
                                        Lihat
                                    </a>
                                @endif

                            @else

                                <span class="text-muted">-</span>

                            @endif

                        </td>

                        <td>

                            @if($item->file_pdf)

                                <a href="{{ asset('uploads/beritapmb/pdf/'.$item->file_pdf) }}"
                                   target="_blank"
                                   class="btn btn-danger btn-sm">

                                    PDF

                                </a>

                            @else

                                <span class="text-muted">-</span>

                            @endif

                        </td>

                        <td>

                            @if($item->publish_at)

                                {{ \Carbon\Carbon::parse($item->publish_at)->format('d M Y H:i') }}

                            @else

                                <span class="badge bg-warning text-dark">
                                    Draft
                                </span>

                            @endif

                        </td>

                        <td>

                            <a href="{{ route('beritapmb.edit',$item->id) }}"
                               class="btn btn-warning btn-sm">

                                Edit

                            </a>

                            <form action="{{ route('beritapmb.destroy',$item->id) }}"
                                  method="POST"
                                  class="d-inline">

                                @csrf
                                @method('DELETE')

                                <button type="submit"
                                        class="btn btn-danger btn-sm"
                                        onclick="return confirm('Yakin ingin menghapus berita ini?')">

                                    Hapus

                                </button>

                            </form>

                        </td>

                    </tr>

                @empty

                    <tr>

                        <td colspan="9"
                            class="text-center py-4">

                            Belum ada data Berita PMB

                        </td>

                    </tr>

                @endforelse

                </tbody>

            </table>

        </div>

    </div>
</div>

</div>
@endsection
