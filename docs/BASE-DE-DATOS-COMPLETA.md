# Taller Pro — Base de Datos Completa

## Estructura del Sistema (Dos Vistas)

```
Taller Pro
│
├── Panel Administrativo  →  /panel/*
│   ├── Dashboard
│   ├── Clientes
│   ├── Vehículos
│   ├── Órdenes
│   ├── Inventario
│   ├── Reportes
│   └── Configuración
│
└── Portal del Cliente  →  /portal/*
    ├── Inicio
    ├── Solicitar cita (servicio o diagnóstico)
    ├── Mis vehículos
    ├── Mis órdenes
    └── Mi perfil
```

---

## 1. Tablas que YA existen de Laravel (NO recrear)

| # | Tabla | Propósito |
|---|---|---|
| 1 | `users` | Usuarios del sistema |
| 2 | `password_reset_tokens` | Recuperación de contraseña |
| 3 | `sessions` | Sesiones activas |
| 4 | `cache` / `cache_locks` | Caché |
| 5 | `jobs` / `job_batches` / `failed_jobs` | Colas |

---

## 2. Módulo: Autenticación y Seguridad (5 tablas)

roles, permisos, rol_permiso, sucursales, auditorias
*(definidas en migraciones Fase 1)*

---

## 3. Módulo: Catálogos (7 tablas)

marcas_vehiculo, modelos_vehiculo, especialidades, tipos_servicio, servicios, proveedores, metodos_pago, **tipos_vehiculo**

### tipos_vehiculo (NUEVA)
| Columna | Tipo | Restricciones |
|---|---|---|
| id | bigint PK | auto_increment |
| nombre | varchar(30) | UNIQUE, NOT NULL |

**Seed:** Automovil, Motocicleta, Camioneta, Otro

**Cardinalidad:** tipos_vehiculo 1:N citas

> El servicio "Diagnostico General" (duracion_estimada_min = 60) pertenece al catalogo de servicios.
> Se usa cuando el cliente no sabe que falla tiene su vehiculo.

---

## 4. Módulo: Clientes y Vehículos (4 tablas)

clientes, marcas_vehiculo, modelos_vehiculo, vehiculos
*(definidas en migraciones Fase 3)*

---

## 5. Módulo: Mecánicos (2 tablas)

especialidades, mecanicos
*(definidas en migraciones Fase 3)*

---

## 6. Módulo: Inventario (4 tablas)

proveedores, repuestos, inventario, movimientos_inventario
*(definidas en migraciones Fase 3-4)*

---

## 7. Módulo: Órdenes de Trabajo (3 tablas)

ordenes_trabajo, detalle_orden_servicios, detalle_orden_repuestos
*(definidas en migraciones Fase 4)*

---

## 8. Módulo: Pagos y Facturación (3 tablas)

metodos_pago, pagos, facturas
*(definidas en migraciones Fase 4)*

---

## 9. Módulo: Portal del Cliente — Citas (3 tablas)

### citas (modificada)

| Columna | Tipo | Restricciones |
|---|---|---|
| id | bigint PK | auto_increment |
| cliente_id | bigint FK → clientes.id | ON DELETE CASCADE |
| **tipo_solicitud** | **varchar(20)** | **'servicio' o 'diagnostico'** |
| **tipo_vehiculo_id** | **bigint FK → tipos_vehiculo.id** | **ON DELETE RESTRICT** |
| **descripcion_problema** | **text NULL** | **solo para diagnostico** |
| servicio_id | bigint FK → servicios.id | NOT NULL (Diagnostico General para diagnosticos) |
| vehiculo_id | bigint FK → vehiculos.id | **NULL** (se asigna despues en el taller) |
| mecanico_id | bigint FK → mecanicos.id | NULL, ON DELETE SET NULL (asignado por admin) |
| sucursal_id | bigint FK → sucursales.id | ON DELETE RESTRICT |
| orden_trabajo_id | bigint FK → ordenes_trabajo.id | NULL, ON DELETE SET NULL |
| duracion_minutos | smallint unsigned | copiado del servicio al reservar |
| fecha_hora | datetime | |
| estado | varchar(20) | DEFAULT 'pendiente' |
| timestamps | | |

**Flujo de estados:** pendiente → confirmada → asignada → atendida / cancelada

### horarios_mecanico (sin cambios)
mecanico_id FK, dia_semana, hora_inicio, hora_fin, activo. UNIQUE(mecanico_id, dia_semana)

*(se mantiene para calculo interno de disponibilidad en el panel administrativo)*

### ~~resenas~~ (ELIMINADA)
*Ya no existe. El cliente no elige mecanico, por lo tanto no hay reseñas.*

---

## 10. Módulo: Extras (3 tablas)

notificaciones, garantias, reportes
*(definidas en migraciones Fase 6)*

---

## 11. Cardinalidades

### 1:N
roles → users | sucursales → users, mecanicos, inventario, citas, ordenes_trabajo | clientes → vehiculos, ordenes_trabajo, citas | vehiculos → ordenes_trabajo | marcas_vehiculo → modelos_vehiculo | modelos_vehiculo → vehiculos | mecanicos → ordenes_trabajo, horarios_mecanico | especialidades → mecanicos | servicios → detalle_orden_servicios, citas | **tipos_vehiculo → citas** | proveedores → repuestos | repuestos → inventario, detalle_orden_repuestos | ordenes_trabajo → detalle_*, pagos, facturas, garantias

### N:M
roles ↔ permisos (via rol_permiso)

### 1:1
users ↔ clientes (si aplica) | users ↔ mecanicos (si aplica) | ordenes_trabajo → factura

---

## 12. Reglas de Negocio (6)

| # | Regla |
|---|---|
| RN1a | Un cliente puede reservar una cita sin tener un vehiculo registrado. El tipo de vehiculo se captura como catalogo (Automovil, Motocicleta, etc.). El vehiculo real se registra cuando el cliente llega al taller. |
| RN1b | Una orden de trabajo requiere un vehiculo registrado. Antes de crear la orden, el admin debe registrar o seleccionar el vehiculo del cliente. |
| RN2 | La orden sigue flujo irreversible: pendiente → en_proceso → completado. Solo pendiente → cancelado |
| RN3 | Un mecanico no puede tener mas de una orden en en_proceso al mismo tiempo |
| RN4 | Al asignar repuestos se verifica stock_actual >= cantidad. Si no alcanza se rechaza |
| RN5 | Una factura solo se emite si la orden esta en completado |
| RN6 | Todo usuario debe tener password O provider, nunca ninguno de los dos |

---

## 13. Resumen

| Concepto | Cantidad |
|---|---|
| Tablas de negocio | **27** |
| Tablas Laravel existentes | 9 |
| Reglas de negocio | 6 ✅ (minimo 5) |
