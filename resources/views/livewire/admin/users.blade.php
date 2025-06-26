<div>
    <h1 class="text-2xl font-bold mb-4 text-zinc-100">Manajemen Pengguna</h1>
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-4 gap-2">
        <input type="text" wire:model.live.debounce.500ms="search" placeholder="Cari pengguna..." class="w-full sm:w-64 border border-zinc-700 bg-zinc-900 text-zinc-100 rounded px-3 py-2" />
        <select wire:model="perPage" class="w-full sm:w-32 border border-zinc-700 bg-zinc-900 text-zinc-100 rounded px-3 py-2">
            <option value="5">5</option>
            <option value="10">10</option>
            <option value="25">25</option>
            <option value="50">50</option>
        </select>
    </div>
    @if ($errors->any())
        <div class="mb-4 p-2 bg-zinc-800 text-pink-200 rounded">
            <ul class="list-disc pl-5">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <form wire:submit.prevent="{{ $isEdit ? 'update' : 'store' }}" class="mb-6 space-y-3">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label class="block mb-1 font-semibold text-zinc-200">Nama</label>
                <input type="text" wire:model.defer="name" class="w-full border border-zinc-700 bg-zinc-900 text-zinc-100 rounded px-3 py-2" required>
            </div>
            <div>
                <label class="block mb-1 font-semibold text-zinc-200">Email</label>
                <input type="email" wire:model.defer="email" class="w-full border border-zinc-700 bg-zinc-900 text-zinc-100 rounded px-3 py-2" required>
            </div>
            <div>
                <label class="block mb-1 font-semibold text-zinc-200">Role</label>
                <select wire:model.defer="role" class="w-full border border-zinc-700 bg-zinc-900 text-zinc-100 rounded px-3 py-2">
                    <option value="admin">Admin</option>
                    <option value="customer">Customer</option>
                </select>
            </div>
            <div>
                <label class="block mb-1 font-semibold text-zinc-200">Telepon</label>
                <input type="text" wire:model.defer="phone" class="w-full border border-zinc-700 bg-zinc-900 text-zinc-100 rounded px-3 py-2">
            </div>
        </div>
        <div>
            <label class="block mb-1 font-semibold text-zinc-200">Alamat</label>
            <textarea wire:model.defer="address" class="w-full border border-zinc-700 bg-zinc-900 text-zinc-100 rounded px-3 py-2"></textarea>
        </div>
        @if(!$isEdit)
        <div>
            <label class="block mb-1 font-semibold text-zinc-200">Password</label>
            <input type="password" wire:model.defer="password" class="w-full border border-zinc-700 bg-zinc-900 text-zinc-100 rounded px-3 py-2" required>
        </div>
        @endif
        <div>
            <button type="submit" class="bg-zinc-700 text-zinc-100 px-6 py-2 rounded hover:bg-zinc-600 transition">{{ $isEdit ? 'Perbarui' : 'Tambah' }} Pengguna</button>
            @if($isEdit)
                <button type="button" wire:click="resetForm" class="ml-2 px-4 py-2 rounded border border-zinc-700 text-zinc-100">Batal</button>
            @endif
        </div>
    </form>
    <div class="overflow-x-auto">
        <table class="min-w-full bg-zinc-900 border border-zinc-700 rounded">
            <thead>
                <tr class="bg-zinc-800 text-zinc-200">
                    <th class="px-4 py-2">Nama</th>
                    <th class="px-4 py-2">Email</th>
                    <th class="px-4 py-2">Role</th>
                    <th class="px-4 py-2">Telepon</th>
                    <th class="px-4 py-2">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($users as $user)
                    <tr class="border-b border-zinc-800">
                        <td class="border px-4 py-2 border-zinc-800 text-zinc-100">{{ $user->name }}</td>
                        <td class="border px-4 py-2 border-zinc-800 text-zinc-100">{{ $user->email }}</td>
                        <td class="border px-4 py-2 border-zinc-800 text-zinc-100">{{ ucfirst($user->role) }}</td>
                        <td class="border px-4 py-2 border-zinc-800 text-zinc-100">{{ $user->phone }}</td>
                        <td class="border px-4 py-2 border-zinc-800">
                            <button wire:click="edit({{ $user->id }})" class="text-zinc-200 hover:underline mr-2">Edit</button>
                            <button x-data @click.prevent="Swal.fire({title: 'Yakin hapus pengguna ini?',text: 'Tindakan ini tidak dapat dibatalkan.',icon: 'warning',showCancelButton: true,confirmButtonText: 'Hapus',cancelButtonText: 'Batal',reverseButtons: true,}).then((result) => {if (result.isConfirmed) {$wire.delete({{ $user->id }});}});" class="text-zinc-300 hover:underline">Hapus</button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div class="mt-4">
            {{ $users->links() }}
        </div>
    </div>
</div>
