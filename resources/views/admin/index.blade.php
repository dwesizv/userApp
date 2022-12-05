@extends('layouts.app')

@section('content')
    <div class="modal fade" id="modalDelete" tabindex="-1" role="dialog" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Confirm delete</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          </div>
          <div class="modal-body">
            <p>Confirm delete <span id="deleteElement">XXX</span>?</p>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
            <form id="modalDeleteResourceForm" action="" method="post">
                @method('delete')
                @csrf
                <input type="submit" class="btn btn-primary" value="Delete element"/>
            </form>
          </div>
        </div>
      </div>
    </div>
    <div class="row" style="margin-top: 8px;">
        <table class="table table-striped" id="userTable">
            <thead>
                <tr>
                    <th scope="col"># id</th>
                    <th scope="col">name</th>
                    <th scope="col">email</th>
                    <th scope="col">type</th>
                    <th scope="col">verified</th>
                </tr>
            </thead>
            <tbody>
                @foreach($users as $user)
                <tr>
                    <td>
                        {{ $user->id }}
                    </td>
                    <td>
                        {{ $user->name }}
                    </td>
                    <td>
                        {{ $user->email }}
                    </td>
                    <td>
                        {{ $user->type }}
                    </td>
                    <td>
                        @if($user->email_verified_at != null)
                            yes
                        @else
                            no
                        @endif
                    </td>
                    <td>
                        @if($user->email != Auth::user()->email)
                            <a href="javascript: void(0);" 
                                   data-name="{{ $user->name }}"
                                   data-url="{{ url('admin/' . $user->id ) }}"
                                   data-toggle="modal"
                                   data-target="#modalDelete">delete</a>
                        @endif
                    </td>
                    <td>
                        <a href="{{ url('admin/' . $user->id . '/edit') }}">edit</a>
                    </td>
                    <td>
                        <a href="{{ url('admin/' . $user->id) }}">show</a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <a href="{{ url('admin/create') }}" class="btn btn-primary">Create user</a>
    </div>
@endsection

@section('scripts')
    <script src="{{ url('assets/js/common.js') }}"></script>
@endsection