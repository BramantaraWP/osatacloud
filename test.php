<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>OSIS Cloud v2</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        :root {
            --primary: #00d2ff;
            --secondary: #9d50bb;
            --glass: rgba(255, 255, 255, 0.07);
            --border: rgba(255, 255, 255, 0.15);
        }

        /* Animated Mesh Background */
        body {
            margin: 0;
            padding: 0;
            background: #0b0e14;
            color: #fff;
            font-family: 'Plus Jakarta Sans', sans-serif;
            overflow-x: hidden;
            min-height: 100vh;
        }

        .bg-glow {
            position: fixed;
            top: 0; left: 0; width: 100%; height: 100%;
            z-index: -1;
            background: 
                radial-gradient(circle at 20% 30%, rgba(0, 210, 255, 0.15) 0%, transparent 40%),
                radial-gradient(circle at 80% 70%, rgba(157, 80, 187, 0.15) 0%, transparent 40%);
            animation: pulseBg 10s ease-in-out infinite alternate;
        }

        @keyframes pulseBg {
            from { transform: scale(1); opacity: 0.7; }
            to { transform: scale(1.2); opacity: 1; }
        }

        /* Glassmorphism Styling */
        .glass {
            background: var(--glass);
            backdrop-filter: blur(15px);
            -webkit-backdrop-filter: blur(15px);
            border: 1px solid var(--border);
            border-radius: 20px;
        }

        /* Navbar Modern */
        .navbar-floating {
            margin: 20px auto;
            max-width: 1200px;
            padding: 15px 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            position: sticky;
            top: 20px;
            z-index: 1000;
        }

        .brand-text {
            font-size: 1.5rem;
            font-weight: 800;
            background: linear-gradient(45deg, var(--primary), var(--secondary));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            letter-spacing: -1px;
        }

        /* File Cards with 3D Hover */
        .file-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(260px, 1fr));
            gap: 25px;
            padding: 20px 0;
        }

        .file-card {
            padding: 25px;
            position: relative;
            transition: all 0.5s cubic-bezier(0.23, 1, 0.32, 1);
            overflow: hidden;
            cursor: pointer;
            perspective: 1000px;
        }

        .file-card:hover {
            transform: translateY(-12px) rotateX(5deg) rotateY(2deg);
            background: rgba(255, 255, 255, 0.12);
            border-color: var(--primary);
            box-shadow: 0 20px 40px rgba(0,0,0,0.4);
        }

        .file-card::before {
            content: '';
            position: absolute;
            top: -50%; left: -50%; width: 200%; height: 200%;
            background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 70%);
            opacity: 0; transition: 0.5s; pointer-events: none;
        }

        .file-card:hover::before { opacity: 1; }

        .icon-box {
            width: 55px; height: 55px;
            background: linear-gradient(135deg, rgba(0,210,255,0.2), rgba(157,80,187,0.2));
            border-radius: 16px;
            display: flex; align-items: center; justify-content: center;
            font-size: 1.5rem; color: var(--primary);
            margin-bottom: 20px;
        }

        /* Custom Progress Bar */
        .liquid-progress {
            height: 8px; border-radius: 10px; background: rgba(255,255,255,0.05);
            overflow: hidden; position: relative;
        }
        .liquid-bar {
            height: 100%; background: linear-gradient(90deg, var(--primary), var(--secondary));
            transition: width 0.4s ease;
        }

        /* Share Modal Specifics */
        .share-box {
            background: rgba(0,0,0,0.3);
            border: 1px solid var(--border);
            padding: 15px; border-radius: 15px;
            display: flex; align-items: center; gap: 10px;
        }

        .btn-neon {
            background: linear-gradient(45deg, var(--primary), var(--secondary));
            border: none; color: white; border-radius: 12px;
            padding: 10px 25px; font-weight: 600;
            box-shadow: 0 4px 15px rgba(0, 210, 255, 0.3);
            transition: 0.3s;
        }
        .btn-neon:hover {
            transform: scale(1.05);
            box-shadow: 0 8px 25px rgba(0, 210, 255, 0.5);
        }

        /* Login Screen */
        .login-wrap {
            height: 100vh; display: flex; align-items: center; justify-content: center;
        }
        .login-card {
            width: 400px; padding: 40px; text-align: center;
            animation: float 6s ease-in-out infinite;
        }
        @keyframes float {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-20px); }
        }

        /* Custom Alert */
        .alert-toast {
            position: fixed; bottom: 30px; right: 30px; z-index: 2000;
            padding: 15px 25px; border-radius: 12px;
            animation: slideUp 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        }
        @keyframes slideUp { from { transform: translateY(100px); opacity: 0; } to { transform: translateY(0); opacity: 1; } }
    </style>
</head>
<body>

    <div class="bg-glow"></div>
    <div id="toastContainer"></div>

    <!-- PAGE: LOGIN -->
    <div id="loginScreen" class="container login-wrap">
        <div class="glass login-card">
            <div class="icon-box mx-auto" style="width: 80px; height: 80px; font-size: 2.5rem;">
                <i class="fas fa-cloud"></i>
            </div>
            <h2 class="brand-text mb-4">OSATA CLOUD</h2>
            <form id="loginForm">
                <input type="text" id="user" class="form-control bg-white border-0 text-black mb-3 py-3 rounded-4" placeholder="Username" required>
                <input type="password" id="pass" class="form-control bg-white border-0 text-black mb-4 py-3 rounded-4" placeholder="Password" required>
                <button type="submit" class="btn-neon w-100 py-3">Buka Akses</button>
            </form>
        </div>
    </div>

    <!-- PAGE: APP -->
    <div id="appScreen" class="d-none">
        <nav class="glass navbar-floating">
            <div class="brand-text">LIQUID CLOUD</div>
            <div class="d-flex gap-2">
                <input type="file" id="uploadInput" class="d-none" multiple>
                <button class="btn btn-dark rounded-circle" style="width:45px; height:45px" onclick="document.getElementById('uploadInput').click()">
                    <i class="fas fa-plus"></i>
                </button>
                <button class="btn btn-dark rounded-circle" style="width:45px; height:45px" onclick="location.reload()">
                    <i class="fas fa-sign-out-alt"></i>
                </button>
            </div>
        </nav>

        <div class="container pb-5">
            <div id="upStatus" class="glass p-3 mb-4 d-none">
                <div class="d-flex justify-content-between mb-2">
                    <small id="upName">Uploading...</small>
                    <small id="upPercent">0%</small>
                </div>
                <div class="liquid-progress">
                    <div id="upBar" class="liquid-bar" style="width: 0%"></div>
                </div>
            </div>

            <div class="file-grid" id="mainGrid">
                <!-- Data file bakal muncul di sini -->
            </div>
        </div>
    </div>

    <!-- MODAL: PREVIEW -->
    <div class="modal fade" id="vModal" tabindex="-1">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content glass border-0 text-white">
                <div class="modal-header border-0 pb-0">
                    <h5 id="vTitle" class="fw-bold"></h5>
                    <button class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div id="vView" class="text-center rounded-4 overflow-hidden" style="min-height: 200px; background: rgba(0,0,0,0.2); display:flex; align-items:center; justify-content:center;">
                        <!-- Media View -->
                    </div>
                </div>
                <div class="modal-footer border-0">
                    <a id="vDown" class="btn-neon text-decoration-none" href="#" target="_blank">Download File</a>
                </div>
            </div>
        </div>
    </div>

    <!-- MODAL: SHARE -->
    <div class="modal fade" id="sModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content glass border-0 text-white">
                <div class="modal-header border-0">
                    <h5 class="fw-bold">Bagikan File</h5>
                    <button class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <p class="small opacity-75">Salin link di bawah ini untuk berbagi:</p>
                    <div class="share-box">
                        <input type="text" id="shareLink" class="bg-transparent border-0 text-info w-100 small" readonly>
                        <button class="btn btn-sm btn-info rounded-3" onclick="copyLink()">
                            <i class="fas fa-copy"></i>
                        </button>
                    </div>
                    <div class="mt-3 text-center">
                        <small class="text-muted">Link dienkripsi dengan Liquid Token</small>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        const STORAGE_KEY = 'liquid_osis_data';
        const BOT = {
            T: '8401425763:AAGzfWOOETNcocI7JCj9zQxBhZZ2fVaworI',
            C: '1642600339'
        };

        let viewModal, shareModal;

        const LiquidUI = {
            init() {
                viewModal = new bootstrap.Modal(document.getElementById('vModal'));
                shareModal = new bootstrap.Modal(document.getElementById('sModal'));
                this.render();
            },

            toast(msg) {
                const id = 't'+Date.now();
                const html = `<div id="${id}" class="glass alert-toast border-0"><i class="fas fa-check-circle text-success me-2"></i> ${msg}</div>`;
                document.getElementById('toastContainer').insertAdjacentHTML('beforeend', html);
                setTimeout(() => {
                    const el = document.getElementById(id);
                    if(el) el.style.opacity = '0';
                    setTimeout(() => el?.remove(), 500);
                }, 3000);
            },

            render() {
                const data = JSON.parse(localStorage.getItem(STORAGE_KEY) || '[]');
                const grid = document.getElementById('mainGrid');
                
                if(data.length === 0) {
                    grid.innerHTML = `<div class="text-center w-100 py-5 opacity-50"><i class="fas fa-folder-open fa-3x mb-3"></i><p>Belum ada file nih Bro</p></div>`;
                    return;
                }

                grid.innerHTML = data.map((f, i) => `
                    <div class="glass file-card" onclick="LiquidUI.open(${i})">
                        <div class="icon-box"><i class="${this.getIcon(f.name)}"></i></div>
                        <div class="fw-bold text-truncate">${f.name}</div>
                        <div class="small opacity-50 mb-3">${(f.size/1024).toFixed(1)} KB</div>
                        <div class="d-flex gap-2">
                            <button class="btn btn-dark btn-sm rounded-3 flex-grow-1 py-2" onclick="event.stopPropagation(); LiquidUI.share(${i})">
                                <i class="fas fa-share-nodes"></i>
                            </button>
                            <button class="btn btn-dark btn-sm rounded-3 px-3 py-2" onclick="event.stopPropagation(); LiquidUI.del(${i})">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                    </div>
                `).join('');
            },

            getIcon(name) {
                const ext = name.split('.').pop().toLowerCase();
                if(['jpg','png','jpeg','webp'].includes(ext)) return 'fas fa-image';
                if(['mp4','mov'].includes(ext)) return 'fas fa-video';
                if(['pdf'].includes(ext)) return 'fas fa-file-pdf';
                return 'fas fa-file-code';
            },

            async open(idx) {
                const data = JSON.parse(localStorage.getItem(STORAGE_KEY));
                const f = data[idx];
                document.getElementById('vTitle').innerText = f.name;
                document.getElementById('vView').innerHTML = '<div class="spinner-border text-info"></div>';
                viewModal.show();

                const res = await fetch(`https://api.telegram.org/bot${BOT.T}/getFile?file_id=${f.file_id}`);
                const fileData = await res.json();
                if(fileData.ok) {
                    const url = `https://api.telegram.org/file/bot${BOT.T}/${fileData.result.file_path}`;
                    const ext = f.name.split('.').pop().toLowerCase();
                    
                    if(['jpg','png','jpeg','webp'].includes(ext)) {
                        document.getElementById('vView').innerHTML = `<img src="${url}" class="img-fluid w-100">`;
                    } else if(['mp4','mov'].includes(ext)) {
                        document.getElementById('vView').innerHTML = `<video src="${url}" controls class="w-100"></video>`;
                    } else {
                        document.getElementById('vView').innerHTML = `<div class="p-5"><i class="fas fa-file fa-3x mb-3"></i><p>Preview tidak tersedia</p></div>`;
                    }
                    document.getElementById('vDown').href = url;
                }
            },

            share(idx) {
                const data = JSON.parse(localStorage.getItem(STORAGE_KEY));
                const f = data[idx];
                // Generate simple share token
                const token = btoa(f.file_id).substring(0, 12);
                const shareUrl = `${window.location.origin}${window.location.pathname}?share=${token}`;
                document.getElementById('shareLink').value = shareUrl;
                shareModal.show();
            },

            del(idx) {
                if(confirm('Hapus file ini, Anjay?')) {
                    const data = JSON.parse(localStorage.getItem(STORAGE_KEY));
                    data.splice(idx, 1);
                    localStorage.setItem(STORAGE_KEY, JSON.stringify(data));
                    this.render();
                    this.toast("File berhasil dihapus!");
                }
            }
        };

        // Upload Logic
        document.getElementById('uploadInput').onchange = async function() {
            const files = Array.from(this.files);
            const status = document.getElementById('upStatus');
            const bar = document.getElementById('upBar');
            const nameTxt = document.getElementById('upName');
            const pctTxt = document.getElementById('upPercent');

            status.classList.remove('d-none');

            for(const f of files) {
                nameTxt.innerText = `Mengirim: ${f.name}`;
                const fd = new FormData();
                fd.append('chat_id', BOT.C);
                fd.append('document', f);

                const xhr = new XMLHttpRequest();
                xhr.open('POST', `https://api.telegram.org/bot${BOT.T}/sendDocument`);
                
                xhr.upload.onprogress = (e) => {
                    const p = Math.round((e.loaded / e.total) * 100);
                    bar.style.width = p + '%';
                    pctTxt.innerText = p + '%';
                };

                xhr.onload = () => {
                    const r = JSON.parse(xhr.responseText);
                    if(r.ok) {
                        const db = JSON.parse(localStorage.getItem(STORAGE_KEY) || '[]');
                        db.push({
                            file_id: r.result.document.file_id,
                            name: f.name,
                            size: f.size,
                            date: Date.now()
                        });
                        localStorage.setItem(STORAGE_KEY, JSON.stringify(db));
                        LiquidUI.render();
                        LiquidUI.toast("Upload beres, Anjay!");
                    }
                };
                xhr.send(fd);
            }
            setTimeout(() => status.classList.add('d-none'), 2000);
        };

        // Copy Link
        function copyLink() {
            const el = document.getElementById('shareLink');
            el.select();
            document.execCommand('copy');
            LiquidUI.toast("Link disalin!");
        }

        // Login Handler
        document.getElementById('loginForm').onsubmit = (e) => {
            e.preventDefault();
            document.getElementById('loginScreen').classList.add('d-none');
            document.getElementById('appScreen').classList.remove('d-none');
            LiquidUI.init();
        };
    </script>
</body>
</html>

