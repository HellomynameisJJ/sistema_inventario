<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\InventoryItem;
use App\Models\Grade;
use Illuminate\Support\Facades\Auth;

class InventoryItemController extends Controller
{
    private function authorizeInventoryAccess(string $errorMessage = 'No tienes autorización para acceder al módulo de Mobiliario.'): void
    {
        $user = Auth::user();

        if (!$user) {
            abort(403, $errorMessage);
        }

        if (method_exists($user, 'hasModulePermission') && $user->hasModulePermission('inventory')) {
            return;
        }

        if ((int) $user->rol_id === 1 || (int) $user->rol_id === 3) {
            return;
        }

        abort(403, $errorMessage);
    }

    public function index()
    {
        $this->authorizeInventoryAccess('No tienes autorización para acceder al módulo de Mobiliario.');

        $itemsPorAula = InventoryItem::with('classroom.grade')
            ->orderBy('created_at', 'desc')
            ->get()
            ->groupBy(function ($item) {
                return optional($item->classroom)->name ?: 'Sin Asignar';
            })
            ->sortKeys(SORT_NATURAL);

        $grades = Grade::with('classrooms')->get();

        return view('inventory.index', compact('itemsPorAula', 'grades'));
    }

    public function store(Request $request)
    {
        $this->authorizeInventoryAccess('Acción no autorizada.');

        $request->validate([
            'classroom_id' => 'required|exists:classrooms,id',
            'objeto' => 'required|string|max:255',
            'cantidad' => 'required|integer|min:1',
            'condicion' => 'required|string',
        ]);

        InventoryItem::create($request->all());

        return redirect()->route('inventory.index')->with('success', 'Mobiliario registrado correctamente.');
    }

    public function edit($id)
    {
        $this->authorizeInventoryAccess('Acción no autorizada.');

        $item = InventoryItem::findOrFail($id);
        $grades = Grade::with('classrooms')->get();

        return view('inventory.edit', compact('item', 'grades'));
    }

    public function update(Request $request, $id)
    {
        $this->authorizeInventoryAccess('Acción no autorizada.');

        $request->validate([
            'classroom_id' => 'required|exists:classrooms,id',
            'objeto' => 'required|string|max:255',
            'cantidad' => 'required|integer|min:1',
            'condicion' => 'required|string',
        ]);

        $item = InventoryItem::findOrFail($id);
        $item->update($request->all());

        return redirect()->route('inventory.index')->with('success', 'Registro actualizado correctamente.');
    }

    public function destroy($id)
    {
        $this->authorizeInventoryAccess('Acción no autorizada.');

        $item = InventoryItem::findOrFail($id);
        $item->delete();

        return redirect()->route('inventory.index')->with('success', 'Mobiliario eliminado correctamente.');
    }
}