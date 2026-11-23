<?php

class AulaController
{
    private Aula $model;
    private Reserva $reservaModel;
    private Usuario $usuarioModel;

    public function __construct()
    {
        if (session_status() !== PHP_SESSION_ACTIVE) {
            session_start();
        }
        $this->model = new Aula();
        $this->reservaModel = new Reserva();
        $this->usuarioModel = new Usuario();
    }

    public function login(): void
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $usuario = trim($_POST['usuario'] ?? '');
            $password = $_POST['password'] ?? '';
            $registro = $this->usuarioModel->autenticar($usuario, $password);

            if ($registro) {
                $_SESSION['autenticado'] = true;
                $_SESSION['usuario'] = $registro['usuario'];
                $_SESSION['nombre'] = $registro['nombre'];
                $_SESSION['rol'] = $registro['rol'];
                $_SESSION['horario_inicio'] = $registro['horario_inicio'];
                $_SESSION['horario_fin'] = $registro['horario_fin'];
                $_SESSION['requisitos'] = $registro['requisitos'];
                $_SESSION['facultad'] = $registro['facultad'];
                header('Location: ?action=index');
                exit;
            }

            $error = 'Credenciales incorrectas. Por favor, intenta nuevamente.';
            require __DIR__ . '/../views/login.php';
            return;
        }

        require __DIR__ . '/../views/login.php';
    }

    public function logout(): void
    {
        session_destroy();
        header('Location: ?action=login');
        exit;
    }

    public function index(): void
    {
        if (empty($_SESSION['autenticado'])) {
            header('Location: ?action=login');
            exit;
        }

        $rol = $_SESSION['rol'] === 'admin' ? 'admin' : 'consulta';
        $facultad = $this->model->obtenerFacultad();
        $aulas = $this->model->obtenerAulas();
        $horas = $this->model->obtenerHoras();
        $insumosAuditorio = $this->model->obtenerInsumos();
        $horarioOperativo = $this->model->obtenerHorarioOperativo();
        $reservas = $this->reservaModel->obtenerReservas();
        $usuarios = $this->usuarioModel->obtenerUsuarios();
        $usuarioActual = [
            'usuario' => $_SESSION['usuario'] ?? '',
            'nombre' => $_SESSION['nombre'] ?? '',
            'rol' => $rol,
            'horario_inicio' => $_SESSION['horario_inicio'] ?? '07:00',
            'horario_fin' => $_SESSION['horario_fin'] ?? '21:00',
            'requisitos' => $_SESSION['requisitos'] ?? [],
            'facultad' => $_SESSION['facultad'] ?? $facultad,
        ];

        $contarPorEstado = function (array $items, string $estado): int {
            return count(array_filter($items, fn($item) => $item['estado'] === $estado));
        };

        $metricas = [
            'totalEspacios' => count($aulas),
            'disponibles' => $contarPorEstado($aulas, 'Disponible'),
            'ocupadas' => $contarPorEstado($aulas, 'Ocupada'),
            'enMantenimiento' => $contarPorEstado($aulas, 'Mantenimiento'),
            'totalReservas' => count($reservas),
            'confirmadas' => $contarPorEstado($reservas, 'Confirmada'),
            'pendientes' => $contarPorEstado($reservas, 'Pendiente'),
            'enCurso' => $contarPorEstado($reservas, 'En curso'),
        ];

        $vista = $rol === 'admin' ? 'admin.php' : 'consulta.php';
        require __DIR__ . '/../views/' . $vista;
    }
}
