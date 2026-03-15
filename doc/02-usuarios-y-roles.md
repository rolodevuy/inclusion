# Usuarios y Roles

## Roles del sistema

### 1. Candidato (`candidato`)
Persona con discapacidad o neurodivergencia que busca oportunidades laborales.

**Características:**
- Diversos niveles de alfabetización digital
- Posibles necesidades de accesibilidad
- Diferentes tipos de discapacidad

**Puede:**
- Registrarse y crear perfil profesional
- Indicar habilidades, experiencia y área laboral
- Informar voluntariamente su condición o necesidades de adaptación
- Controlar la visibilidad de su información sensible
- Editar y eliminar su perfil

---

### 2. Empresa (`empresa`)
Organización o reclutador que desea contratar talento diverso.

**Puede:**
- Registrarse como empresa
- Buscar candidatos con filtros
- Ver perfiles de candidatos (según privacidad configurada)
- Gestionar su perfil empresarial

---

### 3. Administrador (`admin`)
Encargado de moderar y gestionar la plataforma.

**Puede:**
- Moderar perfiles de candidatos y empresas
- Validar contenido
- Gestionar usuarios (activar, desactivar, eliminar)
- Ver estadísticas y métricas de uso
- Gestionar categorías, habilidades y configuraciones del sistema

---

## Modelo de autenticación
- Registro con email y contraseña
- Selección de tipo de cuenta al registrarse: Candidato o Empresa
- El rol Admin se asigna manualmente desde la base de datos o mediante seeder
- Se utiliza Laravel Breeze para autenticación

## Middleware de autorización
- `role:candidato` — Rutas exclusivas para candidatos
- `role:empresa` — Rutas exclusivas para empresas
- `role:admin` — Rutas exclusivas para administradores
- Rutas públicas accesibles sin autenticación (landing, info)
