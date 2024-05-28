@extends('admin.layout.master')

@section('title', 'Admin Gallery Update page')

@section('content')
<!-- standing -->
<div class="standing segments-page">
    <div class="container"><br>
        <center>
            <h3>Update Blog</h3>
        </center>
        <div class="row">
            <div class="col-3 offset-8">
                <span onclick="history.back()"><i class="fa-solid fa-backward text-dark"></i> Back</span>
            </div>
        </div>
        <form action="{{ route('admin#galleryUpdate') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label>Header Name</label>
                <input type="hidden" name="galleryId" value="{{ $data->id }}">
                @error('headerName')
                    <div class="invalid-feedback">
                        <p style="color: red">{{ $message }}</p>
                    </div>
                @enderror
                <input value="{{ $data->header }}" class="form-control @error('headerName') is-invalid @enderror" type="text" name="headerName" value="{{ old("headerName") }}">
            </div>
            <div class="form-group">
                <label>Sub Header</label>
                @error('subHeader')
                    <div class="invalid-feedback">
                        <p style="color: red">{{ $message }}</p>
                    </div>
                @enderror
                <input value="{{ $data->sub_header }}" class="form-control @error('subHeader') is-invalid @enderror" type="text" name="subHeader" value="{{ old("subHeader") }}">
            </div>
            <div class="form-group">
                <label>First Photo</label>
                @error('firstPhoto')
                    <div class="invalid-feedback">
                        <p style="color: red">{{ $message }}</p>
                    </div>
                @enderror
                <input class="form-control @error('firstPhoto') is-invalid @enderror" type="file" name="firstPhoto">
            </div>
            <div class="form-group">
                <label>Second Photo</label>
                @error('secondPhoto')
                    <div class="invalid-feedback">
                        <p style="color: red">{{ $message }}</p>
                    </div>
                @enderror
                <input class="form-control @error('secondPhoto') is-invalid @enderror" type="file" name="secondPhoto">
            </div>
            <div class="form-group mb-5">
                <label>Third Photo</label>
                @error('thirdPhoto')
                    <div class="invalid-feedback">
                        <p style="color: red">{{ $message }}</p>
                    </div>
                @enderror
                <input class="form-control @error('thirdPhoto') is-invalid @enderror" type="file" name="thirdPhoto">
            </div>
            <div class="form-group">
                <label>Briefing</label>
                @error('briefing')
                    <div class="invalid-feedback">
                        <p style="color: red">{{ $message }}</p>
                    </div>
                @enderror
                <textarea name="briefing" class="form-control" id="" cols="30" rows="10">{{ $data->briefing }}</textarea>
            </div>
            <div class="form-group">
                <label>Main Text</label>
                @error('mainText')
                    <div class="invalid-feedback">
                        <p style="color: red">{{ $message }}</p>
                    </div>
                @enderror
                <textarea name="mainText" class="form-control" id="" cols="30" rows="10">{{ $data->main_text }}</textarea>
            </div>
            <div class="form-group">
                <button class="btn number-white bg-success" type="submit"><i class="fa-solid fa-plus btn-sm"></i>Update Blog</button>
            </div>
        </form>
    </div>
</div>
<!-- end standing -->
@endsection
