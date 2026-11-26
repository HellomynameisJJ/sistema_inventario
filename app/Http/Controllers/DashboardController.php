<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\InventoryItem;
use App\Models\LibraryItem;
use App\Models\AipItem;
use App\Models\Classroom;
use App\Models\Grade;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        // SEGURIDAD: Solo Administrador (1) puede ver el Dashboard general
        $user = Auth::user();
        if (!$user || (int) $user->rol_id !== 1) {
            abort(403, 'No tienes autorización para acceder a este módulo.');
        }

        $classroomId = $request->input('classroom_id');
        $gradeFilter = $request->input('grade');
        $sectionFilter = $request->input('section');

        // ==========================================
        // CONSULTAS MOBILIARIO
        // ==========================================
        $query = InventoryItem::query();

        if ($classroomId) {
            $query->where('classroom_id', $classroomId);
        }

        if ($gradeFilter || $sectionFilter) {
            $query->whereHas('classroom', function ($q) use ($gradeFilter, $sectionFilter) {
                if ($gradeFilter) {
                    $q->where(function ($sub) use ($gradeFilter) {
                        $sub->where('name', 'ILIKE', $gradeFilter . '°%')
                            ->orWhere('name', 'ILIKE', $gradeFilter . ' %')
                            ->orWhere('name', 'ILIKE', 'Grado ' . $gradeFilter . '%');
                    });
                }
                if ($sectionFilter) {
                    $sec = strtoupper(trim($sectionFilter));
                    $q->where(function ($sub) use ($sec) {
                        $sub->where('name', 'ILIKE', '% ' . $sec)
                            ->orWhere('name', 'ILIKE', '%-' . $sec)
                            ->orWhere('name', 'ILIKE', '%Sección ' . $sec);
                    });
                }
            });
        }

        $totalRegistros = (clone $query)->count();
        $totalCantidad  = (int) (clone $query)->sum('cantidad');

        $cantBueno   = (int) (clone $query)->whereRaw("LOWER(TRIM(condicion)) = 'bueno'")->sum('cantidad');
        $cantRegular = (int) (clone $query)->whereRaw("LOWER(TRIM(condicion)) = 'regular'")->sum('cantidad');
        $cantMalo    = (int) (clone $query)->whereRaw("LOWER(TRIM(condicion)) = 'malo'")->sum('cantidad');

        // ==========================================
        // TOP 10 DE OBJETOS POR CANTIDAD
        // ==========================================
        $topObjetos = (clone $query)
            ->select(
                'objeto',
                DB::raw("SUM(CASE WHEN LOWER(TRIM(condicion)) = 'bueno' THEN cantidad ELSE 0 END) as buenas"),
                DB::raw("SUM(CASE WHEN LOWER(TRIM(condicion)) = 'regular' THEN cantidad ELSE 0 END) as regulares"),
                DB::raw("SUM(CASE WHEN LOWER(TRIM(condicion)) = 'malo' THEN cantidad ELSE 0 END) as malas"),
                DB::raw('SUM(cantidad) as total')
            )
            ->groupBy('objeto')
            ->orderByDesc('total')
            ->limit(10)
            ->get();

        $totalTop   = (int) $topObjetos->sum('total');
        $totalOtros = max(0, $totalCantidad - $totalTop);

        $nombresObjetos    = $topObjetos->pluck('objeto')->toArray();
        $datosBueno        = $topObjetos->pluck('buenas')->map(fn($v) => (int) $v)->toArray();
        $datosRegular      = $topObjetos->pluck('regulares')->map(fn($v) => (int) $v)->toArray();
        $datosMalo         = $topObjetos->pluck('malas')->map(fn($v) => (int) $v)->toArray();
        $cantidadesObjetos = $topObjetos->pluck('total')->map(fn($v) => (int) $v)->toArray();

        if ($totalOtros > 0) {
            $statsOtros = (clone $query)
                ->whereNotIn('objeto', $topObjetos->pluck('objeto'))
                ->select(
                    DB::raw("SUM(CASE WHEN LOWER(TRIM(condicion)) = 'bueno' THEN cantidad ELSE 0 END) as buenas"),
                    DB::raw("SUM(CASE WHEN LOWER(TRIM(condicion)) = 'regular' THEN cantidad ELSE 0 END) as regulares"),
                    DB::raw("SUM(CASE WHEN LOWER(TRIM(condicion)) = 'malo' THEN cantidad ELSE 0 END) as malas")
                )
                ->first();

            $nombresObjetos[]    = 'Otros Objetos';
            $datosBueno[]        = (int) ($statsOtros->buenas ?? 0);
            $datosRegular[]      = (int) ($statsOtros->regulares ?? 0);
            $datosMalo[]         = (int) ($statsOtros->malas ?? 0);
            $cantidadesObjetos[] = (int) $totalOtros;
        }

        $matrizObjetos = $topObjetos;

        // ==========================================
        // DETALLE POR AULA
        // ==========================================
        $detalleAula = (clone $query)
            ->with('classroom')
            ->select(
                'classroom_id',
                'objeto',
                DB::raw("SUM(CASE WHEN LOWER(TRIM(condicion)) = 'bueno' THEN cantidad ELSE 0 END) as buenas"),
                DB::raw("SUM(CASE WHEN LOWER(TRIM(condicion)) = 'regular' THEN cantidad ELSE 0 END) as regulares"),
                DB::raw("SUM(CASE WHEN LOWER(TRIM(condicion)) = 'malo' THEN cantidad ELSE 0 END) as malas"),
                DB::raw('SUM(cantidad) as total')
            )
            ->groupBy('classroom_id', 'objeto')
            ->get()
            ->groupBy(function ($item) {
                return optional($item->classroom)->name ?: 'Sin Asignar';
            })
            ->sortKeys(SORT_NATURAL);

        $classroomsList = Classroom::orderBy('name')->get();
        $grades = Grade::with('classrooms')->get();

        $libraryCol = Schema::hasColumn('library_items', 'cantidad') ? 'cantidad' : 'quantity';
        $totalBiblioteca = (int) LibraryItem::sum($libraryCol);
        $totalAIP = (int) AipItem::count();

        return view('dashboard', compact(
            'totalRegistros', 'totalCantidad', 'cantBueno', 'cantRegular', 'cantMalo',
            'matrizObjetos', 'detalleAula', 'classroomsList', 'classroomId',
            'gradeFilter', 'sectionFilter', 'grades',
            'nombresObjetos', 'datosBueno', 'datosRegular', 'datosMalo', 'cantidadesObjetos',
            'totalBiblioteca', 'totalAIP'
        ));
    }

    public function objetos(Request $request)
    {
        $user = Auth::user();
        if (!$user || (int) $user->rol_id !== 1) {
            abort(403, 'No autorizado.');
        }

        $classroomId = $request->input('classroom_id');

        $query = InventoryItem::query();
        if ($classroomId) {
            $query->where('classroom_id', $classroomId);
        }

        $objetos = (clone $query)
            ->select(
                'objeto',
                DB::raw("SUM(CASE WHEN LOWER(TRIM(condicion)) = 'bueno' THEN cantidad ELSE 0 END) as buenas"),
                DB::raw("SUM(CASE WHEN LOWER(TRIM(condicion)) = 'regular' THEN cantidad ELSE 0 END) as regulares"),
                DB::raw("SUM(CASE WHEN LOWER(TRIM(condicion)) = 'malo' THEN cantidad ELSE 0 END) as malas"),
                DB::raw('SUM(cantidad) as total')
            )
            ->groupBy('objeto')
            ->orderByDesc('total')
            ->get();

        $classroomsList = Classroom::orderBy('name')->get();

        $totalGeneral = (int) $objetos->sum('total');
        $totalBueno   = (int) $objetos->sum('buenas');
        $totalRegular = (int) $objetos->sum('regulares');
        $totalMalo    = (int) $objetos->sum('malas');

        return view('inventory.objetos', compact(
            'objetos', 'classroomsList', 'classroomId',
            'totalGeneral', 'totalBueno', 'totalRegular', 'totalMalo'
        ));
    }
}
