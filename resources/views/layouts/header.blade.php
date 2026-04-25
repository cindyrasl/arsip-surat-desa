<header class="bg-white border-b border-gray-200 px-4 md:px-6 py-3 flex items-center justify-between sticky top-0 z-10 shadow-sm">
    <!-- Mobile Burger Button -->
    <button @click="sidebarOpen = true" class="md:hidden w-10 h-10 flex items-center justify-center rounded-lg hover:bg-gray-100 transition-colors">
        <svg class="w-6 h-6 text-gray-700" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16"/>
        </svg>
    </button>

    <div class="relative ml-auto">
        <button onclick="toggleDropdown()" class="flex items-center gap-3 hover:bg-gray-50 rounded-xl px-3 py-2 transition-all">
            <div class="text-right">
                <p class="text-sm font-bold text-gray-800 leading-tight">{{ Auth::user()->nama ?? 'User' }}</p>
                <p class="text-xs text-gray-500 leading-tight">{{ Auth::user()->jabatan ?? 'Pengguna' }}</p>
            </div>
            <div class="w-10 h-10 rounded-full bg-primary-light overflow-hidden border-2 border-primary/30">
                <img src="{{ Auth::user()->profile_photo_url ?? 'https://ui-avatars.com/api/?name=' . urlencode(Auth::user()->nama) . '&background=6366f1&color=fff&size=128' }}" 
                    alt="Profile" class="w-full h-full object-cover"
                    onerror="this.src='https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->nama ?? 'User') }}&background=6366f1&color=fff&size=128'">
            </div>
            <svg id="dropdown-arrow" class="w-4 h-4 text-gray-500 transition-transform duration-200" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                <path d="M6 9l6 6 6-6" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
        </button>

        <div id="dropdown-menu" class="dropdown-menu absolute right-0 top-full mt-1 w-48 bg-white rounded-xl shadow-lg border border-gray-100 z-50 overflow-hidden hidden">
            <a href="#" onclick="openProfileModal()" class="flex items-center gap-3 px-4 py-3 text-sm text-gray-700 hover:bg-primary/10 transition-colors">
                <svg class="w-4 h-4 text-primary" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
                <span>Profil Saya</span>
            </a>
            <hr class="border-gray-100">
            
            <!-- FORM LOGOUT -->
            <form action="{{ route('logout') }}" method="POST" class="block">
                @csrf
                <button type="submit" class="flex items-center gap-3 w-full px-4 py-3 text-sm text-red-500 hover:bg-red-50 transition-colors text-left">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a2 2 0 01-2 2H5a2 2 0 01-2-2V7a2 2 0 012-2h6a2 2 0 012 2v1" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                    <span>Keluar</span>
                </button>
            </form>
        </div>
    </div>
</header>

<!-- MODAL PROFIL -->
<div id="profile-modal" class="fixed inset-0 bg-black/40 backdrop-blur-sm z-50 hidden items-center justify-center p-4">
    <div class="bg-white rounded-2xl shadow-2xl w-full max-w-2xl" onclick="event.stopPropagation()">
        <div class="flex items-center justify-between px-6 py-4 border-b border-gray-100">
            <div class="flex items-center gap-3">
                <div class="w-9 h-9 rounded-xl bg-primary/10 flex items-center justify-center">
                    <svg class="w-5 h-5 text-primary" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </div>
                <h3 class="font-bold text-gray-800">Pengaturan Profil</h3>
            </div>
            <button onclick="closeProfileModal()" class="w-8 h-8 flex items-center justify-center rounded-lg hover:bg-gray-100 text-gray-400">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>
        
        <div class="px-6 py-5">
            <!-- ROW 1: Foto + Info (2 kolom) -->
            <div class="grid grid-cols-2 gap-6 mb-6">
                <!-- Kolom Kiri: Foto Profil -->
                <div class="flex flex-col items-center">
                    <div class="relative">
                        <div class="w-28 h-28 rounded-full bg-primary-light overflow-hidden border-4 border-primary/30">
                            <img id="modal-profile-img" 
                                src="{{ Auth::user()->profile_photo_url ?? 'https://ui-avatars.com/api/?name=' . urlencode(Auth::user()->nama) . '&background=6366f1&color=fff&size=128' }}" 
                                alt="Profile" class="w-full h-full object-cover">
                        </div>
                        <label for="profile-photo-input" class="absolute bottom-0 right-0 w-8 h-8 rounded-full bg-primary hover:bg-primary-dark cursor-pointer flex items-center justify-center shadow-md transition-colors">
                            <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"/>
                                <path d="M12 14a3 3 0 100-6 3 3 0 000 6z"/>
                            </svg>
                        </label>
                        <input type="file" id="profile-photo-input" accept="image/*" class="hidden" onchange="previewPhoto(event)">
                    </div>
                    <p class="text-xs text-gray-400 mt-2">Klik kamera untuk ubah foto</p>
                </div>
                
                <!-- Kolom Kanan: Informasi Pengguna -->
                <div class="space-y-3">
                    <div>
                        <label class="block text-xs font-semibold text-gray-600 mb-1">Nama Lengkap</label>
                        <input type="text" value="{{ Auth::user()->nama ?? '' }}" 
                            class="w-full px-4 py-2.5 text-sm border border-gray-200 rounded-xl bg-gray-50 text-gray-500" readonly disabled>
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-gray-600 mb-1">Jabatan</label>
                        <input type="text" value="{{ Auth::user()->jabatan ?? '-' }}" 
                            class="w-full px-4 py-2.5 text-sm border border-gray-200 rounded-xl bg-gray-50 text-gray-500" readonly disabled>
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-gray-600 mb-1">Email</label>
                        <input type="text" value="{{ Auth::user()->email ?? '' }}" 
                            class="w-full px-4 py-2.5 text-sm border border-gray-200 rounded-xl bg-gray-50 text-gray-500" readonly disabled>
                    </div>
                </div>
            </div>
            
            <!-- ROW 2: Ubah Password -->
            <div class="border-t border-gray-100 pt-4">
                <h4 class="text-sm font-bold text-gray-700 mb-3">Ubah Password</h4>
                <div class="space-y-3">
                    <!-- Password Lama -->
                    <div>
                        <label class="block text-xs font-semibold text-gray-600 mb-1">Password Lama</label>
                        <div class="relative">
                            <input type="password" id="old-password" placeholder="Masukkan password lama"
                                class="w-full px-4 py-2.5 text-sm border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary transition-all pr-10">
                            <button type="button" onclick="togglePasswordVisibility('old-password', 'eye-icon-old')" 
                                class="absolute inset-y-0 right-0 flex items-center pr-3 text-gray-400 hover:text-gray-600">
                                <svg id="eye-icon-old" class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                            </button>
                        </div>
                    </div>
                    
                    <!-- Password Baru -->
                    <div>
                        <label class="block text-xs font-semibold text-gray-600 mb-1">Password Baru</label>
                        <div class="relative">
                            <input type="password" id="new-password" placeholder="Masukkan password baru (min. 6 karakter)"
                                class="w-full px-4 py-2.5 text-sm border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary transition-all pr-10">
                            <button type="button" onclick="togglePasswordVisibility('new-password', 'eye-icon-new')" 
                                class="absolute inset-y-0 right-0 flex items-center pr-3 text-gray-400 hover:text-gray-600">
                                <svg id="eye-icon-new" class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                            </button>
                        </div>
                    </div>
                    
                    <!-- Konfirmasi Password Baru -->
                    <div>
                        <label class="block text-xs font-semibold text-gray-600 mb-1">Konfirmasi Password Baru</label>
                        <div class="relative">
                            <input type="password" id="confirm-password" placeholder="Ulangi password baru"
                                class="w-full px-4 py-2.5 text-sm border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary transition-all pr-10">
                            <button type="button" onclick="togglePasswordVisibility('confirm-password', 'eye-icon-confirm')" 
                                class="absolute inset-y-0 right-0 flex items-center pr-3 text-gray-400 hover:text-gray-600">
                                <svg id="eye-icon-confirm" class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            
            <div id="profile-message" class="hidden text-sm font-medium mt-4"></div>
        </div>
        
        <div class="flex items-center justify-end gap-3 px-6 py-4 border-t border-gray-100">
            <button onclick="closeProfileModal()" class="px-5 py-2.5 text-sm font-semibold text-gray-600 hover:bg-gray-100 rounded-xl transition-colors">Batal</button>
            <button onclick="updateProfile()" class="px-5 py-2.5 text-sm font-semibold bg-primary hover:bg-primary-dark text-white rounded-xl transition-colors shadow-sm">Simpan Perubahan</button>
        </div>
    </div>
</div>

<script>
    // ==================== TOGGLE PASSWORD VISIBILITY ====================
    function togglePasswordVisibility(inputId, iconId) {
        const passwordInput = document.getElementById(inputId);
        const eyeIcon = document.getElementById(iconId);
        
        if (passwordInput.type === 'password') {
            passwordInput.type = 'text';
            eyeIcon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />';
        } else {
            passwordInput.type = 'password';
            eyeIcon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />';
        }
    }
    
    // ==================== DROPDOWN ====================
    function toggleDropdown() {
        const dropdown = document.getElementById('dropdown-menu');
        const arrow = document.getElementById('dropdown-arrow');
        
        dropdown.classList.toggle('hidden');
        arrow.style.transform = dropdown.classList.contains('hidden') ? 'rotate(0deg)' : 'rotate(180deg)';
    }
    
    document.addEventListener('click', function(event) {
        const dropdown = document.getElementById('dropdown-menu');
        const isClickInside = event.target.closest('.relative');
        
        if (dropdown && !dropdown.classList.contains('hidden') && !isClickInside) {
            dropdown.classList.add('hidden');
            const arrow = document.getElementById('dropdown-arrow');
            if (arrow) arrow.style.transform = 'rotate(0deg)';
        }
    });
    
    // ==================== MODAL PROFIL ====================
    let currentPhotoFile = null;
    
    function openProfileModal() {
        const modal = document.getElementById('profile-modal');
        modal.classList.remove('hidden');
        modal.classList.add('flex');
        
        // Reset form
        document.getElementById('old-password').value = '';
        document.getElementById('new-password').value = '';
        document.getElementById('confirm-password').value = '';
        document.getElementById('profile-message').classList.add('hidden');
        
        // Reset type password ke password (bukan text)
        const oldPassInput = document.getElementById('old-password');
        const newPassInput = document.getElementById('new-password');
        const confirmPassInput = document.getElementById('confirm-password');
        
        if (oldPassInput) oldPassInput.type = 'password';
        if (newPassInput) newPassInput.type = 'password';
        if (confirmPassInput) confirmPassInput.type = 'password';
        
        // Reset semua icon mata ke default (tertutup)
        const eyeIconOld = document.getElementById('eye-icon-old');
        const eyeIconNew = document.getElementById('eye-icon-new');
        const eyeIconConfirm = document.getElementById('eye-icon-confirm');
        
        const defaultEyeSvg = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />';
        
        if (eyeIconOld) eyeIconOld.innerHTML = defaultEyeSvg;
        if (eyeIconNew) eyeIconNew.innerHTML = defaultEyeSvg;
        if (eyeIconConfirm) eyeIconConfirm.innerHTML = defaultEyeSvg;
    }
    
    function closeProfileModal() {
        const modal = document.getElementById('profile-modal');
        modal.classList.add('hidden');
        modal.classList.remove('flex');
        currentPhotoFile = null;
    }
    
    function previewPhoto(event) {
        const file = event.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('modal-profile-img').src = e.target.result;
                currentPhotoFile = file;
                showMessage('Foto berhasil dipilih. Klik Simpan Perubahan untuk menyimpan.', 'success');
            };
            reader.readAsDataURL(file);
        }
    }
    
    function updateProfile() {
        const oldPass = document.getElementById('old-password').value;
        const newPass = document.getElementById('new-password').value;
        const confirmPass = document.getElementById('confirm-password').value;
        
        // Validasi jika ada input password
        if (oldPass || newPass || confirmPass) {
            if (!oldPass) {
                showMessage('Password lama harus diisi!', 'error');
                return;
            }
            if (!newPass) {
                showMessage('Password baru harus diisi!', 'error');
                return;
            }
            if (newPass.length < 6) {
                showMessage('Password baru minimal 6 karakter!', 'error');
                return;
            }
            if (newPass !== confirmPass) {
                showMessage('Konfirmasi password baru tidak cocok!', 'error');
                return;
            }
            
            showMessage('Password berhasil diubah!', 'success');
            
            // Reset form password
            document.getElementById('old-password').value = '';
            document.getElementById('new-password').value = '';
            document.getElementById('confirm-password').value = '';
        }
        
        // Update foto profil jika ada
        if (currentPhotoFile) {
            const reader = new FileReader();
            reader.onload = function(e) {
                localStorage.setItem('profile_photo', e.target.result);
                document.getElementById('profile-image').src = e.target.result;
                showMessage('Foto profil berhasil diperbarui!', 'success');
            };
            reader.readAsDataURL(currentPhotoFile);
            currentPhotoFile = null;
        }
        
        // Jika hanya update foto (tanpa password)
        if (!oldPass && !newPass && !confirmPass && currentPhotoFile === null) {
            showMessage('Tidak ada perubahan yang disimpan', 'error');
            return;
        }
        
        // Tutup modal setelah 1.5 detik jika ada perubahan
        if (oldPass || newPass || confirmPass || currentPhotoFile !== null) {
            setTimeout(() => {
                closeProfileModal();
            }, 1500);
        }
    }
    
    function showMessage(msg, type) {
        const msgDiv = document.getElementById('profile-message');
        msgDiv.textContent = msg;
        msgDiv.className = `text-sm font-medium p-3 rounded-xl ${type === 'error' ? 'bg-red-50 text-red-600' : 'bg-green-50 text-green-600'}`;
        msgDiv.classList.remove('hidden');
        
        setTimeout(() => {
            msgDiv.classList.add('hidden');
        }, 3000);
    }
    
    // Load data dari localStorage saat halaman dimuat
    document.addEventListener('DOMContentLoaded', function() {
        const savedPhoto = localStorage.getItem('profile_photo');
        if (savedPhoto) {
            const profileImage = document.getElementById('profile-image');
            const modalImage = document.getElementById('modal-profile-img');
            
            if (profileImage) profileImage.src = savedPhoto;
            if (modalImage) modalImage.src = savedPhoto;
        }
    });
    
    // Tutup modal saat klik overlay
    document.getElementById('profile-modal').addEventListener('click', function(e) {
        if (e.target === this) closeProfileModal();
    });
</script>

<style>
    .dropdown-menu {
        transition: all 0.2s ease;
    }
    
    .dropdown-menu:not(.hidden) {
        animation: dropdownFadeIn 0.2s ease;
    }
    
    @keyframes dropdownFadeIn {
        from {
            opacity: 0;
            transform: translateY(-10px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
</style>