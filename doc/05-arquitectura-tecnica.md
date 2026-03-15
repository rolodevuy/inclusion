# Arquitectura Técnica

## Stack

| Componente     | Tecnología              |
|----------------|-------------------------|
| Backend        | Laravel 11              |
| PHP            | 8.2+                    |
| Frontend       | Blade + Tailwind CSS    |
| Base de datos  | MySQL 8                 |
| Autenticación  | Laravel Breeze          |
| Servidor local | XAMPP (Apache + MySQL)  |
| Control de versiones | Git              |

---

## Estructura del proyecto Laravel

```
inclusion/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── Auth/              # Controladores de Breeze
│   │   │   ├── Candidato/
│   │   │   │   ├── ProfileController.php
│   │   │   │   └── ExperienciaController.php
│   │   │   ├── Empresa/
│   │   │   │   ├── ProfileController.php
│   │   │   │   └── BuscadorController.php
│   │   │   ├── Admin/
│   │   │   │   ├── DashboardController.php
│   │   │   │   ├── UserController.php
│   │   │   │   └── CatalogoController.php
│   │   │   └── PageController.php        # Landing, páginas públicas
│   │   ├── Middleware/
│   │   │   └── CheckRole.php
│   │   └── Requests/
│   │       ├── CandidatoProfileRequest.php
│   │       ├── EmpresaProfileRequest.php
│   │       └── ExperienciaRequest.php
│   ├── Models/
│   │   ├── User.php
│   │   ├── CandidatoProfile.php
│   │   ├── CandidatoExperiencia.php
│   │   ├── EmpresaProfile.php
│   │   ├── Habilidad.php
│   │   ├── CategoriaLaboral.php
│   │   └── Departamento.php
│   └── Policies/
│       ├── CandidatoProfilePolicy.php
│       └── EmpresaProfilePolicy.php
├── database/
│   ├── migrations/
│   └── seeders/
│       ├── DepartamentoSeeder.php
│       ├── CategoriaLaboralSeeder.php
│       ├── HabilidadSeeder.php
│       └── AdminSeeder.php
├── resources/
│   └── views/
│       ├── layouts/
│       │   └── app.blade.php             # Layout principal accesible
│       ├── components/                    # Componentes Blade reutilizables
│       ├── pages/
│       │   └── landing.blade.php
│       ├── candidato/
│       │   ├── profile/
│       │   │   ├── create.blade.php
│       │   │   ├── edit.blade.php
│       │   │   └── show.blade.php
│       │   └── experiencias/
│       │       ├── create.blade.php
│       │       └── edit.blade.php
│       ├── empresa/
│       │   ├── profile/
│       │   │   ├── create.blade.php
│       │   │   ├── edit.blade.php
│       │   │   └── show.blade.php
│       │   └── buscador/
│       │       ├── index.blade.php
│       │       └── show.blade.php
│       └── admin/
│           ├── dashboard.blade.php
│           ├── usuarios/
│           │   └── index.blade.php
│           └── catalogos/
│               └── index.blade.php
└── routes/
    └── web.php
```

---

## Rutas principales

### Públicas
| Método | URI            | Acción                |
|--------|----------------|-----------------------|
| GET    | /              | Landing page          |
| GET    | /login         | Formulario de login   |
| POST   | /login         | Autenticar            |
| GET    | /register      | Formulario de registro|
| POST   | /register      | Crear cuenta          |

### Candidato (auth + role:candidato)
| Método | URI                          | Acción                     |
|--------|------------------------------|----------------------------|
| GET    | /candidato/perfil/crear      | Formulario crear perfil    |
| POST   | /candidato/perfil            | Guardar perfil             |
| GET    | /candidato/perfil            | Ver mi perfil              |
| GET    | /candidato/perfil/editar     | Formulario editar perfil   |
| PUT    | /candidato/perfil            | Actualizar perfil          |
| GET    | /candidato/experiencias/crear| Agregar experiencia        |
| POST   | /candidato/experiencias      | Guardar experiencia        |
| DELETE | /candidato/experiencias/{id} | Eliminar experiencia       |

### Empresa (auth + role:empresa)
| Método | URI                        | Acción                   |
|--------|----------------------------|--------------------------|
| GET    | /empresa/perfil/crear      | Formulario crear perfil  |
| POST   | /empresa/perfil            | Guardar perfil           |
| GET    | /empresa/perfil            | Ver mi perfil            |
| GET    | /empresa/perfil/editar     | Formulario editar perfil |
| PUT    | /empresa/perfil            | Actualizar perfil        |
| GET    | /empresa/buscador          | Buscador de candidatos   |
| GET    | /empresa/candidato/{id}    | Ver perfil de candidato  |

### Admin (auth + role:admin)
| Método | URI                        | Acción                   |
|--------|----------------------------|--------------------------|
| GET    | /admin/dashboard           | Panel principal          |
| GET    | /admin/usuarios            | Listar usuarios          |
| PATCH  | /admin/usuarios/{id}/toggle| Activar/desactivar       |
| GET    | /admin/catalogos           | Gestión de catálogos     |

---

## Middleware

### CheckRole
Verifica que el usuario autenticado tenga el rol requerido.

```php
// Registro en bootstrap/app.php
->withMiddleware(function (Middleware $middleware) {
    $middleware->alias([
        'role' => \App\Http\Middleware\CheckRole::class,
    ]);
})
```

Uso en rutas:
```php
Route::middleware(['auth', 'role:candidato'])->group(function () {
    // rutas de candidato
});
```

---

## Configuración de entorno

### .env (valores clave)
```
APP_NAME="Inclusión Laboral"
APP_URL=http://localhost/inclusion/public
DB_DATABASE=inclusion_laboral
DB_USERNAME=root
DB_PASSWORD=
```
