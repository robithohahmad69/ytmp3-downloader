<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>YTMP3 — YouTube to MP3</title>
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            font-family: 'Segoe UI', sans-serif;
            background: #0f0f0f;
            color: #eee;
            min-height: 100vh;
        }

        /* NAVBAR */
        nav {
            background: #181818;
            padding: 16px 32px;
            display: flex;
            align-items: center;
            gap: 12px;
            border-bottom: 1px solid #2a2a2a;
            position: sticky;
            top: 0;
            z-index: 100;
        }
        .logo { font-size: 20px; font-weight: 700; color: #ff4444; }
        .logo span { color: #fff; }
        .nav-sub { font-size: 13px; color: #666; margin-left: auto; }

        /* BREADCRUMB */
        .breadcrumb {
            padding: 10px 32px;
            font-size: 13px;
            color: #666;
            background: #141414;
            border-bottom: 1px solid #1e1e1e;
        }
        .breadcrumb a { color: #ff4444; text-decoration: none; }
        .breadcrumb a:hover { text-decoration: underline; }
        .breadcrumb span { margin: 0 6px; }

        /* CONTAINER */
        .container { max-width: 860px; margin: 36px auto; padding: 0 20px; }

        /* TABS */
        .tabs {
            display: flex;
            gap: 8px;
            margin-bottom: 20px;
        }
        .tab-btn {
            padding: 10px 22px;
            border-radius: 8px;
            border: 1px solid #2a2a2a;
            background: #1a1a1a;
            color: #888;
            cursor: pointer;
            font-size: 14px;
            transition: all 0.2s;
        }
        .tab-btn.active {
            background: #ff4444;
            color: #fff;
            border-color: #ff4444;
        }
        .tab-btn:hover:not(.active) {
            border-color: #444;
            color: #ccc;
        }

        /* PANELS */
        .panel { display: none; }
        .panel.active { display: block; }

        /* CARD */
        .card {
            background: #1a1a1a;
            border-radius: 12px;
            padding: 24px;
            border: 1px solid #2a2a2a;
            margin-bottom: 20px;
        }
        .card-title {
            font-size: 13px;
            color: #888;
            margin-bottom: 14px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        /* INPUT */
        .input-row {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
        }
        input[type="text"] {
            flex: 1;
            min-width: 200px;
            padding: 11px 16px;
            border-radius: 8px;
            border: 1px solid #2a2a2a;
            background: #111;
            color: #eee;
            font-size: 14px;
            outline: none;
            transition: border-color 0.2s;
        }
        input[type="text"]:focus { border-color: #ff4444; }

        select {
            padding: 11px 14px;
            border-radius: 8px;
            border: 1px solid #2a2a2a;
            background: #111;
            color: #eee;
            font-size: 14px;
            outline: none;
            cursor: pointer;
        }
        select:focus { border-color: #ff4444; }

        /* BUTTON */
        .btn {
            padding: 11px 22px;
            border-radius: 8px;
            border: none;
            cursor: pointer;
            font-size: 14px;
            font-weight: 600;
            transition: all 0.2s;
            white-space: nowrap;
        }
        .btn-primary { background: #ff4444; color: #fff; }
        .btn-primary:hover:not(:disabled) { background: #cc2222; }
        .btn-sm {
            padding: 8px 16px;
            font-size: 13px;
        }
        .btn:disabled {
            opacity: 0.55;
            cursor: not-allowed;
        }

        /* SPINNER */
        .spinner {
            display: inline-block;
            width: 11px;
            height: 11px;
            border: 2px solid #ffffff44;
            border-top-color: #fff;
            border-radius: 50%;
            animation: spin 0.7s linear infinite;
            margin-right: 5px;
            vertical-align: middle;
        }
        @keyframes spin { to { transform: rotate(360deg); } }

        /* ALERT */
        .alert {
            padding: 12px 16px;
            border-radius: 8px;
            margin-bottom: 18px;
            font-size: 14px;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .alert-error   { background: #1e0a0a; border: 1px solid #ff4444; color: #ff8888; }
        .alert-success { background: #0a1e0a; border: 1px solid #44bb44; color: #88dd88; }

        /* LOADING SEARCH */
        .search-loading {
            text-align: center;
            padding: 40px 20px;
            color: #666;
            display: none;
        }
        .search-loading.show { display: block; }
        .search-loading .big-spinner {
            width: 32px; height: 32px;
            border: 3px solid #222;
            border-top-color: #ff4444;
            border-radius: 50%;
            animation: spin 0.8s linear infinite;
            margin: 0 auto 14px;
        }

        /* RESULTS */
        .results-meta {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 14px;
        }
        .results-meta h3 { font-size: 14px; color: #aaa; }
        .badge {
            font-size: 12px;
            background: #222;
            color: #888;
            padding: 3px 10px;
            border-radius: 20px;
            border: 1px solid #2a2a2a;
        }

        /* RESULT CARD */
        .result-card {
            background: #1a1a1a;
            border: 1px solid #2a2a2a;
            border-radius: 10px;
            display: flex;
            gap: 14px;
            padding: 14px;
            margin-bottom: 10px;
            align-items: center;
            transition: border-color 0.2s, background 0.2s;
        }
        .result-card:hover {
            border-color: #ff444455;
            background: #1e1e1e;
        }
        .result-card img {
            width: 112px;
            height: 63px;
            object-fit: cover;
            border-radius: 6px;
            flex-shrink: 0;
            background: #111;
        }
        .result-info { flex: 1; min-width: 0; }
        .result-title {
            font-size: 14px;
            font-weight: 600;
            color: #ddd;
            margin-bottom: 5px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }
        .result-duration {
            font-size: 12px;
            color: #666;
        }
        .result-actions {
            display: flex;
            align-items: center;
            gap: 8px;
            flex-shrink: 0;
        }

        /* TOAST */
        .toast {
            position: fixed;
            bottom: 28px;
            right: 28px;
            background: #1e1e1e;
            border: 1px solid #333;
            border-radius: 10px;
            padding: 14px 18px;
            font-size: 14px;
            display: flex;
            align-items: center;
            gap: 10px;
            z-index: 9999;
            transform: translateY(20px);
            opacity: 0;
            transition: all 0.3s ease;
            max-width: 320px;
            pointer-events: none;
        }
        .toast.show { transform: translateY(0); opacity: 1; }
        .toast.success { border-color: #44bb44; color: #88dd88; }
        .toast.loading { border-color: #ffaa44; color: #ffcc88; }
        .toast.error   { border-color: #ff4444; color: #ff8888; }
        .toast .toast-spinner {
            width: 14px; height: 14px;
            border: 2px solid #ffaa4444;
            border-top-color: #ffaa44;
            border-radius: 50%;
            animation: spin 0.7s linear infinite;
            flex-shrink: 0;
        }

        /* EMPTY STATE */
        .empty {
            text-align: center;
            padding: 48px 20px;
            color: #555;
        }
        .empty .icon { font-size: 40px; margin-bottom: 12px; }
        .empty p { font-size: 14px; }
    </style>
</head>
<body>

{{-- NAVBAR --}}
<nav>
    <div class="logo">YT<span>MP3</span></div>
    <div class="nav-sub">YouTube to MP3 Converter</div>
</nav>

{{-- BREADCRUMB --}}
<div class="breadcrumb">
    <a href="/">Home</a>
    @isset($query)
        <span>›</span><a href="/search?q={{ urlencode($query) }}">Search</a>
        <span>›</span>{{ Str::limit($query, 40) }}
    @else
        <span>›</span> Convert
    @endisset
</div>

<div class="container">

    {{-- ALERTS --}}
    @if(session('error'))
        <div class="alert alert-error">⚠️ {{ session('error') }}</div>
    @endif
    @if(session('success'))
        <div class="alert alert-success">✅ {{ session('success') }}</div>
    @endif

    {{-- TABS --}}
    <div class="tabs">
        <button class="tab-btn {{ !isset($query) ? 'active' : '' }}"
                onclick="switchTab('paste', this)">
            🔗 Paste URL
        </button>
        <button class="tab-btn {{ isset($query) ? 'active' : '' }}"
                onclick="switchTab('search', this)">
            🔍 Cari Judul
        </button>
    </div>

    {{-- PANEL: PASTE URL --}}
    <div class="panel {{ !isset($query) ? 'active' : '' }}" id="panel-paste">
        <div class="card">
            <div class="card-title">Paste link YouTube</div>
            <form action="/download" method="POST" class="download-form">
                @csrf
                <div class="input-row">
                    <input type="text" name="url"
                           placeholder="https://www.youtube.com/watch?v=..."
                           required>
                    <select name="quality">
                        <option value="128">128 kbps</option>
                        <option value="192" selected>192 kbps</option>
                        <option value="320">320 kbps</option>
                    </select>
                    <button type="submit" class="btn btn-primary">
                        ⬇ Download
                    </button>
                </div>
            </form>
        </div>
    </div>

    {{-- PANEL: SEARCH --}}
    <div class="panel {{ isset($query) ? 'active' : '' }}" id="panel-search">
        <div class="card">
            <div class="card-title">Cari lagu atau video</div>
            <form action="/search" method="GET" id="search-form">
                <div class="input-row">
                    <input type="text" name="q"
                           placeholder="Contoh: Bruno Mars Risk It All..."
                           value="{{ $query ?? '' }}">
                    <button type="submit" class="btn btn-primary">
                        🔍 Cari
                    </button>
                </div>
            </form>
        </div>

        {{-- LOADING --}}
        <div class="search-loading" id="search-loading">
            <div class="big-spinner"></div>
            Sedang mencari video...
        </div>

        {{-- HASIL --}}
        @isset($results)
            @if(count($results) > 0)
                <div class="results-meta">
                    <h3>Hasil untuk "{{ $query }}"</h3>
                    <span class="badge">{{ count($results) }} video</span>
                </div>

                @foreach($results as $index => $video)
                    <div class="result-card">
                        <img src="{{ $video['thumb'] }}"
                             alt="{{ $video['title'] }}"
                             onerror="this.style.background='#222'">
                        <div class="result-info">
                            <div class="result-title">{{ $video['title'] }}</div>
                            <div class="result-duration">⏱ {{ $video['duration'] }}</div>
                        </div>
                        <div class="result-actions">
                            <form action="/download" method="POST" class="download-form">
                                @csrf
                                <input type="hidden" name="url" value="{{ $video['url'] }}">
                                <select name="quality">
                                    <option value="128">128 kbps</option>
                                    <option value="192" selected>192 kbps</option>
                                    <option value="320">320 kbps</option>
                                </select>
                                <button type="submit" class="btn btn-primary btn-sm">
                                    ⬇ Download
                                </button>
                            </form>
                        </div>
                    </div>
                @endforeach

            @else
                <div class="empty">
                    <div class="icon">🔍</div>
                    <p>Tidak ada hasil untuk "{{ $query }}"</p>
                </div>
            @endif
        @else
            @if(!isset($query))
                <div class="empty">
                    <div class="icon">🎵</div>
                    <p>Ketik judul lagu atau nama artis untuk mulai mencari</p>
                </div>
            @endif
        @endisset
    </div>

</div>

{{-- TOAST --}}
<div class="toast" id="toast"></div>

<script>
    // Switch tab
    function switchTab(tab, btnEl) {
        document.querySelectorAll('.panel').forEach(p => p.classList.remove('active'));
        document.querySelectorAll('.tab-btn').forEach(b => b.classList.remove('active'));
        document.getElementById('panel-' + tab).classList.add('active');
        btnEl.classList.add('active');
    }

    // Toast notification
    function showToast(message, type = 'loading', duration = 0) {
        const toast = document.getElementById('toast');
        toast.className = 'toast ' + type + ' show';

        if (type === 'loading') {
            toast.innerHTML = '<div class="toast-spinner"></div>' + message;
        } else {
            toast.innerHTML = message;
        }

        if (duration > 0) {
            setTimeout(() => toast.classList.remove('show'), duration);
        }
    }

    function hideToast() {
        document.getElementById('toast').classList.remove('show');
    }

    // Handle download forms
    document.querySelectorAll('.download-form').forEach(form => {
        form.addEventListener('submit', function () {
            const btn = this.querySelector('button[type="submit"]');
            btn.disabled = true;
            btn.innerHTML = '<span class="spinner"></span> Memproses...';
            showToast('⏳ Sedang mengunduh, mohon tunggu...', 'loading');

            // Re-enable setelah 30 detik (fallback)
            setTimeout(() => {
                btn.disabled = false;
                btn.innerHTML = '⬇ Download';
                hideToast();
            }, 30000);
        });
    });

    // Handle search form
    document.getElementById('search-form').addEventListener('submit', function () {
        const btn = this.querySelector('button[type="submit"]');
        btn.disabled = true;
        btn.innerHTML = '<span class="spinner"></span> Mencari...';
        document.getElementById('search-loading').classList.add('show');
    });

    // Tampilkan toast dari session
    @if(session('error'))
        showToast('⚠️ {{ session("error") }}', 'error', 5000);
    @endif
    @if(session('success'))
        showToast('✅ {{ session("success") }}', 'success', 4000);
    @endif
</script>

</body>
</html>