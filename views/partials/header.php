<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>AulasHub — Prototipo Pro</title>
<script src="https://cdn.tailwindcss.com"></script>
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
<style>
    body { font-family: 'Poppins', sans-serif; }
    .uach-grad { background: linear-gradient(135deg, #6B21A8 0%, #166534 50%, #F59E0B 100%); }
    .glossy {
        background: linear-gradient(180deg, rgba(255,255,255,0.4) 0%, rgba(255,255,255,0.15) 50%, rgba(255,255,255,0) 100%);
        border: 2px solid rgba(255,255,255,0.5);
    }
    .metallic {
        background: linear-gradient(180deg, #a855f7 0%, #6B21A8 40%, #4c1d95 70%, #2e1065 100%);
        box-shadow: 0 0 30px rgba(107, 33, 168, 0.7), inset 0 2px 0 rgba(255,255,255,0.4), inset 0 -2px 0 rgba(0,0,0,0.3);
    }
    .chrome-text {
        background: linear-gradient(180deg, #fef3c7 0%, #fcd34d 25%, #f59e0b 50%, #d97706 75%, #b45309 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        text-shadow: 0 0 20px rgba(245, 158, 11, 0.8), 0 0 40px rgba(245, 158, 11, 0.4);
        filter: drop-shadow(0 2px 4px rgba(0,0,0,0.5));
    }
    .rounded-chrome {
        font-weight: 800;
        letter-spacing: 0.05em;
        text-transform: uppercase;
    }
    .glow-purple { box-shadow: 0 0 40px rgba(107, 33, 168, 0.8), 0 0 80px rgba(107, 33, 168, 0.4); }
    .glow-green { box-shadow: 0 0 30px rgba(22, 101, 52, 0.7); }
    .glow-yellow { box-shadow: 0 0 30px rgba(245, 158, 11, 0.7); }
    .text-glow { text-shadow: 0 0 15px rgba(245, 158, 11, 0.9), 0 0 30px rgba(245, 158, 11, 0.6), 0 0 45px rgba(245, 158, 11, 0.3); }
    .bg-dark-modern { background: linear-gradient(135deg, #0f0f23 0%, #1a1a2e 30%, #16213e 70%, #0f0f23 100%); }
    .y2k-border {
        border: 3px solid;
        border-image: linear-gradient(135deg, #6B21A8, #166534, #F59E0B) 1;
    }
    .modal-backdrop { background: rgba(15, 23, 42, 0.9); backdrop-filter: blur(12px); }
    .toast { transition: all 0.4s cubic-bezier(0.68, -0.55, 0.27, 1.55); }
    .logo-glow {
        box-shadow: 0 0 50px rgba(107, 33, 168, 0.8), 0 0 100px rgba(107, 33, 168, 0.4), inset 0 0 30px rgba(245, 158, 11, 0.3);
    }
</style>
</head>
<body class="bg-dark-modern text-white min-h-screen relative overflow-hidden">
<div class="absolute inset-0 opacity-10 pointer-events-none">
    <div class="absolute top-0 left-0 w-96 h-96 bg-purple-600 rounded-full blur-3xl"></div>
    <div class="absolute bottom-0 right-0 w-96 h-96 bg-green-600 rounded-full blur-3xl"></div>
    <div class="absolute top-1/2 left-1/2 w-96 h-96 bg-yellow-500 rounded-full blur-3xl"></div>
</div>

<header class="metallic text-white shadow-2xl sticky top-0 z-40 relative">
    <div class="max-w-6xl mx-auto px-6 py-5 flex flex-wrap items-center justify-between gap-4 relative">
        <div class="absolute inset-0 glossy rounded-2xl"></div>
        <div class="flex items-center gap-3 relative z-10">
            <div class="w-16 h-16 rounded-full bg-gradient-to-br from-purple-600 to-purple-900 flex items-center justify-center shadow-2xl logo-glow border-2 border-purple-400/50 overflow-hidden">
                <img src="public/images/logo.png" alt="AulasHub Logo" class="w-full h-full object-cover" onerror="this.style.display='none'; this.parentElement.innerHTML='🚀';">
            </div>
            <div>
                <h1 class="text-3xl font-black tracking-wide chrome-text rounded-chrome">AulasHub</h1>
                <p class="text-xs text-purple-200 font-medium tracking-wider">UNIVERSIDAD AUTÓNOMA DE CHIHUAHUA</p>
            </div>
        </div>

        <div class="flex items-center gap-3 bg-slate-900/50 backdrop-blur-md border-2 border-purple-500/50 p-2 rounded-2xl shadow-xl glow-purple relative z-10">
            <span class="text-xs font-semibold px-3 text-purple-200">
                Usuario:
                <b class="text-yellow-400 underline decoration-yellow-400 decoration-2">
                    <?= htmlspecialchars($_SESSION['usuario'] ?? 'Invitado') ?>
                </b>
                · Rol:
                <b class="text-green-400 underline decoration-green-400 decoration-2">
                    <?= $rol === 'admin' ? 'Administrador' : 'Usuario Consulta' ?>
                </b>
            </span>
            <a href="?action=logout"
                class="bg-gradient-to-r from-red-500 to-red-700 hover:from-red-600 hover:to-red-800 text-white font-bold text-xs px-4 py-2.5 rounded-xl shadow-lg hover:shadow-red-500/50 transition transform hover:-translate-y-0.5 border border-red-400">
                🚪 Cerrar Sesión
            </a>
        </div>
    </div>
</header>
