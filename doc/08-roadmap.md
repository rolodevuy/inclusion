# Roadmap

## Fase 1 — MVP (actual)

### Sprint 1: Fundación
- [x] Documentación del proyecto
- [x] Crear proyecto Laravel
- [x] Instalar y configurar Tailwind CSS
- [x] Instalar Laravel Breeze
- [x] Configurar base de datos MySQL
- [x] Crear migraciones
- [x] Crear seeders
- [x] Crear modelos y relaciones
- [x] Crear middleware de roles

### Sprint 2: Autenticación y perfiles
- [x] Personalizar registro (selección de rol: candidato/empresa)
- [x] Perfil de candidato (CRUD)
- [x] Experiencias laborales (CRUD)
- [x] Selección de habilidades
- [x] Control de privacidad de discapacidad
- [x] Perfil de empresa (CRUD)

### Sprint 3: Buscador y administración
- [x] Buscador de candidatos para empresas
- [x] Filtros de búsqueda
- [x] Vista de perfil de candidato (respetando privacidad)
- [x] Sistema de solicitudes de acceso (bajo demanda)
- [x] Panel de administración
- [x] Gestión de usuarios
- [x] Gestión de catálogos (categorías laborales y habilidades)
- [x] Estadísticas básicas

### Sprint 4: Landing y pulido
- [x] Landing page pública
- [x] Traducción completa al español
- [x] Focus-visible global (CSS accesibilidad)
- [x] Colores consistentes (blue-700, contraste AA)
- [x] Componentes Breeze actualizados (indigo → blue)
- [ ] Pruebas con lector de pantalla
- [ ] Pruebas de navegación por teclado completa
- [ ] Ajustes finales

---

## Fase 2 — Post-MVP

### Sprint 5: Ofertas y postulaciones
- [x] Migración y modelo de ofertas de empleo
- [x] Migración y modelo de postulaciones
- [x] CRUD de ofertas para empresas
- [x] Explorador de ofertas para candidatos (con filtros)
- [x] Sistema de postulaciones (postularse, ver estado)
- [x] Gestión de postulantes para empresas (aceptar/rechazar/marcar vista)
- [x] Navegación actualizada para ambos roles

### Sprint 6: Mensajería
- [x] Sistema de mensajería empresa-candidato
- [x] Bandeja de entrada con indicador de no leídos
- [x] Vista de conversación estilo chat
- [x] Lectura automática al abrir conversación

### Sprint 7: Notificaciones por email
- [x] Mailer configurado (log para dev, listo para SMTP en producción)
- [x] Notificación al candidato: postulación aceptada/rechazada
- [x] Notificación a empresa: nuevo postulante
- [x] Notificación: nuevo mensaje recibido
- [x] Notificación al candidato: solicitud de acceso recibida

### Sprint 8: Verificación de certificados
- [x] Subida de certificado en formulario candidato
- [x] Panel admin de verificación (descargar, verificar, rechazar con motivo)
- [x] Badge de pendientes en navegación admin
- [x] Estado de verificación visible en perfil del candidato

### Pendientes Fase 2
- [ ] Reportes de inclusión laboral para empresas
- [ ] API REST para integraciones

## Fase 3 — Escalamiento (futuro)

- Inteligencia artificial para sugerencias de candidatos
- Matching automático empresa-candidato
- App móvil
- Expansión a otros países
- Integración con portales de empleo existentes
