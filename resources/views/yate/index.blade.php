@extends('layouts.app')

@section('content')
    <div class="row" style="margin-top: 8px;">
        <table class="table table-striped" id="userTable">
            <thead>
                <tr>
                    <th scope="col"># id</th>
                    <th scope="col">nombre</th>
                    <th scope="col">idtipo</th>
                    <th scope="col">iduser</th>
                    <th scope="col">idastillero</th>
                    <th scope="col">descripción</th>
                    <th scope="col">precio</th>
                </tr>
            </thead>
            <tbody>
                @foreach($yates as $yate)
                <tr>
                    <td>
                        {{ $yate->id }}
                    </td>
                    <td>
                        {{ $yate->nombre }}
                    </td>
                    <td>
                        {{ $yate->tipo->nombre }}
                    </td>
                    <td>
                        {{ $yate->user->name }}
                    </td>
                    <td>
                        {{ $yate->astillero->nombre }}
                    </td>
                    <td>
                        {{ substr($yate->descripcion, 0, 10) }}...
                    </td>
                    <td>
                        {{ $yate->precio }} €
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection

@section('scripts')
    <script src="{{ url('assets/js/common.js') }}"></script>
@endsection