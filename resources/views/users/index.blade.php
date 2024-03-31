@extends('layouts.app')

@section('scripts')
    @parent <!-- Keep any existing scripts and add new ones -->
    <script>
        function confirmBlock() {
            return confirm('Are you sure you want to block this user?');
        }

        function confirmUnblock() {
            return confirm('Are you sure you want to unblock this user?');
        }
    </script>
@endsection

@section('content')
<div class="row">
    <div class="col-lg-12 margin-tb">
        <div class="pull-left">
            <h2>Users Management</h2>
        </div>
        <div class="pull-right">
            <a class="btn btn-success float-right" href="{{ route('users.create') }}"> Create New User</a>
        </div>
    </div>
</div>


@if ($message = Session::get('success'))
<div class="alert alert-success">
  <p>{{ $message }}</p>
</div>
@endif


<table class="table table-bordered">
 <tr>
   <th>No</th>
   <th>Name</th>
   <th>Email</th>
   <th>Roles</th>
   <th width="280px">Action</th>
 </tr>
 @foreach ($data as $key => $user)
  <tr>
    <td>{{ ++$i }}</td>
    <td>{{ $user->name }}</td>
    <td>{{ $user->email }}</td>
    <td>
      @if(!empty($user->getRoleNames()))
        @foreach($user->getRoleNames() as $v)
            @if($user->hasRole('Admin'))
                <label class="badge badge-warning">{{ $v }}</label>
            @else
                <label class="badge badge-success">{{ $v }}</label>
            @endif
        @endforeach
      @endif
    </td>
    <td>
        @if( $user->deleted_at == null )
          <a class="btn btn-info" href="{{ route('users.show',$user->id) }}">Show</a>
          <a class="btn btn-primary " href="{{ route('users.edit',$user->id) }}">Edit</a>
        @endif
      @if($user->hasRole('Admin'))
      @else
        @if($user->deleted_at == null )
            {!! Form::open(['method' => 'DELETE', 'route' => ['users.destroy', $user->id], 'style' => 'display:inline', 'class' => 'block-form', 'onsubmit' => 'return confirmBlock()']) !!}
            {!! Form::submit('Block', ['class' => 'btn btn-danger']) !!}
            {!! Form::close() !!}
        @else
            {!! Form::open(['method' => 'PUT', 'route' => ['users.unblock', $user->id], 'style' => 'display:inline', 'class' => 'unblock-form', 'onsubmit' => 'return confirmUnblock()']) !!}
            {!! Form::submit('Unblock', ['class' => 'btn btn-default btn-outline-dark']) !!}
            {!! Form::close() !!}
        @endif
      @endif
    </td>
  </tr>
 @endforeach
</table>


{!! $data->render() !!}

<p class="text-center text-primary"><small></small></p>
@endsection
