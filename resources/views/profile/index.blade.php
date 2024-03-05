@extends('template')

@section('title','Perfil')

@push('css')
    
@endpush

@section('content')
<div class="conteiner">
    <h1 class="mt-4 text-center">Ver perfil</h1>
    <div class="conteiner card mt-4">
        <form class="card-body" action="{{route('profiles.update',['profile' => $user])}}" method="POST">
            @method('PATCH')
            @csrf
            <!---nombre--->
            <div class="row mb-4">
                <div class="col-sm-4">
                    <div class="input-group">
                        <span class="input-group-text" ><i class="fa-solid fa-square-check"></i></span>
                        <input disabled type="text" class="form-control" value="Nombre">
                    </div>
                </div>
                <div class="col-sm-8">
                    <input disabled type="text" name="name" id="name" class="form-control" value="{{old('name',$user->name)}}">
                </div>
            </div>
            <!---EMAIL--->
            <div class="row mb-4">
                <div class="col-sm-4">
                    <div class="input-group">
                        <span class="input-group-text"><i class="fa-solid fa-square-check"></i></span>
                        <input disabled type="text" class="form-control" value="Email">
                    </div>
                </div>
                <div class="col-sm-8">
                    <input disabled type="email" name="email" id="email" class="form-control" value="{{old('email',$user->email)}}">
                </div>
            </div>
        </form>
    </div>
</div>
@endsection

@push('js')
    
@endpush