@extends('layouts.main')

@section('content')
    <header><h1><a href="{{url('/')}}">Create new Todo</a></h1></header>
    <main>
        @if(Session::has('error'))
            <div class="alert alert-danger">
                {{Session::get('error')}}
            </div>
        @endif
        @if(Session::has('success'))
            <div class="alert alert-success">
                {{Session::get('success')}}
            </div>
        @endif
        <form action="{{url('/create')}}" method="POST">
            @csrf
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <label for="description">
                            Description:
                        </label>
                        <textarea name="description" id="description" cols="30" rows="10">{{old('description')}}</textarea>
                        @error('description')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <label for="checked">Completed?:</label>
                        <input type="checkbox" name="checked" value="1" {{old('checked') === '1' ? 'checked' : ''}}/>
                    </div>
                </div>
                <div class="row">
                    <input type="submit" value="Create">
                </div>
            </div>
        </form>
    </main>
@endsection
