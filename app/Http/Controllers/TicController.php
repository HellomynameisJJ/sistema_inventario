<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;

class TicController extends Controller
{
    /**
     * Roles base autorizados para Equipos TIC:
     * 1 = Administrador | 4 = Equipos TIC
     */
    private array $allowedRoles = [1, 4];

    private function authorizeRole(): void
    {
        $user = Auth::user();

        if (!$user) {
            abort(403, 'No tienes autorización para acceder al módulo de Equipos TIC.');
        }

        if (method_exists($user, 'hasModulePermission') && $user->hasModulePermission('tic')) {
            return;
        }

        if (!in_array((int) $user->rol_id, $this->allowedRoles, true)) {
            abort(403, 'No tienes autorización para acceder al módulo de Equipos TIC.');
        }
    }

    private function ensureTableExists(): void
    {
        if (!Schema::hasTable('tic_items')) {
            Schema::create('tic_items', function (Blueprint $table) {
                $table->id();
                $table->string('equipment_name');
                $table->string('location')->nullable();
                $table->string('serial_number')->nullable();
                $table->string('brand')->nullable();
                $table->string('model')->nullable();
                $table->integer('quantity')->default(1);
                $table->string('status')->default('Bueno');
                $table->text('specs')->nullable();
                $table->timestamps();
            });
        }
    }

    public function index()
    {
        $this->authorizeRole();
        $this->ensureTableExists();

        $items = DB::table('tic_items')
            ->orderBy('created_at', 'desc')
            ->get()
            ->map(function ($item) {
                return (object) [
                    'id'             => $item->id,
                    'objeto'         => $item->equipment_name,
                    'barcode_serial' => $item->serial_number,
                    'brand_model'    => trim(($item->brand ?? '') . ' ' . ($item->model ?? '')),
                    'cantidad'       => $item->quantity ?? 1,
                    'condicion'      => $item->status,
                    'location'       => $item->location,
                    'details'        => $item->specs,
                ];
            });

        return view('TIC.index', compact('items'));
    }

    public function store(Request $request)
    {
        $this->authorizeRole();
        $this->ensureTableExists();

        $validated = $request->validate([
            'objeto'         => 'required|string|max:255',
            'location'       => 'nullable|string|max:255',
            'barcode_serial' => 'nullable|string|max:255',
            'brand_model'    => 'nullable|string|max:255',
            'cantidad'       => 'required|integer|min:1',
            'condicion'      => 'required|string|max:100',
            'details'        => 'nullable|string|max:1000',
        ]);

        $partes = explode(' ', trim($validated['brand_model'] ?? ''), 2);

        DB::table('tic_items')->insert([
            'equipment_name' => $validated['objeto'],
            'location'       => $validated['location'] ?? null,
            'serial_number'  => $validated['barcode_serial'] ?? null,
            'brand'          => $partes[0] !== '' ? $partes[0] : null,
            'model'          => $partes[1] ?? null,
            'quantity'       => $validated['cantidad'],
            'status'         => $validated['condicion'],
            'specs'          => $validated['details'] ?? null,
            'created_at'     => now(),
            'updated_at'     => now(),
        ]);

        return redirect()->route('tic.index')->with('success', '¡Equipo TIC registrado correctamente!');
    }

    public function destroy($id)
    {
        $this->authorizeRole();
        $this->ensureTableExists();

        DB::table('tic_items')->where('id', $id)->delete();

        return redirect()->route('tic.index')->with('success', 'Equipo TIC eliminado correctamente.');
    }
}