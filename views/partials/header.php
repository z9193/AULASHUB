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
<body class="bg-[#F7F4F5] text-[#1A1A1A] min-h-screen">

<header class="bg-white border-b-4 border-[#7A1A2E] sticky top-0 z-40 shadow-sm">
    <div class="max-w-7xl mx-auto px-6 py-3 flex flex-wrap items-center justify-between gap-4">
        <div class="flex items-center gap-4">
            <div class="logo-card rounded-2xl px-3 py-2">
                <img src="public/images/logo-fca.png" alt="Facultad de Contaduría y Administración" class="h-16 w-auto object-contain">
            </div>
            <div>
                <h1 class="text-2xl font-black tracking-wide text-[#7A1A2E]">AulasHub</h1>
                <p class="text-[11px] text-[#1A1A1A] font-semibold tracking-wide uppercase">Facultad de Contaduría y Administración</p>
            </div>
        </div>

        <div class="flex items-center gap-3 bg-[#F7F4F5] border border-[#7A1A2E]/20 p-2 rounded-2xl">
            <span class="text-xs font-semibold px-3 text-[#1A1A1A]">
                Usuario:
                <b class="text-[#7A1A2E]">
                    <?= htmlspecialchars($_SESSION['nombre'] ?? $_SESSION['usuario'] ?? 'Invitado') ?>
                </b>
            </span>
            <a href="?action=logout"
                class="bg-[#7A1A2E] hover:bg-[#5C1423] text-white font-bold text-xs px-4 py-2.5 rounded-xl transition">
                Cerrar sesión
            </a>
        </div>
    </div>
</header>
