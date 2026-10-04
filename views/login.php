<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AulasHub — Iniciar Sesión</title>
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
        .logo-glow {
            box-shadow: 0 0 50px rgba(107, 33, 168, 0.8), 0 0 100px rgba(107, 33, 168, 0.4), inset 0 0 30px rgba(245, 158, 11, 0.3);
        }
    </style>
</head>
<body class="bg-dark-modern text-white min-h-screen flex items-center justify-center p-4 relative overflow-hidden">
    <div class="absolute inset-0 opacity-20">
        <div class="absolute top-20 left-20 w-96 h-96 bg-purple-600 rounded-full blur-3xl"></div>
        <div class="absolute bottom-20 right-20 w-96 h-96 bg-green-600 rounded-full blur-3xl"></div>
        <div class="absolute top-1/2 left-1/2 w-96 h-96 bg-yellow-500 rounded-full blur-3xl"></div>
    </div>

    <div class="w-full max-w-md relative z-10">
        <div class="bg-slate-900/80 backdrop-blur-xl rounded-3xl y2k-border glow-purple p-8">
            <div class="text-center mb-8">
                <div class="w-24 h-24 rounded-full bg-gradient-to-br from-purple-600 to-purple-900 flex items-center justify-center shadow-2xl logo-glow border-2 border-purple-400/50 overflow-hidden mx-auto mb-4">
                    <img src="public/images/logo.png" alt="AulasHub Logo" class="w-full h-full object-cover" onerror="this.style.display='none'; this.parentElement.innerHTML='🚀';">
                </div>
                <h1 class="text-4xl font-black tracking-wide chrome-text rounded-chrome">AulasHub</h1>
                <p class="text-xs text-purple-300 mt-2 tracking-wider">UNIVERSIDAD AUTÓNOMA DE CHIHUAHUA</p>
            </div>

            <?php if (isset($error)): ?>
                <div class="mb-6 p-4 rounded-2xl bg-red-900/50 border-2 border-red-500 text-red-200 text-xs font-bold flex items-center gap-3 shadow-sm glow-yellow">
                    <span class="text-lg">⚠️</span>
                    <span><?= htmlspecialchars($error) ?></span>
                </div>
            <?php endif; ?>

            <form method="POST" action="?action=login" class="space-y-5">
                <div>
                    <label class="block text-xs font-bold text-purple-300 uppercase mb-1">Usuario</label>
                    <input type="text" name="usuario" required placeholder="Ingresa tu usuario"
                        class="w-full bg-slate-800/80 border-2 border-purple-500/50 rounded-2xl px-4 py-3 text-sm text-white font-medium outline-none focus:ring-2 focus:ring-purple-400 focus:border-purple-400 transition">
                </div>

                <div>
                    <label class="block text-xs font-bold text-purple-300 uppercase mb-1">Contraseña</label>
                    <input type="password" name="password" required placeholder="Ingresa tu contraseña"
                        class="w-full bg-slate-800/80 border-2 border-purple-500/50 rounded-2xl px-4 py-3 text-sm text-white font-medium outline-none focus:ring-2 focus:ring-purple-400 focus:border-purple-400 transition">
                </div>

                <div>
                    <label class="block text-xs font-bold text-purple-300 uppercase mb-1">Rol</label>
                    <select name="rol" required class="w-full bg-slate-800/80 border-2 border-purple-500/50 rounded-2xl px-4 py-3 text-sm text-white font-medium outline-none focus:ring-2 focus:ring-purple-400 focus:border-purple-400 transition">
                        <option value="">Selecciona tu rol</option>
                        <option value="admin">Administrador</option>
                        <option value="consulta">Usuario Consulta</option>
                    </select>
                </div>

                <button type="submit"
                    class="w-full uach-grad hover:opacity-95 text-white font-bold text-sm py-4 rounded-2xl shadow-lg shadow-purple-500/50 transition transform hover:-translate-y-0.5 glow-purple">
                    ⚡ Iniciar Sesión
                </button>
            </form>

            <div class="mt-6 pt-6 border-t border-purple-500/30">
                <p class="text-xs text-purple-300 text-center">
                    <span class="font-semibold text-yellow-400">Credenciales de prueba:</span><br>
                    Usuario: <span class="text-green-400 font-bold">admin</span> / Contraseña: <span class="text-green-400 font-bold">admin123</span><br>
                    Usuario: <span class="text-green-400 font-bold">usuario</span> / Contraseña: <span class="text-green-400 font-bold">usuario123</span>
                </p>
            </div>
        </div>
    </div>

</body>
</html>
