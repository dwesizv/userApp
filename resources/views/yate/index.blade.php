@extends('layouts.app')

@section('content')
    <div class="row" style="margin-top: 8px;">
        <table class="table table-striped" id="userTable">
            <thead>
                <tr>
                    <th scope="col"># id &#x25b4;&#x25be;</th>
                    <th scope="col">nombre &#x25b4;&#x25be;</th>
                    <th scope="col">idtipo &#x25b4;&#x25be;</th>
                    <th scope="col">iduser &#x25b4;&#x25be;</th>
                    <th scope="col">idastillero &#x25b4;&#x25be;</th>
                    <th scope="col">descripción &#x25b4;&#x25be;</th>
                    <th scope="col">precio &#x25b4;&#x25be;</th>
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
                        {{ $yate->idtipo }} {{ $yate->tipo->nombre }} <!-- usando el método tipo (belongsTo) de la clase Yate -->
                    </td>
                    <td>
                        {{ $yate->iduser }} {{ $yate->user->name }} <!-- usando el método user (belongsTo) de la clase Yate -->
                    </td>
                    <td>
                        {{ $yate->idastillero }} {{ $yate->astillero->nombre }} <!-- usando el método astillero (belongsTo) de la clase Yate -->
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