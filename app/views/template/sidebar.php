<aside class="main-sidebar sidebar-dark-primary elevation-4 bg-navy">
    <!-- Perfil mejorado -->
    <div class="brand-container text-center pt-3">
        <div class="profile-wrapper position-relative mb-1">
            <div class="avatar-hover-effect">
                <img src="dist/img/usuario.png" alt="DIRPOLES" 
                     class="img-fluid rounded-circle border-4 border-white shadow-lg"
                     style="width: 90px; height: 90px; object-fit: cover; transition: transform 0.3s ease;">
            </div>
        </div>
        
        <div class="user-info">
            <h4 class="text-white mb-1 fw-semibold text-shadow">
                <?php echo $_SESSION['nombre']. ' '. $_SESSION['apellido']; ?>
            </h4>
            <div class="badge badge-pill bg-warning text-white fw-normal fs-6 mb-2 shadow-sm" style="font-size: 1rem;">
                <?php echo $_SESSION['tipo_empleado']; ?>
            </div>
        </div>
    </div>

    <div class="sidebar">
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column nav-flat nav-compact nav-child" data-widget="treeview" role="menu" data-accordion="false">
        <li class="nav-header">Gestión del Sistema</li>
          <li class="nav-item <?php echo ($nivel1 == "inicio") ? "active menu-open" : ""; ?>">
            <a href="index.php?action=inicio" class="nav-link">
              <i class="nav-icon fas fa-home"></i>
              <p>
                Inicio
              </p>
            </a>
          </li>

          <?php if ($_SESSION['tipo_empleado'] == 'Administrador') { ?>

            <li class="nav-item <?php echo ($nivel1 == "empleados") ? "active menu-open" : ""; ?>">
              <a href="#" class="nav-link">
                <i class="nav-icon fas fa-copy"></i>
                <p>
                  Gestionar Empleados
                  <i class="fas fa-angle-left right"></i>
                </p>
              </a>
              <ul class="nav nav-treeview">
                <li class="nav-item">
                  <a href="index.php?action=empleados_crear" class="nav-link <?php echo ($nivel1 == "empleados" && $nivel2 == "crear") ? "active" : ""; ?>">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Crear</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="index.php?action=empleados_consulta" class="nav-link <?php echo ($nivel1 == "empleados" && $nivel2 == "consulta") ? "active" : ""; ?>">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Consultar</p>
                  </a>
                </li>
              </ul>
            </li>

          <?php } ?>

          <?php if ($_SESSION['tipo_empleado'] == 'Administrador' || $_SESSION['tipo_empleado'] == 'Psicologo' || $_SESSION['tipo_empleado'] == 'Medico' || $_SESSION['tipo_empleado'] == 'Trabajador Social' || $_SESSION['tipo_empleado'] == 'Orientador' || $_SESSION['tipo_empleado'] == 'Discapacidad') { ?>

            <li class="nav-item <?php echo ($nivel1 == "beneficiarios") ? "active menu-open" : ""; ?>">
              <a href="#" class="nav-link">
                <i class="nav-icon fas fa-user-tag"></i>
                <p>
                  Gestionar Beneficiarios
                  <i class="right fas fa-angle-left"></i>
                </p>
              </a>
              <ul class="nav nav-treeview">
                <li class="nav-item">
                  <a href="index.php?action=beneficiarios_crear" class="nav-link <?php echo ($nivel1 == "beneficiarios" && $nivel2 == "crear") ? "active" : ""; ?>">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Crear</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="index.php?action=beneficiarios_consulta" class="nav-link <?php echo ($nivel1 == "beneficiarios" && $nivel2 == "consulta") ? "active" : ""; ?>">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Consultar</p>
                  </a>
                </li>
              </ul>
            </li>

          <?php } ?>

          <?php if ($_SESSION['tipo_empleado'] == 'Administrador' || $_SESSION['tipo_empleado'] == 'Psicologo') { ?>

            <li class="nav-item <?php echo ($nivel1 == "citas") ? "active menu-open" : ""; ?>">
              <a href="#" class="nav-link">
                <i class="nav-icon fas fa-calendar-check"></i>
                <p>
                  Gestionar Citas
                  <i class="right fas fa-angle-left"></i>
                </p>
              </a>
              <ul class="nav nav-treeview">
                <li class="nav-item">
                  <a href="index.php?action=citas_crear" class="nav-link <?php echo ($nivel1 == "citas" && $nivel2 == "crear") ? "active" : ""; ?>">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Crear</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="index.php?action=citas_listar" class="nav-link <?php echo ($nivel1 == "citas" && $nivel2 == "consultar") ? "active" : ""; ?>">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Consultar</p>
                  </a>
                </li>
              </ul>
            </li>

          <?php } ?>

          <?php if ($_SESSION['tipo_empleado'] == 'Administrador' || $_SESSION['tipo_empleado'] == 'Psicologo' || $_SESSION['tipo_empleado'] == 'Medico' || $_SESSION['tipo_empleado'] === 'Trabajador Social' || $_SESSION['tipo_empleado'] == 'Orientador' || $_SESSION['tipo_empleado'] == 'Discapacidad') { ?>

            <li class="nav-item <?php echo ($nivel1 == "diagnostico") ? "active menu-open" : ""; ?>">
              <a href="#" class="nav-link">
                <i class="nav-icon fas fa-stethoscope"></i>
                <p>
                  Diagnosticos
                  <i class="fas fa-angle-left right"></i>
                </p>
              </a>

              <ul class="nav nav-treeview">

              <?php } ?>

              <?php if ($_SESSION['tipo_empleado'] == 'Psicologo' || $_SESSION['tipo_empleado'] == 'Administrador') { ?>

                <li class="nav-item">
                  <a href="index.php?action=diagnostico_psicologia" class="nav-link <?php echo ($nivel1 == "diagnostico" && $nivel2 == "psicologia") ? "active" : ""; ?>">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Psicología</p>
                  </a>
                </li>

              <?php } ?>

              <?php if ($_SESSION['tipo_empleado'] == 'Medico'  || $_SESSION['tipo_empleado'] == 'Administrador') { ?>

                <li class="nav-item">
                  <a href="index.php?action=diagnostico_medicina" class="nav-link <?php echo ($nivel1 == "diagnostico" && $nivel2 == "medicina") ? "active" : ""; ?>">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Medicina</p>
                  </a>
                </li>

              <?php } ?>

              <?php if ($_SESSION['tipo_empleado'] == 'Orientador'  || $_SESSION['tipo_empleado'] == 'Administrador') { ?>

                <li class="nav-item">
                  <a href="index.php?action=diagnostico_orientacion" class="nav-link <?php echo ($nivel1 == "diagnostico" && $nivel2 == "orientacion") ? "active" : ""; ?>">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Orientación</p>
                  </a>
                </li>

              <?php } ?>

              <?php if ($_SESSION['tipo_empleado'] == 'Trabajador Social'  || $_SESSION['tipo_empleado'] == 'Administrador') { ?>

                <li class="nav-item">
                  <a href="index.php?action=vista_trabajo_social" class="nav-link <?php echo ($nivel1 == "diagnostico" && $nivel2 == "trabajo_social") ? "active" : ""; ?>">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Trabajo Social</p>
                  </a>
                </li>

              <?php } ?>

              <?php if ($_SESSION['tipo_empleado'] == 'Discapacidad' || $_SESSION['tipo_empleado'] == 'Administrador') { ?>

                <li class="nav-item">
                  <a href="index.php?action=diagnostico_discapacidad" class="nav-link <?php echo ($nivel1 == "diagnostico" && $nivel2 == "discapacidad") ? "active" : ""; ?>">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Discapacidad</p>
                  </a>
                </li>

              <?php } ?>

              <?php if ($_SESSION['tipo_empleado'] == 'Administrador' || $_SESSION['tipo_empleado'] == 'Psicologo' || $_SESSION['tipo_empleado'] == 'Medico' || $_SESSION['tipo_empleado'] == 'Trabajador Social' || $_SESSION['tipo_empleado'] == 'Orientador' || $_SESSION['tipo_empleado'] == 'Discapacidad') { ?>

              </ul>
            </li>

          <?php } ?>

          <?php if ($_SESSION['tipo_empleado'] == 'Administrador' || $_SESSION['tipo_empleado'] == 'Medico') { ?>

            <li class="nav-item <?php echo ($nivel1 == "inventario") ? "active menu-open" : ""; ?>">
              <a href="#" class="nav-link">
                <i class="nav-icon fas fa-file-medical"></i>
                <p>
                  Inventario Médico
                  <i class="fas fa-angle-left right"></i>
                </p>
              </a>
              <ul class="nav nav-treeview">
                <li class="nav-item">
                  <a href="index.php?action=inventario_crear" class="nav-link <?php echo ($nivel1 == "inventario" && $nivel2 == "crear") ? "active" : ""; ?>">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Crear insumos</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="index.php?action=inventario_consulta" class="nav-link <?php echo ($nivel1 == "inventario" && $nivel2 == "consulta") ? "active" : ""; ?>">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Consultar</p>
                  </a>
                </li>
              </ul>
            </li>

          <?php } ?>

          <?php if ($_SESSION['tipo_empleado'] == 'Administrador' || $_SESSION['tipo_empleado'] == 'Psicologo' || $_SESSION['tipo_empleado'] == 'Medico' || $_SESSION['tipo_empleado'] == 'Trabajador Social' || $_SESSION['tipo_empleado'] == 'Orientador' || $_SESSION['tipo_empleado'] == 'Discapacidad' || $_SESSION['tipo_empleado'] == 'Secretaria') { ?>

            <li class="nav-item <?php echo ($nivel1 == "reportes") ? "active menu-open" : ""; ?>">
              <a href="#" class="nav-link">
                <i class="nav-icon far fa-file-alt"></i>
                <p>
                  Reportes
                  <i class="fas fa-angle-left right"></i>
                </p>
              </a>
              <ul class="nav nav-treeview">

              <?php } ?>

              <?php if ($_SESSION['tipo_empleado'] == 'Secretaria' || $_SESSION['tipo_empleado'] == 'Administrador') { ?>

                <li class="nav-item">
                  <a href="index.php?action=reportes_general" class="nav-link <?php echo ($nivel1 == "reportes" && $nivel2 == "general") ? "active" : ""; ?>">
                    <i class="far fa-circle nav-icon"></i>
                    <p>General</p>
                  </a>
                </li>

              <?php } ?>


              <?php if ($_SESSION['tipo_empleado'] == 'Psicologo' || $_SESSION['tipo_empleado'] == 'Secretaria' || $_SESSION['tipo_empleado'] == 'Administrador') { ?>

                <li class="nav-item">
                  <a href="index.php?action=reportes_psicologia" class="nav-link <?php echo ($nivel1 == "reportes" && $nivel2 == "psicologia") ? "active" : ""; ?>">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Psicología</p>
                  </a>
                </li>

              <?php } ?>

              <?php if ($_SESSION['tipo_empleado'] == 'Medico' || $_SESSION['tipo_empleado'] == 'Secretaria' || $_SESSION['tipo_empleado'] == 'Administrador') { ?>

                <li class="nav-item">
                  <a href="index.php?action=reportes_medicina" class="nav-link <?php echo ($nivel1 == "reportes" && $nivel2 == "medicina") ? "active" : ""; ?>">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Medicina</p>
                  </a>
                </li>

              <?php } ?>

              <?php if ($_SESSION['tipo_empleado'] == 'Orientacion' || $_SESSION['tipo_empleado'] == 'Secretaria' || $_SESSION['tipo_empleado'] == 'Administrador') { ?>

                <li class="nav-item">
                  <a href="index.php?action=reportes_orientacion" class="nav-link <?php echo ($nivel1 == "reportes" && $nivel2 == "orientacion") ? "active" : ""; ?>">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Orientación</p>
                  </a>
                </li>

              <?php } ?>

              <?php if ($_SESSION['tipo_empleado'] == 'Trabajador Social' || $_SESSION['tipo_empleado'] == 'Secretaria' || $_SESSION['tipo_empleado'] == 'Administrador') { ?>

                <li class="nav-item">
                  <a href="index.php?action=reportes_trabajo_social" class="nav-link <?php echo ($nivel1 == "reportes" && $nivel2 == "trabajo_social") ? "active" : ""; ?>">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Trabajo Social</p>
                  </a>
                </li>

              <?php } ?>

              <?php if ($_SESSION['tipo_empleado'] == 'Discapacidad' || $_SESSION['tipo_empleado'] == 'Secretaria' || $_SESSION['tipo_empleado'] == 'Administrador') { ?>

                <li class="nav-item">
                  <a href="index.php?action=reportes_discapacidad" class="nav-link <?php echo ($nivel1 == "reportes" && $nivel2 == "discapacidad") ? "active" : ""; ?>">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Discapacidad</p>
                  </a>
                </li>

              <?php } ?>

              <?php if ($_SESSION['tipo_empleado'] == 'Administrador' || $_SESSION['tipo_empleado'] == 'Psicologo' || $_SESSION['tipo_empleado'] == 'Medico' || $_SESSION['tipo_empleado'] == 'Trabajador Social' || $_SESSION['tipo_empleado'] == 'Orientador' || $_SESSION['tipo_empleado'] == 'Discapacidad' || $_SESSION['tipo_empleado'] == 'Secretaria') { ?>

              </ul>
            </li>

          <?php } ?>

          <?php if ($_SESSION['tipo_empleado'] == 'Administrador') { ?>

            <li class="nav-item <?php echo ($nivel1 == "configuracion") ? "active menu-open" : ""; ?>">
              <a href="#" class="nav-link">
                <i class="nav-icon fas fa-cog"></i>
                <p>
                  Gestionar Configuración
                  <i class="right fas fa-angle-left"></i>
                </p>
              </a>
              <ul class="nav nav-treeview">
                <li class="nav-item">
                  <a href="index.php?action=config_crear" class="nav-link <?php echo ($nivel1 == "configuracion" && $nivel2 == "crear") ? "active" : ""; ?>">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Crear</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="index.php?action=config_listar" class="nav-link <?php echo ($nivel1 == "configuracion" && $nivel2 == "consultar") ? "active" : ""; ?>">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Consultar</p>
                  </a>
                </li>
              </ul>
            </li>

          <?php } ?>
          
            <li class="nav-header">Nuevos Módulos de Trayecto 3</li>

            <?php if ($_SESSION['tipo_empleado'] == 'Administrador') { ?>
            <li class="nav-item <?php echo ($nivel1 == "bitacora") ? "active menu-open" : ""; ?>">
              <a href="#" class="nav-link">
                <i class="nav-icon fas fa-file-alt"></i>
                <p>
                  Bitácora
                  <i class="right fas fa-angle-left"></i>
                </p>
              </a>
              <ul class="nav nav-treeview">
                <li class="nav-item">
                  <a href="index.php?action=bitacora_listar" class="nav-link <?php echo ($nivel1 == "bitacora" && $nivel2 == "consultar") ? "active" : ""; ?>">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Consultar</p>
                  </a>
                </li>
              </ul>
            </li>

          <?php } ?>

            <li class="nav-item <?php echo ($nivel1 == "bitacora") ? "active menu-open" : ""; ?>">
              <a href="#" class="nav-link">
                <i class="nav-icon fas fa-exclamation-triangle"></i>
                <p>
                  Gestionar referencias
                  <i class="right fas fa-angle-left"></i>
                </p>
              </a>
              <ul class="nav nav-treeview">
                <li class="nav-item">
                  <a href="index.php?action=referencias_crear" class="nav-link <?php echo ($nivel1 == "referencias" && $nivel2 == "crear") ? "active" : ""; ?>">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Crear</p>
                  </a>

                  <a href="#" class="nav-link <?php echo ($nivel1 == "bitacora" && $nivel2 == "consultar") ? "active" : ""; ?>">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Consultar</p>
                  </a>
                </li>
              </ul>
            </li>


            <li class="nav-item <?php echo ($nivel1 == "bitacora") ? "active menu-open" : ""; ?>">
              <a href="#" class="nav-link">
                <i class="nav-icon fas fa-exclamation-triangle"></i>
                <p>
                  Gestionar rutas
                  <i class="right fas fa-angle-left"></i>
                </p>
              </a>
              <ul class="nav nav-treeview">
                <li class="nav-item">
                  <a href="#" class="nav-link <?php echo ($nivel1 == "bitacora" && $nivel2 == "consultar") ? "active" : ""; ?>">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Crear</p>
                  </a>

                  <a href="#" class="nav-link <?php echo ($nivel1 == "bitacora" && $nivel2 == "consultar") ? "active" : ""; ?>">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Consultar</p>
                  </a>
                </li>
              </ul>
            </li>


            <li class="nav-item <?php echo ($nivel1 == "bitacora") ? "active menu-open" : ""; ?>">
              <a href="#" class="nav-link">
                <i class="nav-icon fas fa-exclamation-triangle"></i>
                <p>
                  Gestionar Jornadas
                  <i class="right fas fa-angle-left"></i>
                </p>
              </a>
              <ul class="nav nav-treeview">
                <li class="nav-item">
                  <a href="#" class="nav-link <?php echo ($nivel1 == "bitacora" && $nivel2 == "consultar") ? "active" : ""; ?>">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Crear</p>
                  </a>

                  <a href="#" class="nav-link <?php echo ($nivel1 == "bitacora" && $nivel2 == "consultar") ? "active" : ""; ?>">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Consultar</p>
                  </a>
                </li>
              </ul>
            </li>


            <li class="nav-item <?php echo ($nivel1 == "bitacora") ? "active menu-open" : ""; ?>">
              <a href="#" class="nav-link">
                <i class="nav-icon fas fa-exclamation-triangle"></i>
                <p>
                  Gestionar Embarazadas
                  <i class="right fas fa-angle-left"></i>
                </p>
              </a>
              <ul class="nav nav-treeview">
                <li class="nav-item">
                  <a href="#" class="nav-link <?php echo ($nivel1 == "bitacora" && $nivel2 == "consultar") ? "active" : ""; ?>">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Crear</p>
                  </a>

                  <a href="#" class="nav-link <?php echo ($nivel1 == "bitacora" && $nivel2 == "consultar") ? "active" : ""; ?>">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Consultar</p>
                  </a>
                </li>
              </ul>
            </li>

            <li class="nav-item <?php echo ($nivel1 == "bitacora") ? "active menu-open" : ""; ?>">
              <a href="#" class="nav-link">
                <i class="nav-icon fas fa-exclamation-triangle"></i>
                <p>
                  Gestionar Mobiliario
                  <i class="right fas fa-angle-left"></i>
                </p>
              </a>
              <ul class="nav nav-treeview">
                <li class="nav-item">
                  <a href="index.php?action=inventario_mobiliario_index" class="nav-link <?php echo ($nivel1 == "Mobiliario" && $nivel2 == "crear") ? "active" : ""; ?>">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Crear</p>
                  </a>

                  <a href="#" class="nav-link <?php echo ($nivel1 == "bitacora" && $nivel2 == "consultar") ? "active" : ""; ?>">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Consultar</p>
                  </a>
                </li>
              </ul>
            </li>


          <li class="nav-item">
            <a href="Manual/MANUAL.pdf" target="_blank" class="nav-link">
              <i class="nav-icon far fa-question-circle"></i>
              <p>
                Ayuda
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="index.php?action=logout" class="nav-link">
              <i class="nav-icon fas fa-door-open"></i>
              <p>
                Cerrar Sesión
              </p>
            </a>
          </li>
        </ul>
      </nav>
    </div>
  </aside>

  <style>
    .avatar-hover-effect:hover img {
        transform: scale(1.05);
        box-shadow: 0 0 15px rgba(255,255,255,0.3);
    }
    </style>