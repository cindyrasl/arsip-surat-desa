<div>
<div class="max-w-7xl mx-auto">
    <div class="flex items-center justify-between mb-5">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 rounded-xl bg-primary flex items-center justify-center shadow-md">
                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />
                </svg>
            </div>
            <div>
                <h1 class="text-lg font-bold text-gray-800 leading-tight">Pengguna</h1>
                <p class="text-xs text-gray-500">Kelola pengguna sistem</p>
            </div>
        </div>
    </div>

    @if(session('success'))
        <div class="mb-4 px-4 py-3 bg-green-50 border border-green-200 text-green-700 text-sm rounded-xl">{{ session('success') }}</div>
    @endif

    @if(session('error'))
        <div class="mb-4 px-4 py-3 bg-red-50 border border-red-200 text-red-700 text-sm rounded-xl">{{ session('error') }}</div>
    @endif

    <div class="flex flex-wrap items-center gap-3 mb-5">
        <div class="relative flex-1 min-w-50">
            <span class="absolute inset-y-0 left-3 flex items-center pointer-events-none">
                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <circle cx="11" cy="11" r="8"/><path d="M21 21l-4.35-4.35"/>
                </svg>
            </span>
            <input type="text" wire:model.live.debounce.300ms="search" placeholder="Cari username, nama, jabatan, atau email..."
                class="w-full pl-9 pr-4 py-2.5 text-sm border border-gray-200 rounded-xl bg-white focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary transition-all">
        </div>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-gray-100">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-3 px-4 md:px-6 py-4 border-b border-gray-100">
            <h2 class="font-bold text-gray-800">Daftar Nama Pengguna</h2>
            <button wire:click="openAddModal" class="flex items-center justify-center gap-2 bg-primary hover:bg-primary-dark text-white text-sm font-semibold px-4 py-2.5 rounded-xl transition-colors shadow-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M12 5v14M5 12h14" stroke-linecap="round"/></svg>
                Tambah Pengguna
            </button>
        </div>

        <!-- Desktop Table View -->
        <div class="hidden md:block overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="bg-gray-100 border-b border-gray-100">
                        <th class="text-left px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wide w-14">No</th>
                        <th class="text-left px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wide">Username</th>
                        <th class="text-left px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wide">Nama</th>
                        <th class="text-left px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wide">Jabatan</th>
                        <th class="text-left px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wide">Email</th>
                        <th class="text-left px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wide">Tanggal Dibuat</th>
                        <th class="text-left px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wide">Terakhir Login</th>
                        <th class="text-center px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wide">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @forelse($pengguna as $i => $user)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-6 py-3.5 text-gray-400 text-sm">{{ $pengguna->firstItem() + $i }}</td>
                            <td class="px-6 py-3.5"><span class="text-sm font-semibold text-gray-700">{{ $user->username }}</span></td>
                            <td class="px-6 py-3.5 text-sm text-gray-700">{{ $user->nama }}</td>
                            <td class="px-6 py-3.5 text-sm text-gray-700">{{ $user->jabatan ?? '-' }}</td>
                            <td class="px-6 py-3.5 text-sm text-gray-700">{{ $user->email }}</td>
                            <td class="px-6 py-3.5 text-sm text-gray-500 whitespace-nowrap">{{ $user->created_at?->format('d/m/Y - H:i') . ' WIB' ?? '-' }}</td>
                            <td class="px-6 py-3.5 text-sm text-gray-500 whitespace-nowrap">{{ $user->last_login_at ? $user->last_login_at->format('d/m/Y - H:i') . ' WIB' : 'Belum login' }}</td>
                            <td class="px-6 py-3.5">
                                <div class="flex items-center justify-center gap-2">
                                    <button wire:click="openEditModal({{ $user->id }})" title="Edit" class="w-8 h-8 rounded-lg bg-amber-50 hover:bg-amber-100 flex items-center justify-center transition-colors">
                                        <svg class="w-4 h-4 text-amber-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5"/><path d="M17.586 3.586a2 2 0 012.828 2.828L12 15l-4 1 1-4 8.586-8.414z"/></svg>
                                    </button>
                                    <button wire:click="openDelete({{ $user->id }})" title="Hapus" class="w-8 h-8 rounded-lg bg-red-50 hover:bg-red-100 flex items-center justify-center transition-colors">
                                        <svg class="w-4 h-4 text-red-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M3 6h18M8 6V4h8v2M19 6l-1 14H6L5 6" stroke-linecap="round" stroke-linejoin="round"/></svg>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="py-16 text-center">
                                <div class="w-12 h-12 rounded-xl bg-gray-50 flex items-center justify-center mx-auto mb-3">
                                    <svg class="w-6 h-6 text-gray-300" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><circle cx="12" cy="8" r="4"/><path d="M4 20c0-4 3.6-7 8-7s8 3 8 7"/></svg>
                                </div>
                                <p class="text-gray-400 text-sm font-medium">Tidak ada pengguna ditemukan.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Mobile Card View -->
        <div class="md:hidden divide-y divide-gray-100">
            @forelse($pengguna as $i => $user)
                <div class="p-4 hover:bg-gray-50 transition-colors">
                    <div class="flex items-start justify-between mb-3">
                        <div class="flex-1">
                            <p class="text-xs text-gray-500 mb-1">Username</p>
                            <p class="font-bold text-gray-800 text-sm">{{ $user->username }}</p>
                        </div>
                        <span class="px-2.5 py-1 bg-primary/10 text-primary text-xs font-semibold rounded-lg whitespace-nowrap ml-2">
                            {{ $user->jabatan ?? 'Staff' }}
                        </span>
                    </div>

                    <div class="mb-3">
                        <p class="text-xs text-gray-500 mb-1">Nama Lengkap</p>
                        <p class="text-sm text-gray-700">{{ $user->nama }}</p>
                    </div>

                    <div class="mb-3">
                        <div class="flex items-center gap-2 text-sm text-gray-600">
                            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75"/>
                            </svg>
                            <span>{{ $user->email }}</span>
                        </div>
                    </div>

                    <div class="mb-4 text-xs text-gray-500">
                        <p>Dibuat: {{ $user->created_at?->format('d/m/Y H:i') ?? '-' }}</p>
                        <p>Login terakhir: {{ $user->last_login_at ? $user->last_login_at->format('d/m/Y H:i') : 'Belum login' }}</p>
                    </div>

                    <div class="flex gap-2">
                        <button wire:click="openEditModal({{ $user->id }})"
                            class="flex-1 flex items-center justify-center gap-2 px-3 py-2.5 bg-amber-50 hover:bg-amber-100 text-amber-600 text-sm font-semibold rounded-lg transition-colors">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5"/>
                                <path d="M17.586 3.586a2 2 0 012.828 2.828L12 15l-4 1 1-4 8.586-8.414z"/>
                            </svg>
                            Edit
                        </button>
                        <button wire:click="openDelete({{ $user->id }})"
                            class="px-3 py-2.5 bg-red-50 hover:bg-red-100 text-red-600 rounded-lg transition-colors">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path d="M3 6h18M8 6V4h8v2M19 6l-1 14H6L5 6" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                        </button>
                    </div>
                </div>
            @empty
                <div class="py-16 text-center">
                    <div class="w-12 h-12 rounded-xl bg-gray-50 flex items-center justify-center mx-auto mb-3">
                        <svg class="w-6 h-6 text-gray-300" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><circle cx="12" cy="8" r="4"/><path d="M4 20c0-4 3.6-7 8-7s8 3 8 7"/></svg>
                    </div>
                    <p class="text-gray-400 text-sm font-medium">Tidak ada pengguna ditemukan.</p>
                </div>
            @endforelse
        </div>

        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-3 px-4 md:px-6 py-4 border-t border-gray-100">
            <p class="text-sm text-gray-500 text-center md:text-left">
                @if($pengguna->total() > 0)
                    Menampilkan <span class="font-semibold text-gray-700">{{ $pengguna->firstItem() }}</span>–<span class="font-semibold text-gray-700">{{ $pengguna->lastItem() }}</span> dari <span class="font-semibold text-gray-700">{{ $pengguna->total() }}</span> data
                @else Menampilkan <b>0</b> data @endif
            </p>
            <div class="flex items-center justify-center gap-1">{{ $pengguna->links('vendor.pagination.simple-tailwind') }}</div>
        </div>
    </div>
</div>

@if($showModal)
<div class="fixed inset-0 bg-black/40 backdrop-blur-sm z-50 flex items-center justify-center p-4">
    <div class="bg-white rounded-2xl shadow-2xl w-full max-w-md">
        <div class="flex items-center justify-between px-6 py-4 border-b border-gray-100">
            <div class="flex items-center gap-3">
                <div class="w-9 h-9 rounded-xl bg-primary/10 flex items-center justify-center">
                    <svg class="w-5 h-5 text-primary" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="8" r="4"/><path d="M4 20c0-4 3.6-7 8-7s8 3 8 7"/></svg>
                </div>
                <h3 class="font-bold text-gray-800">{{ $editId ? 'Edit' : 'Tambah' }} Pengguna</h3>
            </div>
            <button wire:click="closeModal" class="w-8 h-8 flex items-center justify-center rounded-lg hover:bg-gray-100 text-gray-400">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>
        <div class="px-6 py-5 space-y-4">
            <!-- Username - Readonly saat edit -->
            <div>
                <label class="block text-xs font-semibold text-gray-600 mb-1.5">Username <span class="text-red-400">*</span></label>
                <input type="text" wire:model="username" placeholder="Contoh: barbarapalvin"
                    {{ $editId ? 'readonly' : '' }}
                    class="w-full px-3 py-2.5 text-sm border rounded-xl focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary transition-all 
                    {{ $editId ? 'bg-gray-50 text-gray-500 cursor-not-allowed' : '' }}
                    @error('username') border-red-400 @enderror">
                @error('username') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
            </div>
            
            <!-- Nama -->
            <div>
                <label class="block text-xs font-semibold text-gray-600 mb-1.5">Nama Lengkap <span class="text-red-400">*</span></label>
                <input type="text" wire:model="nama" placeholder="Nama lengkap pengguna"
                    class="w-full px-3 py-2.5 text-sm border rounded-xl focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary transition-all @error('nama') border-red-400 @enderror">
                @error('nama') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
            </div>
            
            <!-- Jabatan -->
            <div>
                <label class="block text-xs font-semibold text-gray-600 mb-1.5">Jabatan</label>
                <input type="text" wire:model="jabatan" placeholder="Contoh: Kepala Desa, Sekretaris"
                    class="w-full px-3 py-2.5 text-sm border rounded-xl focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary transition-all">
            </div>
            
            <!-- Email -->
            <div>
                <label class="block text-xs font-semibold text-gray-600 mb-1.5">Email <span class="text-red-400">*</span></label>
                <input type="email" wire:model="email" placeholder="contoh: email@domain.com"
                    class="w-full px-3 py-2.5 text-sm border rounded-xl focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary transition-all @error('email') border-red-400 @enderror">
                @error('email') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
            </div>
            
            <!-- Password & Konfirmasi - Hanya muncul saat tambah -->
            @if(!$editId)
            <div>
                <label class="block text-xs font-semibold text-gray-600 mb-1.5">Password <span class="text-red-400">*</span></label>
                <input type="password" wire:model="password" placeholder="Minimal 8 karakter"
                    class="w-full px-3 py-2.5 text-sm border rounded-xl focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary transition-all @error('password') border-red-400 @enderror">
                @error('password') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
            </div>
            <div>
                <label class="block text-xs font-semibold text-gray-600 mb-1.5">Konfirmasi Password <span class="text-red-400">*</span></label>
                <input type="password" wire:model="password_confirmation" placeholder="Ulangi password"
                    class="w-full px-3 py-2.5 text-sm border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary transition-all">
            </div>
            @endif
        </div>
        <div class="flex items-center justify-end gap-3 px-6 py-4 border-t border-gray-100">
            <button wire:click="closeModal" class="px-5 py-2.5 text-sm font-semibold text-gray-600 hover:bg-gray-100 rounded-xl transition-colors">Batal</button>
            <button wire:click="save" wire:loading.attr="disabled" class="px-5 py-2.5 text-sm font-semibold bg-primary hover:bg-primary-dark text-white rounded-xl transition-colors shadow-sm">
                <span wire:loading.remove wire:target="save">Simpan</span>
                <span wire:loading wire:target="save">Menyimpan...</span>
            </button>
        </div>
    </div>
</div>
@endif

@if($showDelete)
<div class="fixed inset-0 bg-black/40 backdrop-blur-sm z-50 flex items-center justify-center p-4">
    <div class="bg-white rounded-2xl shadow-2xl w-full max-w-sm p-6 text-center">
        <div class="w-14 h-14 rounded-full bg-red-50 flex items-center justify-center mx-auto mb-4">
            <svg class="w-7 h-7 text-red-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M3 6h18M8 6V4h8v2M19 6l-1 14H6L5 6" stroke-linecap="round" stroke-linejoin="round"/></svg>
        </div>
        <h3 class="font-bold text-gray-800 mb-1">Hapus Pengguna?</h3>
        <p class="text-sm text-gray-500 mb-6">Akun akan dihapus secara permanen. Tindakan ini tidak dapat dibatalkan.</p>
        <div class="flex gap-3">
            <button wire:click="closeDelete" class="flex-1 py-2.5 text-sm font-semibold text-gray-600 bg-gray-100 hover:bg-gray-200 rounded-xl transition-colors">Batal</button>
            <button wire:click="confirmDelete" class="flex-1 py-2.5 text-sm font-semibold bg-red-500 hover:bg-red-600 text-white rounded-xl transition-colors">Hapus</button>
        </div>
    </div>
</div>
@endif
</div>