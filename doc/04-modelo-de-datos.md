# Modelo de Datos

## Diagrama de entidades

```
users
├── candidato_profiles
│   ├── candidato_experiencias
│   ├── candidato_habilidad (pivot)
│   └── candidato_adaptaciones
├── empresa_profiles
habilidades
categorias_laborales
departamentos
```

---

## Tablas

### `users`
Tabla base de autenticación (Laravel Breeze).

| Campo         | Tipo         | Descripción                          |
|---------------|--------------|--------------------------------------|
| id            | bigint PK    | Identificador                        |
| name          | varchar(255) | Nombre completo o razón social       |
| email         | varchar(255) | Email único                          |
| password      | varchar(255) | Contraseña hasheada                  |
| role          | enum         | 'candidato', 'empresa', 'admin'      |
| is_active     | boolean      | Estado de la cuenta (default: true)  |
| timestamps    |              | created_at, updated_at               |

---

### `departamentos`
Departamentos de Uruguay.

| Campo  | Tipo         | Descripción       |
|--------|--------------|-------------------|
| id     | bigint PK    | Identificador     |
| nombre | varchar(100) | Nombre             |

---

### `categorias_laborales`
Áreas o categorías de trabajo.

| Campo  | Tipo         | Descripción       |
|--------|--------------|-------------------|
| id     | bigint PK    | Identificador     |
| nombre | varchar(100) | Nombre             |

---

### `habilidades`
Catálogo de habilidades.

| Campo              | Tipo         | Descripción              |
|--------------------|--------------|--------------------------|
| id                 | bigint PK    | Identificador            |
| nombre             | varchar(100) | Nombre de la habilidad   |
| categoria_laboral_id | bigint FK | Categoría asociada (nullable) |

---

### `candidato_profiles`
Perfil profesional del candidato.

| Campo                  | Tipo         | Descripción                                    |
|------------------------|--------------|------------------------------------------------|
| id                     | bigint PK    | Identificador                                  |
| user_id                | bigint FK    | Referencia a users                             |
| departamento_id        | bigint FK    | Departamento                                   |
| categoria_laboral_id   | bigint FK    | Área laboral                                   |
| modalidad_trabajo      | enum         | 'presencial', 'remoto', 'hibrido'              |
| nivel_educativo        | varchar(100) | Nivel de estudios                              |
| sobre_mi               | text         | Descripción personal (nullable)                |
| tipo_discapacidad      | varchar(100) | Tipo de discapacidad (nullable)                |
| tiene_certificado      | boolean      | Certificado de discapacidad (nullable)         |
| necesidades_adaptacion | text         | Adaptaciones necesarias (nullable)             |
| visibilidad_discapacidad | enum       | 'publica', 'bajo_solicitud', 'privada'         |
| timestamps             |              | created_at, updated_at                         |

---

### `candidato_experiencias`
Experiencias laborales del candidato.

| Campo               | Tipo         | Descripción                |
|---------------------|--------------|----------------------------|
| id                  | bigint PK    | Identificador              |
| candidato_profile_id | bigint FK   | Referencia al perfil       |
| cargo               | varchar(255) | Cargo ocupado              |
| empresa             | varchar(255) | Nombre de la empresa       |
| fecha_inicio        | date         | Inicio del período         |
| fecha_fin           | date         | Fin del período (nullable) |
| descripcion         | text         | Descripción de tareas      |
| timestamps          |              | created_at, updated_at     |

---

### `candidato_habilidad` (tabla pivot)
Relación muchos a muchos entre candidatos y habilidades.

| Campo               | Tipo      | Descripción            |
|---------------------|-----------|------------------------|
| candidato_profile_id | bigint FK | Referencia al perfil   |
| habilidad_id        | bigint FK | Referencia a habilidad |

---

### `empresa_profiles`
Perfil de la empresa.

| Campo                | Tipo         | Descripción                       |
|----------------------|--------------|-----------------------------------|
| id                   | bigint PK    | Identificador                     |
| user_id              | bigint FK    | Referencia a users                |
| rut                  | varchar(20)  | RUT de la empresa                 |
| sector               | varchar(100) | Sector/industria                  |
| descripcion          | text         | Descripción de la empresa         |
| departamento_id      | bigint FK    | Ubicación                         |
| sitio_web            | varchar(255) | URL del sitio web (nullable)      |
| logo                 | varchar(255) | Ruta del logo (nullable)          |
| politicas_inclusion  | text         | Políticas de inclusión (nullable) |
| timestamps           |              | created_at, updated_at            |

---

## Relaciones

- `User` hasOne `CandidatoProfile`
- `User` hasOne `EmpresaProfile`
- `CandidatoProfile` belongsTo `User`
- `CandidatoProfile` belongsTo `Departamento`
- `CandidatoProfile` belongsTo `CategoriaLaboral`
- `CandidatoProfile` belongsToMany `Habilidad`
- `CandidatoProfile` hasMany `CandidatoExperiencia`
- `EmpresaProfile` belongsTo `User`
- `EmpresaProfile` belongsTo `Departamento`
- `Habilidad` belongsTo `CategoriaLaboral` (nullable)
