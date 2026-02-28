<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sentinel Access Vault - RooterIN</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body { background: #0f172a; color: white; }
        .glass { background: rgba(30, 41, 59, 0.7); backdrop-filter: blur(10px); border: 1px solid rgba(255,255,255,0.1); }
        .glow { box-shadow: 0 0 20px rgba(56, 189, 248, 0.2); }
    </style>
</head>
<body class="flex items-center justify-center min-h-screen">
    <div class="glass p-8 rounded-2xl glow w-full max-auto max-w-md">
        <div class="text-center mb-8">
            <h1 class="text-2xl font-bold text-sky-400">SENTINEL ACCESS VAULT</h1>
            <p class="text-slate-400 text-sm">RooterIN Management Infrastructure</p>
        </div>

        @if($errors->any())
            <div class="bg-red-500/20 border border-red-500 text-red-100 p-3 rounded-lg mb-6 text-sm">
                {{ $errors->first() }}
            </div>
        @endif

        <form action="{{ route('login') }}" method="POST" class="space-y-6">
            @csrf
            <div>
                <label class="block text-xs font-semibold uppercase tracking-wider text-slate-500 mb-2">Registry Email</label>
                <input type="email" name="email" required class="w-full bg-slate-900 border border-slate-700 rounded-lg px-4 py-3 focus:outline-none focus:border-sky-500 transition-colors">
            </div>
            <div>
                <label class="block text-xs font-semibold uppercase tracking-wider text-slate-500 mb-2">Neural Key (Password)</label>
                <input type="password" name="password" required class="w-full bg-slate-900 border border-slate-700 rounded-lg px-4 py-3 focus:outline-none focus:border-sky-500 transition-colors">
            </div>
            <button type="submit" class="w-full bg-sky-600 hover:bg-sky-500 text-white font-bold py-3 rounded-lg transition-all transform hover:scale-[1.02]">
                AUTHENTICATE
            </button>
        </form>
    </div>
</body>
</html>
