@extends('layouts.erp')

@section('content')

<h1 class="text-2xl font-bold mb-4">
Nuevo ingrediente
</h1>

<form action="{{ route('ingredientes.store') }}" method="POST">

@csrf

<div class="mb-3">
<label>Nombre</label>
<input type="text" name="name" class="border p-2 w-full">
</div>

<div class="mb-3">
<label>Unidad</label>
<input type="text" name="unit" class="border p-2 w-full">
</div>

<div class="mb-3">
<label>Costo por unidad</label>
<input type="number" step="0.0001" name="cost_per_unit" class="border p-2 w-full">
</div>

<button class="bg-green-600 text-white px-4 py-2 rounded">
Guardar
</button>

</form>

@endsection