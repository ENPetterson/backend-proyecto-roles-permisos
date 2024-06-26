<?php

namespace App\Http\Controllers;

use App\Models\Permiso;
use Illuminate\Http\Request;

class PermisoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //$this->authorize("index_permiso");

        $permisos = Permiso::get();
 
        return response()->json($permisos);
    }

    public function indexPaginacion() {
        $permisos = Permiso::paginate(10);

        return response()->json($permisos);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->authorize("store_permiso");

        $request->validate([
            "nombre" => "required|unique:permisos"
        ]);

        $permiso = new Permiso();
        $permiso->nombre = $request->nombre;
        $permiso->detalle = $request->detalle;
        $permiso->save();

        return response()->json(["message" => "El permiso ha sido registrado"], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $this->authorize("show_permiso");

        $permiso = Permiso::findOrFail($id);

        return response()->json($permiso, 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $this->authorize("update_permiso");

        $request->validate([
            "nombre" => "required|unique:permisos,nombre,$id"
        ]);

        $permiso = Permiso::findOrFail($id);
        $permiso->nombre = $request->nombre;
        $permiso->detalle = $request->detalle;
        $permiso->update();

        return response()->json(["message" => "El permiso ha sido actualizado"], 201);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $this->authorize("delete_permiso");

        $permiso = Permiso::findOrFail($id);
        $permiso->delete();

        return response()->json(["message" => "El permiso ha sido eliminado"], 200);
    }
}
