<div class="container-fluid py-4">
    <div class="row mb-4">
        <div class="col-12">
            <h3 class="text-uppercase fw-light"><i class="fas fa-laptop-house me-2"></i> SISTEMA DE GESTIÓN</h3>
            <p class="text-muted">Bienvenido al panel de control de tu proyecto. Gestiona departamentos y dispositivos desde aquí.</p>
            <hr>
        </div>
    </div>

    <div class="row g-4 justify-content-center">
        
        <div class="col-6 col-sm-4 col-md-3 col-lg-2">
            <a href="<?php echo SERVERURL; ?>departamentos/" class="card h-100 text-center text-decoration-none shadow-sm border-0 transition-hover">
                <div class="card-header bg-primary text-white fw-bold small">DEPARTAMENTOS</div>
                <div class="card-body d-flex flex-column align-items-center justify-content-center">
                    <i class="fas fa-building fa-3x mb-2 text-secondary"></i>
                    <span class="text-dark small">12 Registrados</span>
                </div>
            </a>
        </div>

        <div class="col-6 col-sm-4 col-md-3 col-lg-2">
            <a href="<?php echo SERVERURL; ?>enlaces/" class="card h-100 text-center text-decoration-none shadow-sm border-0 transition-hover">
                <div class="card-header bg-warning text-dark fw-bold small">ENLACES</div>
                <div class="card-body d-flex flex-column align-items-center justify-content-center">
                    <i class="fas fa-network-wired fa-3x mb-2 text-secondary"></i>
                    <span class="text-dark small">8 Activos</span>
                </div>
            </a>
        </div>

        <div class="col-6 col-sm-4 col-md-3 col-lg-2">
            <a href="<?php echo SERVERURL; ?>dispositivos/" class="card h-100 text-center text-decoration-none shadow-sm border-0 transition-hover">
                <div class="card-header bg-info text-white fw-bold small">DISPOSITIVOS</div>
                <div class="card-body d-flex flex-column align-items-center justify-content-center">
                    <i class="fas fa-laptop fa-3x mb-2 text-secondary"></i>
                    <span class="text-dark small">45 Registrados</span>
                </div>
            </a>
        </div>

        <div class="col-6 col-sm-4 col-md-3 col-lg-2">
            <a href="<?php echo SERVERURL; ?>dep-enlaces/" class="card h-100 text-center text-decoration-none shadow-sm border-0 transition-hover">
                <div class="card-header bg-success text-white fw-bold small">DEP-ENLACES</div>
                <div class="card-body d-flex flex-column align-items-center justify-content-center">
                    <i class="fas fa-link fa-3x mb-2 text-secondary"></i>
                    <span class="text-dark small">Ver Relación</span>
                </div>
            </a>
        </div>

        <div class="col-6 col-sm-4 col-md-3 col-lg-2">
            <a href="<?php echo SERVERURL; ?>enlace-disp/" class="card h-100 text-center text-decoration-none shadow-sm border-0 transition-hover">
                <div class="card-header bg-info text-white fw-bold small">ENLACES-DISP</div>
                <div class="card-body d-flex flex-column align-items-center justify-content-center">
                    <i class="fas fa-link fa-3x mb-2 text-secondary"></i>
                    <span class="text-dark small">Ver Relación</span>
                </div>
            </a>
        </div>

    </div>
</div>