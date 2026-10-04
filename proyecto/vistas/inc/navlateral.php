<div class="d-flex flex-column flex-shrink-0 p-3 text-bg-dark" style="width:280px; height:100vh; position: fixed;">
    <a href="<?php echo SERVERURL; ?>home/" class="text-secondary text-decoration-none text-uppercase">INICIO</a>
    <hr>
    
    <ul class="list-unstyled">
        <li class="mb-1">
            <a href="#" class="text-white-50 d-block py-2 dropdown-toggle text-decoration-none" data-bs-toggle="collapse" data-bs-target="#dep-collapse">
                Departamentos
            </a>
            <div class="collapse" id="dep-collapse">
                <ul class="list-unstyled fw-normal pb-1 small ps-3">
                    <li><a href="<?php echo SERVERURL; ?>departamentos/" class="text-white-50 d-block py-1 text-decoration-none">Nuevo</a></li>
                    <li><a href="<?php echo SERVERURL; ?>departamentos-lista/" class="text-white-50 d-block py-1 text-decoration-none">Lista</a></li>
                </ul>
            </div>
        </li>

        <li class="mb-1">
            <a href="#" class="text-white-50 d-block py-2 dropdown-toggle text-decoration-none" data-bs-toggle="collapse" data-bs-target="#enl-collapse">
                Enlaces
            </a>
            <div class="collapse" id="enl-collapse">
                <ul class="list-unstyled fw-normal pb-1 small ps-3">
                    <li><a href="<?php echo SERVERURL; ?>enlaces/" class="text-white-50 d-block py-1 text-decoration-none">Nuevo</a></li>
                    <li><a href="<?php echo SERVERURL; ?>enlace-lista/" class="text-white-50 d-block py-1 text-decoration-none">Lista</a></li>
                </ul>
            </div>
        </li>

        <li class="mb-1">
            <a href="#" class="text-white-50 d-block py-2 dropdown-toggle text-decoration-none" data-bs-toggle="collapse" data-bs-target="#disp-collapse">
                Dispositivos
            </a>
            <div class="collapse" id="disp-collapse">
                <ul class="list-unstyled fw-normal pb-1 small ps-3">
                    <li><a href="<?php echo SERVERURL; ?>dispositivos/" class="text-white-50 d-block py-1 text-decoration-none">Nuevo</a></li>
                    <li><a href="<?php echo SERVERURL; ?>dispositivo-lista/" class="text-white-50 d-block py-1 text-decoration-none">Lista</a></li>
                </ul>
            </div>
        </li>

        <li><a href="<?php echo SERVERURL; ?>dep-enlaces/" class="text-white-50 d-block py-2 text-decoration-none">Departamento-Enlace</a></li>
        <li><a href="<?php echo SERVERURL; ?>enlace-disp/" class="text-white-50 d-block py-2 text-decoration-none">Enlace-Dispositivo</a></li>
        <li><a href="<?php echo SERVERURL; ?>nodo/" class="text-white-50 d-block py-2 text-decoration-none">Nodos Orion</a></li>
    </ul>

    <div class="mt-auto p-3 border-top border-secondary">
        <div class="dropdown">
            <a href="#" class="d-flex align-items-center text-white text-decoration-none dropdown-toggle" id="dropdownUser1" data-bs-toggle="dropdown" aria-expanded="false">
                <strong><?php echo $_SESSION['nombre'] ?? 'Usuario'; ?></strong>
            </a>
            <ul class="dropdown-menu dropdown-menu-dark text-small shadow">
                <li><a class="dropdown-item" href="<?php echo SERVERURL; ?>logout/">Cerrar sesión</a></li>
            </ul>
        </div>
    </div>
</div>