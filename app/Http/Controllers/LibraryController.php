<?php

namespace App\Http\Controllers;

use App\Models\LibraryItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LibraryController extends Controller
{
    public function index()
    {
        // Validar que el usuario tenga rol de Administrador (1) o Biblioteca (2)
        $user = Auth::user();
        if (!$user || ($user->rol_id != 1 && $user->rol_id != 2)) {
            abort(403, 'No tienes autorización para acceder a este módulo.');
        }

        $items = LibraryItem::latest()->get()->map(function ($item) {
            return (object) [
                'id'              => $item->id,
                'objeto'          => $item->title,
                'barcode_serial'  => $item->isbn,
                'brand_model'     => $item->author,
                'cantidad'        => $item->quantity,
                'condicion'       => $item->status,
                'location'        => null,
                'details'         => $item->observaciones,
            ];
        });

        return view('library.index', compact('items'));
    }

    public function store(Request $request)
    {
        $user = Auth::user();
        if (!$user || ($user->rol_id != 1 && $user->rol_id != 2)) {
            abort(403, 'No tienes autorización para realizar esta acción.');
        }

        $validated = $request->validate([
            'objeto'          => 'required|string|max:255',
            'brand_model'     => 'nullable|string|max:255',
            'barcode_serial'  => 'nullable|string|max:255',
            'cantidad'        => 'required|integer|min:1',
            'condicion'       => 'required|string',
            'details'         => 'nullable|string',
        ]);

        LibraryItem::create([
            'title'         => $validated['objeto'],
            'author'        => $validated['brand_model'] ?? null,
            'isbn'          => $validated['barcode_serial'] ?? null,
            'quantity'      => $validated['cantidad'],
            'status'        => $validated['condicion'],
            'observaciones' => $validated['details'] ?? null,
        ]);

        return redirect()->back()->with('success', '¡Material registrado correctamente!');
    }

    public function destroy($id)
    {
        $user = Auth::user();
        if (!$user || ($user->rol_id != 1 && $user->rol_id != 2)) {
            abort(403, 'No tienes autorización para realizar esta acción.');
        }

        $item = LibraryItem::findOrFail($id);
        $item->delete();

        return redirect()->back()->with('success', 'Material eliminado correctamente.');
    }
}