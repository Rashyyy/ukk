@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">

        @if (!$foto || $foto->isEmpty())
            <h3 class="d-flex justify-content-center align-items-center vh-100">Foto Tidak Ada</h3>
        @else
            @foreach ($foto as $item)
                <div class="col-6">
                    <div class="card mb-3">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <div class="align-items-center">
                                <p>{{ $item->judul }}</p>
                                <p class="fw-bold" style="font-size: 15px">
                                    {{ $item->user->username }} 
                                    <span>{{ \Carbon\Carbon::parse($item->created_at)->format('d-m-Y') }}</span>
                                </p>
                            </div>

                            @if ($item->user_id == auth()->id())
                                <div class="dropdown">
                                    <button class="btn dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false"></button>
                                    <ul class="dropdown-menu">
                                        <li><a class="dropdown-item" href="{{ route('foto.edit', $item->id) }}">Edit</a></li>
                                        <li>
                                            <form action="{{ route('foto.destroy', $item->id) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="dropdown-item">Hapus</button>
                                            </form>
                                        </li>
                                    </ul>
                                </div>
                            @endif
                        </div>

                        <div class="card-body">
                            <img src="{{ asset('storage/' . $item->lokasi) }}" draggable="false" class="object-fit-cover img-fluid" style="height: 400px; width: 100%">
                            <hr class="my-3">
                            <h5 class="card-title mt-3">{{ $item->title }}</h5>
                            <p class="card-text">{{ $item->description }}</p>
                            <p>{{ $item->deskripsi }}</p>
                        </div>

                        <div class="card-footer">
                           @auth
                           <div class="d-flex">
                            <form action="{{ route('like.index', $item->id) }}" method="post">
                                @csrf
                                <button type="submit" class="btn">
                                     {{ $item->like->count() }} Disukai
                                </button>
                            </form>

                            <button type="button" class="btn" data-bs-toggle="modal" data-bs-target="#exampleModal{{ $item->id }}">
                                 {{ $item->komen->count() }} Komentar
                            </button>
                        </div>
                        @else
                        <div class="d-flex">
                            <a href="{{ route('login') }}" class="btn">
                                 {{ $item->like->count() }} Disukai
                            </a>
                            <a href="{{ route('login') }}" class="btn">
                                 {{ $item->komen->count() }} Komentar
                            </a>
                        </div>   
                           @endauth

                            <div class="modal fade" id="exampleModal{{ $item->id }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">Komentar</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>

                                        <div class="modal-body mb-3">
                                            @foreach($item->komen as $komen)
                                                <div class="d-flex justify-content-between aligns-items-center">
                                                    <div class="">
                                                        <h5>{{ $komen->user->username }}</h5>
                                                        <p>{{ $komen->isi_komen }}</p>
                                                    </div>
                                                    @auth
                                                        @if ($komen->user->id == Auth::user()->id)
                                                            <div class="ml-auto">
                                                                <form action="{{ route('komen.destroy', $komen->id) }}" method="post">
                                                                    @csrf
                                                                    @method('DELETE')
                                                                    <button type="submit" class="btn btn-danger">Hapus</button>
                                                                </form>
                                                            </div>                                        
                                                        @endif      
                                                    @endauth
                                                </div>
                                            @endforeach
                                        </div>

                                        <div class="modal-body">
                                            <form action="{{ route('komen.store', $item->id) }}" method="post">
                                                @csrf
                                                <div class="mb-3">
                                                    <textarea name="isi_komen" rows="5" cols="55" class="form-label"></textarea>
                                                </div>
                                                <button class="btn btn-primary" type="submit">Post</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        @endif
    </div>
</div>
@endsection
