<?php

namespace App\Livewire;

use Livewire\Component;

use Illuminate\Support\Facades\Auth;

class SubscriptionUpgrade extends Component
{
    public $upgradeCostPro = 10;
    public $upgradeCostProPlus = 25;

    public function upgrade($type = 'Pro')
    {
        $user = Auth::user();
        if (!$user) {
            $this->dispatch('toast', message: 'You must be logged in.', type: 'error');
            return;
        }

        if ($type === 'Pro') {
            if ($user->subscription === 'Pro' || $user->subscription === 'Pro+') {
                $this->dispatch('toast', message: 'You already have Pro or higher.', type: 'info');
                return;
            }
            if ($user->credit < $this->upgradeCostPro) {
                $this->dispatch('toast', message: 'Not enough credits to upgrade to Pro.', type: 'error');
                return;
            }
            $user->credit -= $this->upgradeCostPro;
            $user->subscription = 'Pro';
            $user->save();
            $this->dispatch('toast', message: 'Subscription upgraded to Pro!', type: 'success');
        } elseif ($type === 'Pro+') {
            if ($user->subscription === 'Pro+') {
                $this->dispatch('toast', message: 'You already have Pro+.', type: 'info');
                return;
            }
            if ($user->credit < $this->upgradeCostProPlus) {
                $this->dispatch('toast', message: 'Not enough credits to upgrade to Pro+.', type: 'error');
                return;
            }
            $user->credit -= $this->upgradeCostProPlus;
            $user->subscription = 'Pro+';
            $user->save();
            $this->dispatch('toast', message: 'Subscription upgraded to Pro+!', type: 'success');
        }
        $this->dispatch('$refresh');
    }

    public function render()
    {
        return view('livewire.subscription-upgrade', [
            'user' => Auth::user(),
            'upgradeCostPro' => $this->upgradeCostPro,
            'upgradeCostProPlus' => $this->upgradeCostProPlus,
        ]);
    }
}
