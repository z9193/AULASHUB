<script>
window.RESERVAS = <?= json_encode($reservas, JSON_UNESCAPED_UNICODE) ?>;
window.HORARIO_OPERATIVO = <?= json_encode($horarioOperativo) ?>;
window.USUARIO_ACTUAL = <?= json_encode($usuarioActual, JSON_UNESCAPED_UNICODE) ?>;
window.FACULTAD = <?= json_encode($facultad, JSON_UNESCAPED_UNICODE) ?>;
window.ESPACIOS = <?= json_encode($aulas, JSON_UNESCAPED_UNICODE) ?>;
</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.8.4/jspdf.plugin.autotable.min.js"></script>
<script src="public/js/app.js"></script>
