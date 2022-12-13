@extends('layouts.app')

@section('content')
    <div class="row" style="margin-top: 8px;">
        <table class="table table-striped" id="userTable">
            <thead>
                <tr>
                    <th scope="col">
                        # id 
                        <a href="{{route('yate.index',
                                    ['orderby' => $orderby['id'],
                                     'ordertype' => $ordertype['asc']])}}">&#x25b4;</a>
                        <a href="{{route('yate.index',
                                    ['orderby' => $orderby['id'],
                                     'ordertype' => $ordertype['desc']])}}">&#x25be;</a>
                    </th>
                    <th scope="col">
                        nombre
                        <a href="{{route('yate.index',
                                    ['orderby' => $orderby['nombre'],
                                     'ordertype' => $ordertype['asc']])}}">&#x25b4;</a>
                        <a href="{{route('yate.index',
                                    ['orderby' => $orderby['nombre'],
                                     'ordertype' => $ordertype['desc']])}}">&#x25be;</a>
                    </th>
                    <th scope="col">
                        idtipo
                        <a href="{{route('yate.index',
                                    ['orderby' => $orderby['idtipo'],
                                     'ordertype' => $ordertype['asc']])}}">&#x25b4;</a>
                        <a href="{{route('yate.index',
                                    ['orderby' => $orderby['idtipo'],
                                     'ordertype' => $ordertype['desc']])}}">&#x25be;</a>
                    </th>
                    <th scope="col">
                        iduser
                        <a href="{{route('yate.index',
                                    ['orderby' => $orderby['iduser'],
                                     'ordertype' => $ordertype['asc']])}}">&#x25b4;</a>
                        <a href="{{route('yate.index',
                                    ['orderby' => $orderby['iduser'],
                                     'ordertype' => $ordertype['desc']])}}">&#x25be;</a>
                    </th>
                    <th scope="col">
                        idastillero
                        <a href="{{route('yate.index',
                                    ['orderby' => $orderby['idastillero'],
                                     'ordertype' => $ordertype['asc']])}}">&#x25b4;</a>
                        <a href="{{route('yate.index',
                                    ['orderby' => $orderby['idastillero'],
                                     'ordertype' => $ordertype['desc']])}}">&#x25be;</a>
                    </th>
                    <th scope="col">
                        descripción
                        <a href="{{route('yate.index',
                                    ['orderby' => $orderby['descripcion'],
                                     'ordertype' => $ordertype['asc']])}}">&#x25b4;</a>
                        <a href="{{route('yate.index',
                                    ['orderby' => $orderby['descripcion'],
                                     'ordertype' => $ordertype['desc']])}}">&#x25be;</a>
                    </th>
                    <th scope="col">
                        precio
                        <a href="{{route('yate.index',
                                    ['orderby' => $orderby['precio'],
                                     'ordertype' => $ordertype['asc']])}}">&#x25b4;</a>
                        <a href="{{route('yate.index',
                                    ['orderby' => $orderby['precio'],
                                     'ordertype' => $ordertype['desc']])}}">&#x25be;</a>
                    </th>
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