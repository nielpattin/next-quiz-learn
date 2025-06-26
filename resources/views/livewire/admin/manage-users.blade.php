<div class="max-w-5xl mx-auto p-8">
    <h1 class="text-3xl font-bold mb-8 text-[var(--foreground)]">User Management</h1>
    <div class="overflow-x-auto rounded-lg shadow border border-[var(--border-color)] bg-[var(--background)]">
        <table class="min-w-full divide-y divide-[var(--border-color)]">
            <thead class="bg-[var(--card-background)]">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-[var(--foreground)] uppercase tracking-wider">Name</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-[var(--foreground)] uppercase tracking-wider">Email</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-[var(--foreground)] uppercase tracking-wider">Role</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-[var(--foreground)] uppercase tracking-wider">Subscription</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-[var(--foreground)] uppercase tracking-wider">Credit</th>
                    <th class="px-6 py-3"></th>
                </tr>
            </thead>
            <tbody class="bg-[var(--background)] divide-y divide-[var(--border-color)]">
                @foreach ($users as $user)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap text-[var(--foreground)] font-semibold">{{ $user->name }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-[var(--foreground)]">{{ $user->email }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @if ($editId === $user->id)
                                <select wire:model.defer="editRole" class="border rounded px-2 py-1 bg-[var(--input-background)] text-[var(--foreground)]">
                                    <option value="user">User</option>
                                    <option value="admin">Admin</option>
                                </select>
                            @else
                                <span class="inline-block px-2 py-1 rounded bg-[var(--color-tertiary)] text-xs font-medium">{{ ucfirst($user->role) }}</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @if ($editId === $user->id)
                                <select wire:model.defer="editSubscription" class="border rounded px-2 py-1 bg-[var(--input-background)] text-[var(--foreground)]">
                                    <option value="Free">Free</option>
                                    <option value="Pro">Pro</option>
                                    <option value="Pro+">Pro+</option>
                                </select>
                            @else
                                <span class="inline-block px-2 py-1 rounded bg-[var(--color-primary)] text-xs font-medium text-[var(--button-primary-foreground)]">{{ $user->subscription ?? 'Free' }}</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @if ($editId === $user->id)
                                <input type="number" wire:model.defer="editCredit" class="border rounded px-2 py-1 w-24 bg-[var(--input-background)] text-[var(--foreground)]" min="0">
                            @else
                                <span class="inline-block px-2 py-1 rounded bg-[var(--card-background)] text-xs font-mono">{{ $user->credit }}</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @if ($editId === $user->id)
                                <button wire:click="saveEdit" class="px-4 py-2 bg-[var(--color-primary)] text-[var(--button-primary-foreground)] rounded shadow mr-2 hover:bg-[var(--color-tertiary)] transition">Save</button>
                                <button wire:click="cancelEdit" class="px-4 py-2 bg-[var(--color-tertiary)] text-[var(--foreground)] rounded shadow hover:bg-[var(--color-primary)] transition">Cancel</button>
                            @else
                                <button wire:click="startEdit({{ $user->id }})" class="px-4 py-2 bg-[var(--color-primary)] text-[var(--button-primary-foreground)] rounded shadow hover:bg-[var(--color-tertiary)] transition">Edit</button>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
