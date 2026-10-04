<div class="container-fluid">
    <h2 class="mb-4">Vincular Enlace con Dispositivo</h2>

    <div class="card shadow mb-4">
        <div class="card-body">
            <form action="<?php echo SERVERURL; ?>ajax/enControlador.php" method="POST">
                <div class="row">
                    <div class="col-md-5">
                        <label>Enlace</label>
                        <select class="form-control" name="en_id">
                            <option value="">Seleccione un enlace...</option>
                            <?php 
                            // Solo recorremos si la variable existe y no es nula
                            if(isset($centros) && is_array($centros)){
                                foreach($centros as $rows){
                                    echo '<option value="'.$rows['id'].'">'.$rows['nombre'].'</option>';
                                }
                            }
                            ?>
                        </select>
                    </div>
                    <div class="col-md-5">
                        <label>Dispositivo Disponible</label>
                        <select class="form-control" name="disp_id">
                            </select>
                    </div>
                    <div class="col-md-2">
                        <label>&nbsp;</label>
                        <button type="submit" class="btn btn-primary btn-block">Vincular</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>