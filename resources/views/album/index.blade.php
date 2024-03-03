@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="mb-5 justify-content-end">
                <a href="{{ route('album.create') }}" class="btn btn-info rounded-5">Tambah Album Baru +</a>
            </div>

            @foreach($album as $item)
            <div class="card mb-3">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3>{{ $item->nama }}</h3>
                    <div class="dropdown">
                        <a class="btn dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false"></a>

                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="{{ route('album.edit', $item->id) }}">Edit</a></li>
                            <li>
                                <form action="{{ route('album.destroy', $item->id) }}" method="post">
                                    @csrf
                                    @method('delete')
                                    <button type="submit" class="dropdown-item">Hapus</button>
                                </form>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="card-body">
                    <img src="{{ asset('storage/' . $item->lokasi) }}" draggable="false" class="object-fit-cover img-fluid">
                </div>
                <div class="card-footer">
                    {{ $item->deskripsi }}
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>
@endsection
