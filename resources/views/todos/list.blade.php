@extends('layouts.main')

@section('content')
    <h1>Your Todos</h1>

    <br>
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

    <a href="{{url('/create')}}">
        Create new Todo
    </a>
    <br>

    <table class="table">
        <thead>
            <tr>
                <th>
                    Description
                </th>
                <th>
                    Completed?
                </th>
                <th>
                    Actions
                </th>
            </tr>
        </thead>
        <tbody>
        @foreach($todos as $todo)
            <tr>
                <td>
                    {{$todo->description}}
                </td>
                <td>
                    {{$todo->checked ? 'completed' : 'incomplete'}}
                </td>
                <td>
                    <a href="/edit/{{$todo->id}}">
                        Edit
                    </a> |
                    <a href="/delete/{{$todo->id}}" data-id="{{$todo->id}}" class="delete">
                        Delete
                    </a> |
                    @if($todo->checked)
                        <a href="/update/{{$todo->id}}/0" class="update-mark" data-id="{{$todo->id}}" data-status="0" >
                            <i class="fa fa-2x fa-check icon-mark"></i>
                        </a>
                    @else
                        <a href="/update/{{$todo->id}}/1" class="update-mark" data-id="{{$todo->id}}" data-status="1">
                           <i class="fa fa-2x fa-times icon-mark"></i>
                        </a>
                    @endif

                </td>
            </tr>
        @endforeach
        </tbody>
    </table>

@endsection

@section('scripts')
    <script type="text/javascript">
        $(document).ready(function(){
            $('.delete').click(function(e){
                e.preventDefault();
                let id = $(this).attr('data-id');
                let $this = $(this);
                $.ajax({
                    url: '/api/delete/' + id,
                    type: 'DELETE',
                    success: function(data) {
                        if (data.status === "1") {
                            $this.parents('tr').fadeOut();
                        }
                    }
                })
            });
            $('.update-mark').click(function(e){
                let status = $(this).attr('data-status');
                let id = $(this).attr('data-id');
                let $this = $(this);
                e.preventDefault();
                $.post('/api/update/' + id + '/' + status, [], function(data){
                    if (data.status === "1") {
                        $this.attr('data-status', 0);
                        $this.find('.icon-mark').removeClass('fa-times').addClass('fa-check');
                    } else {
                        $this.attr('data-status', 1);
                        $this.find('.icon-mark').removeClass('fa-check').addClass('fa-times');
                    }
                });
            })
        });
    </script>
@endsection

