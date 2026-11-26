<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AipController extends Controller
{
    /**
     * Roles base autorizados para Aula AIP:
     * 1 = Administrador | 5 = Aula AIP
     */
    private const ALLOWED_ROLES = [1, 5];

    private function authorizeRole(): void
    {
        $user = Auth::user();

        if (!$user) {
            abort(403, 'No tienes autorización para acceder al módulo de Aula AIP.');
        }

        if (method_exists($user, 'hasModulePermission') && $user->hasModulePermission('aip')) {
            return;
        }

        $rolId = (int) ($user->rol_id ?? 0);

        if (!in_array($rolId, self::ALLOWED_ROLES, true)) {
            abort(403, 'No tienes autorización para acceder al módulo de Aula AIP.');
        }
    }

    public function index()
    {
        $this->authorizeRole();

        $items = DB::table('aip_items')
            ->select(
                'id',
                'equipment_name',
                'serial_number',
                'brand',
                'model',
                'location',
                'specs',
                'status',
                'created_at'
            )
            ->orderByDesc('created_at')
            ->get()
            ->map(function ($row) {
                $brandModel = trim(($row->brand ?? '') . ' ' . ($row->model ?? ''));
                $obsPartes = array_filter([
                    $brandModel !== '' ? $brandModel : null,
                    $row->location ? 'Ubicación: ' . $row->location : null,
                    $row->specs ?: null,
                ]);

                return (object) [
                    'id'           => $row->id,
                    'name'         => $row->equipment_name,
                    'serial'       => $row->serial_number,
                    'type'         => $row->location ?: 'Aula AIP',
                    'quantity'     => 1,
                    'status'       => $row->status,
                    'observations' => !empty($obsPartes) ? implode(' • ', $obsPartes) : null,
                ];
            });

        $viewName = view()->exists('AIP.index') ? 'AIP.index' : 'aip.index';

        return view($viewName, compact('items'));
    }

    public function store(Request $request)
    {
        $this->authorizeRole();

        $validated = $request->validate([
            'name'         => 'required|string|max:255',
            'serial'       => 'nullable|string|max:255',
            'type'         => 'nullable|string|max:255',
            'quantity'     => 'nullable|integer|min:1',
            'status'       => 'required|string|max:100',
            'observations' => 'nullable|string|max:1000',
        ]);

        $now = now();

        DB::table('aip_items')->insert([
            'equipment_name' => trim($validated['name']),
            'serial_number'  => isset($validated['serial']) && trim($validated['serial']) !== ''
                ? trim($validated['serial'])
                : null,
            'brand'          => null,
            'model'          => null,
            'location'       => isset($validated['type']) && trim($validated['type']) !== ''
                ? trim($validated['type'])
                : 'Aula AIP',
            'specs'          => isset($validated['observations']) && trim($validated['observations']) !== ''
                ? trim($validated['observations'])
                : null,
            'status'         => $validated['status'],
            'created_at'     => $now,
            'updated_at'     => $now,
        ]);

        return redirect()
            ->route('aip.index')
            ->with('success', 'Equipo del Aula AIP registrado correctamente.');
    }

    public function destroy($id)
    {
        $this->authorizeRole();

        $itemId = filter_var($id, FILTER_VALIDATE_INT);
        if (!$itemId || $itemId < 1) {
            abort(404, 'Equipo del Aula AIP no válido.');
        }

        $deleted = DB::table('aip_items')->where('id', $itemId)->delete();

        if ($deleted === 0) {
            abort(404, 'Equipo del Aula AIP no encontrado.');
        }

        return redirect()
            ->route('aip.index')
            ->with('success', 'Equipo del Aula AIP eliminado correctamente.');
    }
}