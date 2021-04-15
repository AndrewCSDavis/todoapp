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
            @error('description')
            <div class="alert alert-danger">
                {{ $message }}
            </div>
            @enderror
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="description">
                                Description:
                                <br>

                            </label>
                            <textarea name="description" id="description" class="form-control" cols="30" rows="10">{{old('description')}}</textarea>
                        </div>

                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-check">

                            <input type="checkbox" name="checked" value="1" class="form-check-input"  {{old('checked') === '1' ? 'checked' : ''}}/>
                            <label for="checked" class="form-check-label" >Completed?:</label>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <input type="submit" value="Create">
                </div>
            </div>
        </form>
    </main>
@endsection
