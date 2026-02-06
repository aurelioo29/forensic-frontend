<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class PasswordInput extends Component
{
    public string $name;
    public string $placeholder;
    public bool $confirm;

    // UI options
    public string $variant; // 'dark' | 'light'
    public bool $withLeftIcon;
    public string $label;

    public function __construct(
        string $name = 'password',
        string $placeholder = '••••••••',
        bool $confirm = false,
        string $variant = 'dark',
        bool $withLeftIcon = true,
        string $label = 'Password',
    ) {
        $this->name = $name;
        $this->placeholder = $placeholder;
        $this->confirm = $confirm;
        $this->variant = $variant;
        $this->withLeftIcon = $withLeftIcon;
        $this->label = $label;
    }

    public function render()
    {
        return view('components.password-input');
    }
}
