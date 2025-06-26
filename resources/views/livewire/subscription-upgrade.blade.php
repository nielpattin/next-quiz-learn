<div>
    @if ($user && $user->subscription === 'Pro+')
        <div class="text-[var(--foreground)] font-semibold mb-2">You are already a Pro+ user.</div>
    @elseif ($user && $user->subscription === 'Pro')
        <button
            wire:click="upgrade('Pro+')"
            class="inline-block px-6 py-2 rounded bg-[var(--color-primary)] text-[var(--button-primary-foreground)] hover:bg-[var(--color-tertiary)] transition font-semibold"
        >
            Upgrade to Pro+ ({{ $upgradeCostProPlus }} credits)
        </button>
        <div class="mt-2 text-[var(--foreground)] text-sm">Your credits: {{ $user->credit }}</div>
        <div class="mt-2 text-[var(--foreground)] text-sm">Current subscription: Pro</div>
    @else
        <button
            wire:click="upgrade('Pro')"
            class="inline-block px-6 py-2 rounded bg-[var(--color-primary)] text-[var(--button-primary-foreground)] hover:bg-[var(--color-tertiary)] transition font-semibold"
        >
            Upgrade to Pro ({{ $upgradeCostPro }} credits)
        </button>
        <button
            wire:click="upgrade('Pro+')"
            class="inline-block px-6 py-2 rounded bg-[var(--color-primary)] text-[var(--button-primary-foreground)] hover:bg-[var(--color-tertiary)] transition font-semibold ml-2"
        >
            Upgrade to Pro+ ({{ $upgradeCostProPlus }} credits)
        </button>
        <div class="mt-2 text-[var(--foreground)] text-sm">Your credits: {{ $user->credit }}</div>
        <div class="mt-2 text-[var(--foreground)] text-sm">Current subscription: {{ $user->subscription ?? 'Free' }}</div>
    @endif
</div>
