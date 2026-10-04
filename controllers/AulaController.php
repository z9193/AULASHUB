<?php

class AulaController
{
    private Aula $model;
    private Reserva $reservaModel;

    public function __construct()
    {
        session_start();
        $this->model = new Aula();
        $this->reservaModel = new Reserva();
    }

    public function login(): void
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $usuario = $_POST['usuario'] ?? '';
            $password = $_POST['password'] ?? '';
            $rol = $_POST['rol'] ?? '';

            $credencialesValidas = [
                'admin' => 'admin123',
                'usuario' => 'usuario123',
            ];

            if (isset($credencialesValidas[$usuario]) && $credencialesValidas[$usuario] === $password) {
                $_SESSION['usuario'] = $usuario;
                $_SESSION['rol'] = $rol;
                $_SESSION['autenticado'] = true;
                header('Location: ?action=index');
                exit;
            } else {
                $error = 'Credenciales incorrectas. Por favor, intenta nuevamente.';
                require __DIR__ . '/../views/login.php';
            }
        } else {
            require __DIR__ . '/../views/login.php';
        }
    }

    public function logout(): void
    {
        session_destroy();
        header('Location: ?action=login');
        exit;
    }

    public function index(): void
    {
        if (!isset($_SESSION['autenticado']) || $_SESSION['autenticado'] !== true) {
            header('Location: ?action=login');
            exit;
        }

        $rol = $_SESSION['rol'] === 'admin' ? 'admin' : 'consulta';

        $aulas = $this->model->obtenerAulas();
        $horarios = $this->model->obtenerHorarios();
        $insumosAuditorio = $this->model->obtenerInsumos();
        $horarioOperativo = $this->model->obtenerHorarioOperativo();
        $reservas = $this->reservaModel->obtenerReservas();

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
