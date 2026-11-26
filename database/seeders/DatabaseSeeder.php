<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Grade;
use App\Models\Classroom;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // ==========================================
        // 1. USUARIOS INSTITUCIONALES (ACCESOS A MÓDULOS)
        // ==========================================
        User::updateOrCreate(
            ['dni' => '40000001'],
            [
                'name' => 'Administrador I.E. Tungasuca',
                'password' => Hash::make('AdminTungasuca2026!'),
                'role' => 'admin',
                'rol_id' => 1, // Administrador general (Acceso total)
                'permissions' => json_encode(['inventory', 'library', 'tic', 'aip', 'laboratory'])
            ]
        );

        User::updateOrCreate(
            ['dni' => '40000002'],
            [
                'name' => 'Soporte Técnico',
                'password' => Hash::make('SoporteTec#2026'),
                'role' => 'directiva',
                'rol_id' => 1, // Acceso total tipo admin
                'permissions' => json_encode(['inventory', 'library', 'tic', 'aip', 'laboratory'])
            ]
        );

        User::updateOrCreate(
            ['dni' => '40000003'],
            [
                'name' => 'Encargado de Biblioteca',
                'password' => Hash::make('BiblioTungasuca#03'),
                'role' => 'bibliotecario',
                'rol_id' => 2, // Rol específico de Biblioteca
                'permissions' => json_encode(['library'])
            ]
        );

        User::updateOrCreate(
            ['dni' => '40000004'],
            [
                'name' => 'Encargado de Mobiliario',
                'password' => Hash::make('MobiliarioAulas#04'),
                'role' => 'mobiliario',
                'rol_id' => 3, // Rol específico de Mobiliario / Aulas
                'permissions' => json_encode(['inventory'])
            ]
        );

        User::updateOrCreate(
            ['dni' => '40000005'],
            [
                'name' => 'Encargado de Equipos TIC',
                'password' => Hash::make('EquiposTic#05'),
                'role' => 'tic',
                'rol_id' => 4, // Rol específico de Equipos TIC
                'permissions' => json_encode(['tic'])
            ]
        );

        User::updateOrCreate(
            ['dni' => '40000006'],
            [
                'name' => 'Encargado de Aula AIP',
                'password' => Hash::make('AulaAip#06'),
                'role' => 'aip',
                'rol_id' => 5, // Rol específico de Aula AIP
                'permissions' => json_encode(['aip'])
            ]
        );

        User::updateOrCreate(
            ['dni' => '40000007'],
            [
                'name' => 'Encargado de Laboratorio',
                'password' => Hash::make('LabCiencias#07'),
                'role' => 'laboratorio',
                'rol_id' => 6, // Rol específico de Laboratorio de Ciencias
                'permissions' => json_encode(['laboratory'])
            ]
        );

        // ==========================================
        // 2. GRADOS
        // ==========================================
        $grados = [
            'Primer Grado', 'Segundo Grado', 'Tercer Grado',
            'Cuarto Grado', 'Quinto Grado',
            'Aulas de Innovación y TIC',
        ];

        $gradosIds = [];
        foreach ($grados as $nombre) {
            $g = Grade::firstOrCreate(['name' => $nombre]);
            $gradosIds[$nombre] = $g->id;
        }

        // ==========================================
        // 3. AULAS REGULARES (nombres normalizados del Excel)
        // ==========================================
        $aulasPorGrado = [
            'Primer Grado'  => ['1° A', '1° B', '1° C', '1° D', '1° E'],
            'Segundo Grado' => ['2° A', '2° B', '2° C', '2° D', '2° E'],
            'Tercer Grado'  => ['3° A', '3° B', '3° C', '3° D'],
            'Cuarto Grado'  => ['4° A', '4° B', '4° C', '4° D'],
            'Quinto Grado'  => ['5° A', '5° B', '5° C', '5° D'],
        ];

        foreach ($aulasPorGrado as $grado => $aulas) {
            foreach ($aulas as $aula) {
                Classroom::firstOrCreate(
                    ['name' => strtoupper($aula)],
                    ['grade_id' => $gradosIds[$grado]]
                );
            }
        }

        // ==========================================
        // 4. AULAS ESPECIALES
        // ==========================================
        $aulasEspeciales = [
            'AIP',
            'AULA DE INGLES',
            'AULA DE INNOVACIÓN PEDAGOGICA',
            'AULA DE INNOVACION',
            'AULA TIC-MATEMATICA',
            'AULA TIC-EPT',
            'AULA TIC-INGLES',
            'AULA DE COMPUTO',
            'AREA DE CIENCIAS SOCIALES',
            'AREA DE COMUNICACION',
            'EPT',
            'TALLER DE MATEMATICA',
            'LABORATORIO CTA',
            'LABORATORIO',
            'DIRECCIÓN',
            'SUBDIRECCION',
            'SECRETARIA',
            'SECRETARIA DE DIRECCION',
            'SALA DE PROFESORES',
            'SALA DE COORDINACION',
            'PSICOLOGIA',
            'TUTORIA',
            'AULA TOE',
            'ALMACÉN',
            'DEPOSITO',
            'PATIO',
            'PATIO CENTRAL',
            'PATIO GENERAL',
            'BIBLIOTECA',
        ];

        foreach ($aulasEspeciales as $nombre) {
            Classroom::firstOrCreate(
                ['name' => strtoupper($nombre)],
                ['grade_id' => $gradosIds['Aulas de Innovación y TIC']]
            );
        }

        // ==========================================
        // 5. EJECUTAR EL SEEDER DEL INVENTARIO
        // ==========================================
        $this->call([
            InventarioSeeder::class,
        ]);
    }
}