<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AulasHub — Facultad de Contaduría y Administración</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="public/css/fca.css">
</head>
<body class="bg-[#F7F4F5] text-[#1A1A1A] min-h-screen flex items-center justify-center p-4">
    <div class="w-full max-w-md">
        <div class="bg-white rounded-3xl border-2 border-[#7A1A2E] shadow-xl p-8">
            <div class="text-center mb-8">
                <div class="logo-card rounded-2xl px-6 py-5 mx-auto w-fit mb-4">
                    <img src="public/images/logo-fca.png" alt="Logo Facultad de Contaduría y Administración" class="h-36 w-auto object-contain mx-auto">
                </div>
                <h1 class="text-3xl font-black tracking-wide text-[#7A1A2E]">AulasHub</h1>
            </div>

            <?php if (isset($error)): ?>
                <div class="mb-6 p-4 rounded-2xl bg-red-50 border-2 border-red-400 text-red-800 text-xs font-bold">
                    <?= htmlspecialchars($error) ?>
                </div>
            <?php endif; ?>

            <form method="POST" action="?action=login" class="space-y-5">
                <div>
                    <label class="block text-xs font-bold text-[#7A1A2E] uppercase mb-1">Usuario</label>
                    <input type="text" name="usuario" required placeholder="Ingresa tu usuario"
                        class="w-full bg-[#F7F4F5] border-2 border-[#7A1A2E]/30 rounded-2xl px-4 py-3 text-sm text-[#1A1A1A] font-medium outline-none focus:ring-2 focus:ring-[#7A1A2E]">
                </div>
                <div>
                    <label class="block text-xs font-bold text-[#7A1A2E] uppercase mb-1">Contraseña</label>
                    <input type="password" name="password" required placeholder="Ingresa tu contraseña"
                        class="w-full bg-[#F7F4F5] border-2 border-[#7A1A2E]/30 rounded-2xl px-4 py-3 text-sm text-[#1A1A1A] font-medium outline-none focus:ring-2 focus:ring-[#7A1A2E]">
                </div>
                <button type="submit"
                    class="w-full bg-[#7A1A2E] hover:bg-[#5C1423] text-white font-bold text-sm py-4 rounded-2xl transition">
                    Iniciar sesión
                </button>
            </form>
        </div>
    </div>
</body>
</html>
