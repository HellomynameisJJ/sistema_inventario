<?php

namespace App\Http\Controllers;

use App\Models\LaboratoryItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LaboratoryController extends Controller
{
    private const ALLOWED_ROLES = [1, 6];

    private function authorizeRole(): void
    {
        $user = Auth::user();

        if (!$user) {
            abort(403, 'No tienes autorización para acceder a este módulo.');
        }

        if (method_exists($user, 'hasModulePermission') && $user->hasModulePermission('laboratory')) {
            return;
        }

        $rolId = (int) ($user->rol_id ?? 0);
        if (!in_array($rolId, self::ALLOWED_ROLES, true)) {
            abort(403, 'No tienes autorización para acceder a este módulo.');
        }
    }

    public function index()
    {
        $this->authorizeRole();

        $items = LaboratoryItem::latest('id')->get();

        return view('laboratory.index', compact('items'));
    }

    public function store(Request $request)
    {
        $this->authorizeRole();

        $validated = $request->validate([
            'item'                 => 'nullable|string|max:100',
            'codigo_interno'       => 'nullable|string|max:100',
            'denominacion_tecnica' => 'required|string|max:255',
            'descripcion_tecnica'  => 'nullable|string|max:2000',
            'cantidad'             => 'required|integer|min:1|max:100000',
        ]);

        LaboratoryItem::create([
            'item'                 => isset($validated['item']) && trim($validated['item']) !== '' ? trim($validated['item']) : null,
            'codigo_interno'       => isset($validated['codigo_interno']) && trim($validated['codigo_interno']) !== '' ? trim($validated['codigo_interno']) : null,
            'denominacion_tecnica' => trim($validated['denominacion_tecnica']),
            'descripcion_tecnica'  => isset($validated['descripcion_tecnica']) && trim($validated['descripcion_tecnica']) !== '' ? trim($validated['descripcion_tecnica']) : null,
            'cantidad'             => (int) $validated['cantidad'],
        ]);

        return redirect()->back()->with('success', '¡Registro de laboratorio guardado correctamente!');
    }

    public function destroy($id)
    {
        $this->authorizeRole();

        $item = LaboratoryItem::findOrFail($id);
        $item->delete();

        return redirect()->back()->with('success', 'Registro eliminado correctamente.');
    }
}