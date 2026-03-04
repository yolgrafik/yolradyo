<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $siteName }} - Canlı Dinle</title>
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body {
            font-family: 'Segoe UI', system-ui, -apple-system, sans-serif;
            background: linear-gradient(145deg, #0a0e14 0%, #131a24 40%, #0d1219 100%);
            color: #f0f2f5;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 28px;
            overflow-x: hidden;
        }
        body::before {
            content: '';
            position: fixed;
            inset: 0;
            background: radial-gradient(ellipse 80% 50% at 50% 0%, rgba(201,42,42,0.08) 0%, transparent 60%);
            pointer-events: none;
        }
        .player-wrap {
            position: relative;
            width: 100%;
            max-width: 380px;
            background: linear-gradient(165deg, rgba(22,28,38,0.98) 0%, rgba(18,24,34,0.99) 100%);
            border: 1px solid rgba(255,255,255,0.08);
            border-radius: 24px;
            padding: 32px 28px;
            box-shadow: 0 25px 80px rgba(0,0,0,0.5), 0 0 0 1px rgba(255,255,255,0.03) inset;
            backdrop-filter: blur(20px);
        }
        .player-wrap::after {
            content: '';
            position: absolute;
            top: -1px;
            left: 50%;
            transform: translateX(-50%);
            width: 60%;
            height: 1px;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.15), transparent);
            border-radius: 1px;
        }
        .player-logo-wrap {
            position: relative;
            display: flex;
            justify-content: center;
            align-items: center;
            margin-bottom: 24px;
            width: 140px;
            height: 140px;
            margin-left: auto;
            margin-right: auto;
        }
        .player-logo-wrap .logo-img {
            width: 100%;
            height: 100%;
            object-fit: contain;
            object-position: center;
        }
        .disc-overlay {
            position: absolute;
            top: 50%;
            left: 50%;
            width: 52px;
            height: 52px;
            margin-top: -26px;
            margin-left: -26px;
            border-radius: 50%;
            background: linear-gradient(145deg, #ff3333, #cc2222);
            border: none;
            display: flex;
            justify-content: center;
            align-items: center;
            cursor: pointer;
            box-shadow: 0 4px 20px rgba(255,42,42,0.45), 0 0 0 3px rgba(255,255,255,0.1);
            transition: transform 0.2s, box-shadow 0.2s;
        }
        .disc-overlay:hover {
            transform: scale(1.05);
            box-shadow: 0 6px 28px rgba(255,42,42,0.55), 0 0 0 3px rgba(255,255,255,0.15);
        }
        .disc-overlay .icon { flex-shrink: 0; display: block; }
        .disc-overlay .icon.play {
            width: 0; height: 0;
            border-top: 8px solid transparent;
            border-bottom: 8px solid transparent;
            border-left: 14px solid #fff;
            margin-left: 4px;
        }
        .disc-overlay .icon.pause {
            width: 16px; height: 16px;
            position: relative; display: block;
        }
        .disc-overlay .icon.pause::before,
        .disc-overlay .icon.pause::after {
            content: ''; position: absolute; top: 0;
            width: 5px; height: 16px; background: #fff;
        }
        .disc-overlay .icon.pause::before { left: 0; }
        .disc-overlay .icon.pause::after { right: 0; }
        body.playing .disc-overlay {
            animation: spinDisc 2.5s linear infinite;
            box-shadow: 0 4px 20px rgba(255,42,42,0.5), 0 0 0 3px rgba(255,255,255,0.08);
        }
        @keyframes spinDisc { from { transform: rotate(0deg); } to { transform: rotate(360deg); } }
        .player-track {
            font-weight: 800;
            font-size: 1.05rem;
            text-align: center;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            margin-bottom: 6px;
            color: #fff;
            text-shadow: 0 1px 2px rgba(0,0,0,0.3);
        }
        .player-listeners {
            font-size: 13px;
            color: rgba(255,255,255,0.6);
            text-align: center;
            margin-bottom: 20px;
        }
        .player-vol-wrap {
            margin-bottom: 24px;
        }
        .player-vol-wrap input {
            width: 100%;
            height: 8px;
            -webkit-appearance: none;
            appearance: none;
            background: rgba(255,255,255,0.1);
            border-radius: 4px;
            outline: none;
        }
        .player-vol-wrap input::-webkit-slider-thumb {
            -webkit-appearance: none;
            width: 18px;
            height: 18px;
            border-radius: 50%;
            background: linear-gradient(145deg, #ff3333, #cc2222);
            cursor: pointer;
            box-shadow: 0 2px 8px rgba(255,42,42,0.4);
        }
        .player-actions {
            display: flex;
            flex-direction: column;
            gap: 12px;
        }
        .btn-istek {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            width: 100%;
            padding: 14px 20px;
            border-radius: 14px;
            border: none;
            background: linear-gradient(145deg, #ff2d2d, #c91a1a);
            color: #fff;
            font-weight: 800;
            font-size: 0.95rem;
            text-decoration: none;
            cursor: pointer;
            transition: transform 0.2s, box-shadow 0.2s;
            box-shadow: 0 4px 16px rgba(255,45,45,0.35);
        }
        .btn-istek:hover {
            transform: translateY(-1px);
            box-shadow: 0 6px 24px rgba(255,45,45,0.45);
        }
        .share-title {
            font-size: 11px;
            color: rgba(255,255,255,0.45);
            margin-bottom: 12px;
            text-align: center;
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        .share-btns {
            display: flex;
            gap: 12px;
            justify-content: center;
            flex-wrap: wrap;
        }
        .share-btn {
            width: 48px;
            height: 48px;
            border-radius: 14px;
            border: none;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            text-decoration: none;
            transition: transform 0.2s, box-shadow 0.2s;
        }
        .share-btn:hover {
            transform: translateY(-2px);
        }
        .share-wa { background: linear-gradient(145deg, #25D366, #1da851); color: #fff; box-shadow: 0 4px 12px rgba(37,211,102,0.35); }
        .share-tg { background: linear-gradient(145deg, #0088cc, #006699); color: #fff; box-shadow: 0 4px 12px rgba(0,136,204,0.35); }
        .share-fb { background: linear-gradient(145deg, #1877f2, #0d5bbf); color: #fff; box-shadow: 0 4px 12px rgba(24,119,242,0.35); }
        .share-btn svg { width: 24px; height: 24px; }
    </style>
</head>
<body>
    <div class="player-wrap">
        <div class="player-logo-wrap">
            <img src="{{ asset('assets/images/play.png') }}" class="logo-img" alt="{{ $siteName }}">
            <button type="button" id="discBtn" class="disc-overlay" title="Oynat / Duraklat" aria-label="Oynat / Duraklat">
                <span class="icon play"></span>
            </button>
        </div>
        <div class="player-track">
            <span class="cc_streaminfo" data-type="tracktitle" data-username="radyoyol"></span>
        </div>
        <div class="player-listeners">
            <span class="cc_streaminfo" data-type="listeners" data-username="radyoyol"></span> dinleyici
        </div>
        <div class="player-vol-wrap">
            <input type="range" id="playerVolume" min="0" max="1" step="0.01" value="{{ $defaultVolume }}" aria-label="Ses seviyesi">
        </div>
        <div class="player-actions">
            <a href="{{ url('/') }}#istek" target="_blank" class="btn-istek" title="Şarkı İsteği Gönder">🎵 İSTEK HATTI</a>
            <div class="share-title">Paylaş</div>
            <div class="share-btns">
                <a href="https://wa.me/?text={{ urlencode($shareText . ' ' . $shareUrl) }}" class="share-btn share-wa" target="_blank" rel="noopener" title="WhatsApp"><svg viewBox="0 0 24 24" fill="currentColor"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg></a>
                <a href="https://t.me/share/url?url={{ urlencode($shareUrl) }}&text={{ urlencode($shareText) }}" class="share-btn share-tg" target="_blank" rel="noopener" title="Telegram"><svg viewBox="0 0 24 24" fill="currentColor"><path d="M11.944 0A12 12 0 0 0 0 12a12 12 0 0 0 12 12 12 12 0 0 0 12-12A12 12 0 0 0 12 0a12 12 0 0 0-.056 0zm4.962 7.224c.1-.002.321.023.465.14a.506.506 0 0 1 .171.325c.016.093.036.306.02.472-.18 1.898-.962 6.502-1.36 8.627-.168.9-.499 1.201-.82 1.23-.696.065-1.225-.46-1.9-.902-1.056-.693-1.653-1.124-2.678-1.8-1.185-.78-.417-1.21.258-1.91.177-.184 3.247-2.977 3.307-3.23.007-.032.014-.15-.056-.212s-.174-.041-.249-.024c-.106.024-1.793 1.14-5.061 3.345-.48.33-.913.49-1.302.48-.428-.008-1.252-.241-1.865-.44-.752-.245-1.349-.374-1.297-.789.027-.216.325-.437.893-.663 3.498-1.524 5.83-2.529 6.998-3.014 3.332-1.386 4.025-1.627 4.476-1.635z"/></svg></a>
                <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode($shareUrl) }}" class="share-btn share-fb" target="_blank" rel="noopener" title="Facebook"><svg viewBox="0 0 24 24" fill="currentColor"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg></a>
            </div>
        </div>
    </div>
    <audio id="radioAudio" preload="none" playsinline data-stream-url="{{ $streamUrl }}" data-backup-url="{{ $backupUrl }}" data-default-volume="{{ $defaultVolume }}"></audio>
    <script src="https://r1.comcities.com/system/streaminfo.js"></script>
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        var btn = document.getElementById('discBtn');
        var audio = document.getElementById('radioAudio');
        var icon = btn ? btn.querySelector('.icon') : null;
        var vol = document.getElementById('playerVolume');
        if (!audio || !btn) return;
        var streamUrl = audio.getAttribute('data-stream-url') || '';
        var backupUrl = audio.getAttribute('data-backup-url') || '';
        var defaultVol = parseFloat(audio.getAttribute('data-default-volume')) || 0.8;
        audio.volume = defaultVol;
        if (vol) vol.value = defaultVol;
        var usedBackup = false;
        function tryPlay() {
            var url = (usedBackup ? backupUrl : streamUrl) || backupUrl || streamUrl;
            if (!url) return;
            audio.src = url;
            audio.load();
            audio.play().catch(function(){});
        }
        btn.addEventListener('click', function() {
            if (audio.paused) tryPlay();
            else audio.pause();
        });
        audio.addEventListener('play', function() {
            document.body.classList.add('playing');
            if (icon) { icon.classList.remove('play'); icon.classList.add('pause'); }
        });
        audio.addEventListener('pause', function() {
            document.body.classList.remove('playing');
            if (icon) { icon.classList.remove('pause'); icon.classList.add('play'); }
        });
        audio.addEventListener('ended', function() {
            document.body.classList.remove('playing');
            if (icon) { icon.classList.remove('pause'); icon.classList.add('play'); }
        });
        audio.addEventListener('error', function() {
            if (!usedBackup && backupUrl) {
                usedBackup = true;
                audio.src = backupUrl;
                audio.load();
                audio.play().catch(function(){});
            }
        });
        if (vol) vol.addEventListener('input', function() { audio.volume = parseFloat(this.value); });
    });
    </script>
</body>
</html>
