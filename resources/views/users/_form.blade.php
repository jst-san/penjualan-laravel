@php($user = $user ?? null)

@if ($errors->any())
    <div class="mb-6 rounded-lg border border-rose-200 bg-rose-50 p-4 text-sm text-rose-700">
        <p class="font-semibold">Periksa kembali data yang diisi:</p>
        <ul class="mt-1 list-inside list-disc">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form method="POST" action="{{ $action }}" class="space-y-6">
    @csrf
    @if ($method !== 'POST')
        @method($method)
    @endif

    <div class="rounded-xl border border-slate-200 bg-white p-6 shadow-sm">
        <div class="grid gap-5 sm:grid-cols-2">
            <div>
                <label for="name" class="mb-1.5 block text-sm font-medium text-slate-700">Nama</label>
                <input id="name" name="name" type="text" value="{{ old('name', $user?->name) }}" maxlength="255" required
                    placeholder="Nama lengkap"
                    class="w-full rounded-lg border border-slate-300 px-3.5 py-2.5 text-sm text-slate-900 placeholder-slate-400 shadow-sm outline-none transition focus:border-blue-500 focus:ring-2 focus:ring-blue-500/30">
            </div>

            <div>
                <label for="email" class="mb-1.5 block text-sm font-medium text-slate-700">Email</label>
                <input id="email" name="email" type="email" value="{{ old('email', $user?->email) }}" maxlength="255" required
                    placeholder="nama@example.com"
                    class="w-full rounded-lg border border-slate-300 px-3.5 py-2.5 text-sm text-slate-900 placeholder-slate-400 shadow-sm outline-none transition focus:border-blue-500 focus:ring-2 focus:ring-blue-500/30">
            </div>

            <div>
                <label for="role" class="mb-1.5 block text-sm font-medium text-slate-700">Role</label>
                <select id="role" name="role" required
                    class="w-full rounded-lg border border-slate-300 bg-white px-3.5 py-2.5 text-sm text-slate-900 shadow-sm outline-none transition focus:border-blue-500 focus:ring-2 focus:ring-blue-500/30">
                    @foreach ($roles as $role)
                        <option value="{{ $role }}" @selected(old('role', $user?->role ?? 'karyawan') === $role)>{{ ucfirst($role) }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label for="password" class="mb-1.5 block text-sm font-medium text-slate-700">Password</label>
                <input id="password" name="password" type="password" autocomplete="new-password" @if (! $user) required @endif
                    placeholder="{{ $user ? 'Kosongkan jika tidak diubah' : 'Minimal 8 karakter' }}"
                    class="w-full rounded-lg border border-slate-300 px-3.5 py-2.5 text-sm text-slate-900 placeholder-slate-400 shadow-sm outline-none transition focus:border-blue-500 focus:ring-2 focus:ring-blue-500/30">
            </div>

            <div>
                <label for="password_confirmation" class="mb-1.5 block text-sm font-medium text-slate-700">Konfirmasi Password</label>
                <input id="password_confirmation" name="password_confirmation" type="password" autocomplete="new-password"
                    placeholder="Ulangi password"
                    class="w-full rounded-lg border border-slate-300 px-3.5 py-2.5 text-sm text-slate-900 placeholder-slate-400 shadow-sm outline-none transition focus:border-blue-500 focus:ring-2 focus:ring-blue-500/30">
            </div>
        </div>
    </div>

    <div class="flex items-center justify-end gap-3">
        <a href="{{ route('users.index') }}" class="rounded-lg border border-slate-200 bg-white px-4 py-2.5 text-sm font-semibold text-slate-600 transition hover:bg-slate-50">Batal</a>
        <button type="submit" class="rounded-lg bg-blue-500 px-4 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-blue-600">{{ $submitLabel }}</button>
    </div>
</form>
