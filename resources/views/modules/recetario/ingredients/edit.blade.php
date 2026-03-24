<h1>Editar Ingrediente</h1>

<form action="{{ route('ingredientes.update', $ingredient->id) }}" method="POST">

@csrf
@method('PUT')

<label>Nombre</label>
<input type="text" name="name" value="{{ $ingredient->name }}">

<label>Unidad</label>
<input type="text" name="unit" value="{{ $ingredient->unit }}">

<label>Costo por unidad</label>
<input type="number" step="0.01" name="cost_per_unit" value="{{ $ingredient->cost_per_unit }}">

<button type="submit">Actualizar</button>

</form>