<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use Illuminate\Http\Request;

class CategoriaController extends Controller
{
    // Mostrar todas las categorías
    public function index()
    {
        $categorias = Categoria::all(); // Recuperamos todas las categorías
        return view('categorias.index', compact('categorias')); // Pasamos las categorías a la vista
    }

    // Mostrar el formulario para crear una nueva categoría
    public function create()
    {
        return view('categorias.create');
    }

    // Almacenar una nueva categoría
    public function store(Request $request)
    {
    $request->validate([
    'nombre' => [
        'required',
        'string',
        'max:255',
        'min:2',
        'unique:categorias,nombre',
        // Debe contener al menos una letra y permitir letras, números, espacios y caracteres especiales comunes
        'regex:/^(?=.*[\pL])[ \pL\pN.,()\-]{2,255}$/u',
    ]
], [
    'nombre.regex' => 'El nombre debe tener al menos una letra y puede contener números o símbolos, pero no ser solo un carácter, solo números o solo símbolos.',
    'nombre.unique' => 'Esa categoría ya existe.',
]);



        Categoria::create([
            'nombre' => $request->nombre, // Creamos la nueva categoría
        ]);

        return redirect()->route('categorias.index'); // Redirigimos a la lista de categorías
    }
    public function edit($id)
{
    $categoria = Categoria::findOrFail($id);
    return view('categorias.edit', compact('categoria'));
}

public function update(Request $request, $id)
{
    $request->validate(['nombre' => 'required|max:255']);

    $categoria = Categoria::findOrFail($id);
    $categoria->update(['nombre' => $request->nombre]);

    return redirect()->route('categorias.index');
}

public function destroy($id)
{
    Categoria::destroy($id);
    return redirect()->route('categorias.index');
}
public function toggleEstado($id)
{
    $categoria = Categoria::findOrFail($id);

    // Cambiar el estado
    $nuevoEstado = !$categoria->estado;
    $categoria->estado = $nuevoEstado;
    $categoria->save();

    // Desactivar o activar productos asociados
    $categoria->productos()->update(['estado' => $nuevoEstado]);

    return redirect()->route('categorias.index')->with('success', 'Estado de la categoría y sus productos actualizado.');
}


}

