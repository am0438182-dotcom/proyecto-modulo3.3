# TODO - Actualización de roles y permisos

- [ ] 1) Implementar control de acceso por rol en `auth.php` (Gerente/Vendedor/Contador/Auditor) y compatibilidad con `admin/usuario`.
- [ ] 2) Actualizar `empleados/listar.php` para mostrar/editar roles con los nuevos nombres y permitir gestión solo a Gerente.
- [ ] 3) Actualizar `dashboard.php` para mostrar menú/botones según rol (y que Gerente sea el único que vea administración de usuarios).
- [ ] 4) Restringir pantallas de **Clientes**:
  - [ ] listar: permitido para Gerente/Vendedor/Contador/Auditor (SELECT)
  - [ ] agregar/editar/eliminar: permitido solo para Gerente
- [ ] 5) Restringir pantallas de **Productos**:
  - [ ] listar: permitido para Gerente y Contador; bloquear otros (según requerimiento)
  - [ ] agregar/editar/eliminar: permitido solo para Gerente
- [ ] 6) Restringir pantallas de **Ventas**:
  - [ ] nueva_venta/registrar_venta: permitido para Gerente y Vendedor (INSERT)
  - [ ] listar: permitido solo para Gerente/Contador/Auditor (SELECT)
- [ ] 7) Restringir **Empleados** (empleados/listar.php y cualquier otra pantalla de empleados): solo Gerente.
- [ ] 8) Restringir **Reportes** (`reportes/reportes.php`): permitido para Gerente/Contador/Auditor; bloquear Vendedor.
- [ ] 9) (Si aplica) Ajustar endpoints `api/*.php` para que POST/GET estén restringidos por rol.
- [ ] 10) Probar con cuentas existentes: compatibilidad `admin`→Gerente y `usuario`→(definir según tu regla; por ahora mapear `usuario` como Contador o Auditado según corresponda a tu BD, o mantener solo acceso mínimo).

