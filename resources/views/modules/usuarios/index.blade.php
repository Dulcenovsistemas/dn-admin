@extends('layouts.erp')

@section('content')

<h1 class="text-2xl font-semibold mb-6">
Usuarios
</h1>

    <a href="{{ route('usuarios.create') }}"
    class="bg-blue-600 text-white px-4 py-2 rounded mb-4 inline-block">

    Crear usuario

    </a>

    <div class="bg-white rounded shadow">

        <table class="w-full">

            <thead class="bg-gray-100">

                <tr>
                <th class="p-3 text-left">Nombre</th>
                <th class="p-3 text-left">Email</th>
                <th class="p-3 text-left">Acciones</th>
                </tr>

            </thead>

            <tbody>

            @foreach($users as $user)

            <tr class="border-t">

                <td class="p-3">
                {{ $user->name }}
                </td>

                <td class="p-3">
                {{ $user->email }}
                </td>

                <td class="p-3">

                <a href="{{ route('usuarios.edit',$user->id) }}"
                class="text-blue-600">

                Editar

                </a>
                <form action="{{ route('usuarios.destroy', $user->id) }}" method="POST">
                    @csrf
                    @method('DELETE')

                    <button onclick="return confirm('¿Eliminar este usuario?')"
                            class="text-red-500 hover:underline text-sm">
                        Eliminar
                    </button>
                </form>

                </td>

            </tr>

            @endforeach

            </tbody>

        </table>

    </div>

@endsection