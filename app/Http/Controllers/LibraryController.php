<?php

namespace App\Http\Controllers;

use App\Models\LibraryItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LibraryController extends Controller
{
    private const ALLOWED_ROLES = [1, 2];

    private function authorizeRole(): void
    {
        $user = Auth::user();

        if (!$user) {
            abort(403, 'No tienes autorización para acceder a este módulo.');
        }

        if (method_exists($user, 'hasModulePermission') && $user->hasModulePermission('library')) {
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

        $items = LibraryItem::latest()->get();

        return view('library.index', compact('items'));
    }

    public function store(Request $request)
    {
        $this->authorizeRole();

        $validated = $request->validate([
            'identificador' => 'nullable|string|max:255',
            'denominacion'  => 'required|string|max:255',
            'coleccion'     => 'nullable|string|max:255',
            'cantidad'      => 'required|integer|min:1',
            'autor'         => 'nullable|string|max:255',
            'editorial'     => 'nullable|string|max:255',
            'anio_edicion'  => 'nullable|string|max:255',
            'estado'        => 'required|string|in:Bueno,Regular,Malo',
            'observaciones' => 'nullable|string|max:2000',
        ]);

        $validated['title'] = $validated['denominacion'];

        LibraryItem::create($validated);

        return redirect()->back()->with('success', '¡Libro registrado correctamente!');
    }

    public function destroy($id)
    {
        $this->authorizeRole();

        $item = LibraryItem::findOrFail($id);
        $item->delete();

        return redirect()->back()->with('success', 'Libro eliminado correctamente.');
    }
}