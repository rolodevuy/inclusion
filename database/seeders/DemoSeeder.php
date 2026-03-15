<?php

namespace Database\Seeders;

use App\Models\CandidatoProfile;
use App\Models\OfertaEmpleo;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DemoSeeder extends Seeder
{
    /**
     * Datos de demostración: 5 empresas, 15 ofertas, 100 candidatos.
     * Ejecutar: php artisan db:seed --class=DemoSeeder
     */
    public function run(): void
    {
        $password = Hash::make('password');

        // ── Admin ───────────────────────────────────────────
        User::firstOrCreate(
            ['email' => 'admin@demo.com'],
            ['name' => 'Admin Demo', 'password' => $password, 'role' => 'admin', 'is_active' => true, 'email_verified_at' => now()]
        );

        // ── Empresas ──────────────────────────────────────────
        $empresas = [
            ['email' => 'techco@demo.com', 'name' => 'TechCo Uruguay', 'rut' => '211234560018', 'sector' => 'Tecnología', 'descripcion' => 'Desarrollo de software con foco en accesibilidad.', 'departamento_id' => 7, 'politicas_inclusion' => 'Horarios flexibles, trabajo remoto, lectores de pantalla.'],
            ['email' => 'hotel@demo.com', 'name' => 'Hotel Inclusivo', 'rut' => '211234560025', 'sector' => 'Turismo', 'descripcion' => 'Cadena hotelera comprometida con la inclusión.', 'departamento_id' => 2, 'politicas_inclusion' => 'Capacitación, mentorías, puestos adaptados.'],
            ['email' => 'contaplus@demo.com', 'name' => 'ContaPlus', 'rut' => '211234560032', 'sector' => 'Servicios contables', 'descripcion' => 'Estudio contable con 20 años de trayectoria.', 'departamento_id' => 7, 'politicas_inclusion' => 'Espacios accesibles, software adaptado.'],
            ['email' => 'saludya@demo.com', 'name' => 'SaludYa', 'rut' => '211234560049', 'sector' => 'Salud', 'descripcion' => 'Centro de salud integral.', 'departamento_id' => 12, 'politicas_inclusion' => 'Turnos rotativos adaptables, transporte.'],
            ['email' => 'educamas@demo.com', 'name' => 'EducaMás', 'rut' => '211234560056', 'sector' => 'Educación', 'descripcion' => 'Instituto de formación profesional inclusiva.', 'departamento_id' => 7, 'politicas_inclusion' => 'Aulas accesibles, intérpretes de LSU.'],
        ];

        $empresaModels = [];
        foreach ($empresas as $e) {
            $user = User::firstOrCreate(
                ['email' => $e['email']],
                ['name' => $e['name'], 'password' => $password, 'role' => 'empresa', 'is_active' => true]
            );
            $user->empresaProfile()->firstOrCreate([], [
                'rut' => $e['rut'], 'sector' => $e['sector'], 'descripcion' => $e['descripcion'],
                'departamento_id' => $e['departamento_id'], 'politicas_inclusion' => $e['politicas_inclusion'],
            ]);
            $empresaModels[$e['email']] = $user;
        }

        // ── Ofertas (15) ──────────────────────────────────────
        $ofertas = [
            // TechCo (tecnología)
            ['emp' => 'techco@demo.com', 'titulo' => 'Desarrollador/a Web', 'descripcion' => 'Desarrollo frontend y backend. Conocimientos en programación, diseño web y bases de datos.', 'cat' => 13, 'dep' => 7, 'mod' => 'remoto', 'req' => 'HTML, CSS, JavaScript, frameworks web.', 'adapt' => 'Lector de pantalla, horarios flexibles, remoto 100%.'],
            ['emp' => 'techco@demo.com', 'titulo' => 'Soporte Técnico', 'descripcion' => 'Soporte técnico a usuarios internos y externos. Resolución de incidencias.', 'cat' => 13, 'dep' => 7, 'mod' => 'hibrido', 'req' => 'Soporte técnico, atención al cliente, ofimática.', 'adapt' => 'Puesto adaptado, software de asistencia.'],
            ['emp' => 'techco@demo.com', 'titulo' => 'Community Manager', 'descripcion' => 'Gestión de redes sociales, creación de contenido y comunicación digital. Manejo de redes sociales.', 'cat' => 4, 'dep' => 7, 'mod' => 'remoto', 'req' => 'Redacción, manejo de redes sociales, diseño básico.', 'adapt' => 'Remoto, horarios flexibles.'],
            ['emp' => 'techco@demo.com', 'titulo' => 'Analista de Datos', 'descripcion' => 'Análisis de datos, reportes y dashboards. Programación en Python o R.', 'cat' => 13, 'dep' => 7, 'mod' => 'remoto', 'req' => 'Programación, estadística, visualización de datos.', 'adapt' => 'Remoto, herramientas accesibles.'],
            // Hotel (turismo/admin)
            ['emp' => 'hotel@demo.com', 'titulo' => 'Recepcionista de Hotel', 'descripcion' => 'Atención al cliente, atención telefónica, gestión de reservas y archivo.', 'cat' => 2, 'dep' => 2, 'mod' => 'presencial', 'req' => 'Atención telefónica, manejo de agenda, archivo.', 'adapt' => 'Mostrador adaptado.'],
            ['emp' => 'hotel@demo.com', 'titulo' => 'Auxiliar Administrativo/a', 'descripcion' => 'Gestión documental, archivo y organización. Manejo de ofimática (Word, Excel).', 'cat' => 1, 'dep' => 2, 'mod' => 'presencial', 'req' => 'Ofimática, gestión documental, archivo y organización.', 'adapt' => 'Puesto ergonómico.'],
            ['emp' => 'hotel@demo.com', 'titulo' => 'Ayudante de Cocina', 'descripcion' => 'Apoyo en cocina, preparación de ingredientes, limpieza.', 'cat' => 8, 'dep' => 2, 'mod' => 'presencial', 'req' => 'Ganas de aprender, higiene.', 'adapt' => null],
            // ContaPlus (contabilidad)
            ['emp' => 'contaplus@demo.com', 'titulo' => 'Auxiliar Contable', 'descripcion' => 'Registro de asientos, conciliaciones bancarias, manejo de ofimática.', 'cat' => 5, 'dep' => 7, 'mod' => 'hibrido', 'req' => 'Contabilidad básica, ofimática (Excel avanzado).', 'adapt' => 'Software de accesibilidad, horarios flexibles.'],
            ['emp' => 'contaplus@demo.com', 'titulo' => 'Administrativo/a', 'descripcion' => 'Gestión documental, archivo, atención telefónica, manejo de agenda.', 'cat' => 1, 'dep' => 7, 'mod' => 'presencial', 'req' => 'Gestión documental, ofimática, archivo.', 'adapt' => 'Espacio accesible.'],
            // SaludYa (salud)
            ['emp' => 'saludya@demo.com', 'titulo' => 'Recepcionista Clínica', 'descripcion' => 'Atención al paciente, gestión de turnos, atención telefónica.', 'cat' => 2, 'dep' => 12, 'mod' => 'presencial', 'req' => 'Atención al cliente, manejo de agenda, ofimática.', 'adapt' => 'Mostrador adaptado, señalización accesible.'],
            ['emp' => 'saludya@demo.com', 'titulo' => 'Auxiliar de Enfermería', 'descripcion' => 'Apoyo en cuidados básicos de pacientes.', 'cat' => 12, 'dep' => 12, 'mod' => 'presencial', 'req' => 'Formación en salud, empatía.', 'adapt' => null],
            // EducaMás (educación)
            ['emp' => 'educamas@demo.com', 'titulo' => 'Docente de Informática', 'descripcion' => 'Enseñanza de programación y ofimática a jóvenes y adultos.', 'cat' => 7, 'dep' => 7, 'mod' => 'presencial', 'req' => 'Programación, ofimática, pedagogía.', 'adapt' => 'Aulas accesibles, intérprete LSU.'],
            ['emp' => 'educamas@demo.com', 'titulo' => 'Coordinador/a de Inclusión', 'descripcion' => 'Coordinar programas de inclusión laboral y social.', 'cat' => 14, 'dep' => 7, 'mod' => 'hibrido', 'req' => 'Trabajo social, gestión de proyectos, redacción.', 'adapt' => 'Horarios flexibles.'],
            ['emp' => 'educamas@demo.com', 'titulo' => 'Diseñador/a Gráfico', 'descripcion' => 'Diseño de material educativo, manejo de redes sociales, diseño web.', 'cat' => 6, 'dep' => 7, 'mod' => 'remoto', 'req' => 'Diseño gráfico, diseño web, creatividad.', 'adapt' => 'Remoto.'],
            ['emp' => 'educamas@demo.com', 'titulo' => 'Vendedor/a Telefónico', 'descripcion' => 'Venta de cursos por teléfono, atención al cliente, seguimiento comercial.', 'cat' => 3, 'dep' => 7, 'mod' => 'hibrido', 'req' => 'Ventas, atención telefónica, persuasión.', 'adapt' => 'Headset adaptado, horarios flexibles.'],
        ];

        foreach ($ofertas as $o) {
            OfertaEmpleo::firstOrCreate(
                ['titulo' => $o['titulo'], 'empresa_user_id' => $empresaModels[$o['emp']]->id],
                [
                    'empresa_user_id' => $empresaModels[$o['emp']]->id,
                    'descripcion' => $o['descripcion'],
                    'categoria_laboral_id' => $o['cat'],
                    'departamento_id' => $o['dep'],
                    'modalidad' => $o['mod'],
                    'requisitos' => $o['req'],
                    'adaptaciones_disponibles' => $o['adapt'],
                    'estado' => 'activa',
                ]
            );
        }

        // ── 100 Candidatos ────────────────────────────────────
        $nombres = [
            'Ana', 'Carlos', 'Lucía', 'Martín', 'Valentina', 'Santiago', 'Camila', 'Mateo',
            'Sofía', 'Nicolás', 'Florencia', 'Joaquín', 'María', 'Federico', 'Agustina',
            'Diego', 'Carolina', 'Sebastián', 'Paula', 'Gonzalo', 'Laura', 'Andrés',
            'Daniela', 'Fernando', 'Andrea', 'Gabriel', 'Natalia', 'Rodrigo', 'Victoria',
            'Emilio', 'Constanza', 'Ignacio', 'Romina', 'Facundo', 'Silvana', 'Tomás',
            'Cecilia', 'Maximiliano', 'Lorena', 'Bruno', 'Micaela', 'Pablo', 'Clara',
            'Ramiro', 'Julieta', 'Alan', 'Antonella', 'Leandro', 'Milagros', 'Iván',
        ];

        $apellidos = [
            'Rodríguez', 'Méndez', 'Fernández', 'García', 'López', 'Martínez', 'González',
            'Díaz', 'Pérez', 'Sánchez', 'Romero', 'Suárez', 'Torres', 'Álvarez', 'Ruiz',
            'Ramírez', 'Flores', 'Acosta', 'Medina', 'Castro', 'Ríos', 'Herrera',
            'Varela', 'Silva', 'Benítez', 'Cabrera', 'Núñez', 'Figueroa', 'Pereyra', 'Olivera',
        ];

        // Distribución de categorías (con repeticiones intencionadas)
        // 1=Admin, 2=Atención, 3=Comercio, 4=Comunicación, 5=Contabilidad, 6=Diseño,
        // 7=Educación, 8=Gastronomía, 9=Logística, 10=Mantenimiento, 11=Producción,
        // 12=Salud, 13=Tecnología, 14=Trabajo Social, 15=Otro
        $perfiles = [
            // 15 en Tecnología (cat 13)
            ['cat' => 13, 'mod' => 'remoto', 'habs' => [7, 8, 9]],
            ['cat' => 13, 'mod' => 'remoto', 'habs' => [8, 9]],
            ['cat' => 13, 'mod' => 'hibrido', 'habs' => [7, 8]],
            ['cat' => 13, 'mod' => 'remoto', 'habs' => [7, 8, 9, 10]],
            ['cat' => 13, 'mod' => 'hibrido', 'habs' => [7, 6]],
            ['cat' => 13, 'mod' => 'presencial', 'habs' => [7]],
            ['cat' => 13, 'mod' => 'remoto', 'habs' => [8]],
            ['cat' => 13, 'mod' => 'remoto', 'habs' => [8, 9]],
            ['cat' => 13, 'mod' => 'hibrido', 'habs' => [7, 8, 6]],
            ['cat' => 13, 'mod' => 'remoto', 'habs' => [8, 9, 10]],
            ['cat' => 13, 'mod' => 'remoto', 'habs' => [7, 9]],
            ['cat' => 13, 'mod' => 'hibrido', 'habs' => [8]],
            ['cat' => 13, 'mod' => 'presencial', 'habs' => [7, 8]],
            ['cat' => 13, 'mod' => 'remoto', 'habs' => [8, 9, 6]],
            ['cat' => 13, 'mod' => 'remoto', 'habs' => [7, 8, 9]],
            // 12 en Administración (cat 1)
            ['cat' => 1, 'mod' => 'presencial', 'habs' => [1, 2, 3, 6]],
            ['cat' => 1, 'mod' => 'presencial', 'habs' => [1, 2, 6]],
            ['cat' => 1, 'mod' => 'hibrido', 'habs' => [1, 3, 6]],
            ['cat' => 1, 'mod' => 'presencial', 'habs' => [2, 3, 6]],
            ['cat' => 1, 'mod' => 'presencial', 'habs' => [1, 2, 3]],
            ['cat' => 1, 'mod' => 'hibrido', 'habs' => [1, 6]],
            ['cat' => 1, 'mod' => 'presencial', 'habs' => [1, 2, 4, 6]],
            ['cat' => 1, 'mod' => 'presencial', 'habs' => [2, 6]],
            ['cat' => 1, 'mod' => 'presencial', 'habs' => [1, 2, 3, 4, 6]],
            ['cat' => 1, 'mod' => 'hibrido', 'habs' => [1, 3]],
            ['cat' => 1, 'mod' => 'presencial', 'habs' => [1, 2]],
            ['cat' => 1, 'mod' => 'presencial', 'habs' => [3, 4, 6]],
            // 10 en Atención al Cliente (cat 2)
            ['cat' => 2, 'mod' => 'presencial', 'habs' => [4, 3, 6]],
            ['cat' => 2, 'mod' => 'presencial', 'habs' => [4, 3]],
            ['cat' => 2, 'mod' => 'hibrido', 'habs' => [4, 6]],
            ['cat' => 2, 'mod' => 'presencial', 'habs' => [3, 4]],
            ['cat' => 2, 'mod' => 'presencial', 'habs' => [4]],
            ['cat' => 2, 'mod' => 'presencial', 'habs' => [4, 3, 1]],
            ['cat' => 2, 'mod' => 'hibrido', 'habs' => [4, 6]],
            ['cat' => 2, 'mod' => 'presencial', 'habs' => [3, 4, 6]],
            ['cat' => 2, 'mod' => 'presencial', 'habs' => [4, 1]],
            ['cat' => 2, 'mod' => 'presencial', 'habs' => [4, 3]],
            // 8 en Comunicación (cat 4)
            ['cat' => 4, 'mod' => 'remoto', 'habs' => [5, 10]],
            ['cat' => 4, 'mod' => 'remoto', 'habs' => [5, 10, 9]],
            ['cat' => 4, 'mod' => 'hibrido', 'habs' => [5, 10]],
            ['cat' => 4, 'mod' => 'remoto', 'habs' => [10]],
            ['cat' => 4, 'mod' => 'remoto', 'habs' => [5, 10]],
            ['cat' => 4, 'mod' => 'hibrido', 'habs' => [5]],
            ['cat' => 4, 'mod' => 'remoto', 'habs' => [5, 10, 9]],
            ['cat' => 4, 'mod' => 'remoto', 'habs' => [10, 9]],
            // 8 en Contabilidad (cat 5)
            ['cat' => 5, 'mod' => 'presencial', 'habs' => [6, 1]],
            ['cat' => 5, 'mod' => 'hibrido', 'habs' => [6, 1, 2]],
            ['cat' => 5, 'mod' => 'presencial', 'habs' => [6]],
            ['cat' => 5, 'mod' => 'hibrido', 'habs' => [6, 1]],
            ['cat' => 5, 'mod' => 'presencial', 'habs' => [6, 2]],
            ['cat' => 5, 'mod' => 'presencial', 'habs' => [6, 1]],
            ['cat' => 5, 'mod' => 'hibrido', 'habs' => [6]],
            ['cat' => 5, 'mod' => 'presencial', 'habs' => [1, 6]],
            // 7 en Comercio (cat 3)
            ['cat' => 3, 'mod' => 'presencial', 'habs' => [4]],
            ['cat' => 3, 'mod' => 'hibrido', 'habs' => [4, 10]],
            ['cat' => 3, 'mod' => 'presencial', 'habs' => [4, 5]],
            ['cat' => 3, 'mod' => 'presencial', 'habs' => [4]],
            ['cat' => 3, 'mod' => 'hibrido', 'habs' => [4, 5]],
            ['cat' => 3, 'mod' => 'presencial', 'habs' => [4, 10]],
            ['cat' => 3, 'mod' => 'presencial', 'habs' => [4]],
            // 6 en Diseño (cat 6)
            ['cat' => 6, 'mod' => 'remoto', 'habs' => [9, 10]],
            ['cat' => 6, 'mod' => 'remoto', 'habs' => [9]],
            ['cat' => 6, 'mod' => 'hibrido', 'habs' => [9, 10]],
            ['cat' => 6, 'mod' => 'remoto', 'habs' => [9, 5]],
            ['cat' => 6, 'mod' => 'remoto', 'habs' => [9, 10, 5]],
            ['cat' => 6, 'mod' => 'hibrido', 'habs' => [9]],
            // 6 en Salud (cat 12)
            ['cat' => 12, 'mod' => 'presencial', 'habs' => [4]],
            ['cat' => 12, 'mod' => 'presencial', 'habs' => [4, 3]],
            ['cat' => 12, 'mod' => 'presencial', 'habs' => []],
            ['cat' => 12, 'mod' => 'presencial', 'habs' => [4]],
            ['cat' => 12, 'mod' => 'presencial', 'habs' => [4, 1]],
            ['cat' => 12, 'mod' => 'presencial', 'habs' => []],
            // 6 en Educación (cat 7)
            ['cat' => 7, 'mod' => 'presencial', 'habs' => [5, 6, 8]],
            ['cat' => 7, 'mod' => 'hibrido', 'habs' => [5, 6]],
            ['cat' => 7, 'mod' => 'presencial', 'habs' => [5, 8]],
            ['cat' => 7, 'mod' => 'presencial', 'habs' => [5]],
            ['cat' => 7, 'mod' => 'hibrido', 'habs' => [5, 6, 8]],
            ['cat' => 7, 'mod' => 'presencial', 'habs' => [6, 8]],
            // 5 en Gastronomía (cat 8)
            ['cat' => 8, 'mod' => 'presencial', 'habs' => []],
            ['cat' => 8, 'mod' => 'presencial', 'habs' => []],
            ['cat' => 8, 'mod' => 'presencial', 'habs' => [4]],
            ['cat' => 8, 'mod' => 'presencial', 'habs' => []],
            ['cat' => 8, 'mod' => 'presencial', 'habs' => []],
            // 5 en Trabajo Social (cat 14)
            ['cat' => 14, 'mod' => 'presencial', 'habs' => [5, 4]],
            ['cat' => 14, 'mod' => 'hibrido', 'habs' => [5]],
            ['cat' => 14, 'mod' => 'presencial', 'habs' => [5, 10]],
            ['cat' => 14, 'mod' => 'hibrido', 'habs' => [5, 4]],
            ['cat' => 14, 'mod' => 'presencial', 'habs' => [5]],
            // 4 en Logística (cat 9)
            ['cat' => 9, 'mod' => 'presencial', 'habs' => [2]],
            ['cat' => 9, 'mod' => 'presencial', 'habs' => [2, 1]],
            ['cat' => 9, 'mod' => 'presencial', 'habs' => []],
            ['cat' => 9, 'mod' => 'presencial', 'habs' => [2]],
            // 4 en Mantenimiento (cat 10)
            ['cat' => 10, 'mod' => 'presencial', 'habs' => []],
            ['cat' => 10, 'mod' => 'presencial', 'habs' => []],
            ['cat' => 10, 'mod' => 'presencial', 'habs' => [2]],
            ['cat' => 10, 'mod' => 'presencial', 'habs' => []],
            // 4 en Producción (cat 11)
            ['cat' => 11, 'mod' => 'presencial', 'habs' => []],
            ['cat' => 11, 'mod' => 'presencial', 'habs' => [2]],
            ['cat' => 11, 'mod' => 'presencial', 'habs' => []],
            ['cat' => 11, 'mod' => 'presencial', 'habs' => []],
        ];

        $discapacidades = ['Visual', 'Auditiva', 'Motriz', 'Intelectual', 'Psicosocial', 'Visceral', null];
        $visibilidades = ['publica', 'bajo_solicitud', 'privada'];
        $niveles = ['Primaria completa', 'Secundario completo', 'Terciario', 'Universitario', 'Posgrado'];
        $departamentos = [1, 2, 3, 4, 5, 6, 7, 7, 7, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19]; // Montevideo (7) más probable

        $sobreMis = [
            'Persona proactiva con ganas de crecer profesionalmente.',
            'Busco oportunidades que me permitan desarrollar mis habilidades.',
            'Experiencia en el área, busco nuevos desafíos.',
            'Autodidacta, responsable y con buena predisposición.',
            'Me apasiona aprender y aportar al equipo.',
            'Con experiencia previa en el rubro y ganas de seguir creciendo.',
            'Profesional comprometido/a con la excelencia.',
            'Busco un ambiente laboral inclusivo donde pueda aportar.',
            'Persona organizada, puntual y con buena comunicación.',
            'Entusiasta, creativo/a y orientado/a a resultados.',
        ];

        for ($i = 0; $i < 100; $i++) {
            $nombre = $nombres[$i % count($nombres)];
            $apellido = $apellidos[$i % count($apellidos)];
            // Evitar duplicados de email
            $emailBase = strtolower(str_replace(['á','é','í','ó','ú','ñ'], ['a','e','i','o','u','n'], $nombre));
            $email = $emailBase . ($i + 1) . '@demo.com';

            $perfil = $perfiles[$i];
            $dep = $departamentos[$i % count($departamentos)];
            $disc = $discapacidades[$i % count($discapacidades)];

            $user = User::firstOrCreate(
                ['email' => $email],
                ['name' => "$nombre $apellido", 'password' => $password, 'role' => 'candidato', 'is_active' => true]
            );

            $profile = CandidatoProfile::firstOrCreate(
                ['user_id' => $user->id],
                [
                    'departamento_id' => $dep,
                    'categoria_laboral_id' => $perfil['cat'],
                    'modalidad_trabajo' => $perfil['mod'],
                    'nivel_educativo' => $niveles[$i % count($niveles)],
                    'sobre_mi' => $sobreMis[$i % count($sobreMis)],
                    'tipo_discapacidad' => $disc,
                    'tiene_certificado' => $disc !== null && ($i % 3 !== 0),
                    'visibilidad_discapacidad' => $visibilidades[$i % count($visibilidades)],
                ]
            );

            if (!empty($perfil['habs'])) {
                $profile->habilidades()->syncWithoutDetaching($perfil['habs']);
            }
        }

        $this->command->info('Datos de demostración creados: 5 empresas, 15 ofertas, 100 candidatos.');
        $this->command->info('Password para todos: password');
    }
}
