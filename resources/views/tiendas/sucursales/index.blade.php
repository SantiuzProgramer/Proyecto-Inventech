@extends('layouts.app')

@section('content')

{{-- Alertas de éxito o error --}}
@if (session('success'))
    <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded">
        {{ session('success') }}
    </div>
@endif

@if (session('error'))
    <div class="mb-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded">
        {{ session('error') }}
    </div>
@endif

    <div class="max-w-4xl mx-auto mt-10 p-6 bg-white rounded-lg shadow-lg">
        <h1 class="text-3xl font-semibold mb-6">Sucursales de las Tiendas</h1>

        <!-- Botón para crear una nueva sucursal -->
        <a href="{{ route('sucursales.create') }}"
            class="w-full md:w-auto inline-block bg-green-500 text-white px-4 py-2 rounded-md hover:bg-green-600 mb-4">
            Crear Nueva Sucursal
        </a>

        <ul class="space-y-6">
            @forelse ($tiendas as $tienda)
                <!-- Mostrar el nombre de la tienda -->
                <h2 class="text-2xl font-semibold mt-6 mb-4">{{ $tienda->nombre_tienda }}</h2>

                @forelse ($tienda->sucursales as $sucursal)
      <li class="flex justify-between items-center p-4 border border-gray-300 rounded-md shadow-sm">
    <div>
        <h3 class="text-xl font-semibold">{{ $sucursal->nombre_sucursal }}</h3>
        <p class="text-sm text-gray-600">Dirección: {{ $sucursal->direccion }}</p>
        <p class="text-sm text-gray-600">Contacto: {{ $sucursal->contacto ?? 'No disponible' }}</p>
        <p class="text-sm mt-1">
            Estado: 
            <span class="{{ $sucursal->estado ? 'text-green-600' : 'text-red-600' }}">
                {{ $sucursal->estado ? 'Activa' : 'Inactiva' }}
            </span>
        </p>
    </div>

    <div class="flex space-x-4">
        <a href="{{ route('sucursales.edit', $sucursal->id) }}"
           class="bg-yellow-500 text-white px-4 py-2 rounded-md hover:bg-yellow-600">Editar</a>

        <form action="{{ route('sucursales.toggleEstado', $sucursal->id) }}" method="POST">
            @csrf
            @method('PATCH')
            <button type="submit"
                class="{{ $sucursal->estado ? 'bg-red-500 hover:bg-red-600' : 'bg-green-500 hover:bg-green-600' }} text-white px-4 py-2 rounded-md">
                {{ $sucursal->estado ? 'Desactivar' : 'Activar' }}
            </button>
        </form>
    </div>
</li>

                @empty
                    <li class="text-center text-gray-500">No hay sucursales disponibles para esta tienda.</li>
                @endforelse
            @empty
                <li class="text-center text-gray-500">No hay tiendas disponibles.</li>
            @endforelse
        </ul>
    </div>
@endsection