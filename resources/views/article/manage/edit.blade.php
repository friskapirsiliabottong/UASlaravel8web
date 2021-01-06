@extends('layouts.front.app')
@section('content')
<div class="col-lg-8">
        <h1 class="mt-4">Ubah Artikel</h1>
        @if(Session::has('success'))
            <div class="alert alert-success" role="alert">
                {{Session::get('success')}}
            </div>
        @endif
        <form method="POST" action="{{route('article.update',$articles->id)}}" enctype="multipart/form-data">
            {{method_field('PUT')}}
            @csrf
            <div class="form-group">
                <label>Kategori</label>
                <select class="form-control @error('category') is-invalid @enderror" name="category">
                    <option value="">Pilih Kategori</option>
                    @foreach($categories as $category)
                        <option value="{{$category->id}}" @if(old('category',$articles->category_id)==$category->id) selected="selected" @endif>{{$category->name}}</option>
                    @endforeach
                </select>
                @error('category')
                <div class="alert alert-danger">{{$message}}</div>
                @enderror
            </div>
            <div class="form-group">
                <label>Judul</label>
                    <input type="text" class="form-control @error('title') is-invalid @enderror" name="title" value="{{old('title',$articles->title)}}"></input>
                    @error('title')
                <div class="alert alert-danger">{{$message}}</div>
                @enderror
            </div>
            <div class="form-group">
                <label>Artikel</label>
                    <textarea class="form-control @error('content') is-invalid @enderror" rows="4" name="content">{{old('content',$articles->content)}}</textarea>
                    @error('content')
                <div class="alert alert-danger">{{$message}}</div>
                @enderror
            </div>
            <div class="form-group">
                <label>File</label><br>
                <p><img src="{{asset('storage/'.$articles->file)}}" class="img-thumbnail" width="200"></p>
                    <input type="file" class="form-control-form @error('file') is-invalid @enderror" name="file" accept="image/*"></input>
                    @error('file')
                <div class="alert alert-danger">{{$message}}</div>
                @enderror
            </div>
            <button type="submit" class="btn btn-primary">create</button>
        </form>
</div>
@endsection