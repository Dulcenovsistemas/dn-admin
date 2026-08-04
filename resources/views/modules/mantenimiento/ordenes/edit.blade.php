@extends('layouts.erp')

@section('content')

<div class="max-w-6xl mx-auto">

    <div class="flex justify-between items-center mb-8">

        <div>

            <h1 class="text-3xl font-bold text-gray-800">

                Editar Orden {{ $ordene->folio }}

            </h1>

            <p class="text-gray-500">

                Actualiza la información de la orden.

            </p>

        </div>

        <a href="{{ route('ordenes.index') }}"
           class="bg-gray-200 hover:bg-gray-300 px-5 py-3 rounded-xl">

            Volver

        </a>

    </div>

    <form action="{{ route('ordenes.update',$ordene) }}"
          method="POST"
          enctype="multipart/form-data">

        @csrf
        @method('PUT')

        @php
            $editando = true;
        @endphp

        @include('modules.mantenimiento.ordenes.partials.form')

    </form>

</div>

@endsection