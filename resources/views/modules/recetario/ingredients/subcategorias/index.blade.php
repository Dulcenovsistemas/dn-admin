@extends('layouts.erp')

@section('content')

<h2>Subcategorías</h2>

<form method="POST" action="{{ route('subcategorias.store') }}">
    @csrf

    <input type="text" name="nombre" placeholder="Nombre de la subcategoría">

    <select name="categoria_id">
        <option value="">Selecciona categoría</option>
        @foreach($categorias as $categoria)
            <option value="{{ $categoria->id }}">
                {{ $categoria->nombre }}
            </option>
        @endforeach
    </select>

    <button type="submit">Guardar</button>
</form>

<hr>

<ul>
@foreach($subcategorias as $sub)
    <li>
        {{ $sub->nombre }} ({{ $sub->categoria->nombre }})
    </li>
@endforeach
</ul>

@endsection