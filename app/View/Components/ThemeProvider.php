<?php

namespace App\View\Components;

use Illuminate\View\Component;

class ThemeProvider extends Component
{
    public $theme;
    public $darkMode;
    public $themeColors;

    /**
     * Create a new component instance.
     */
    public function __construct()
    {
        // Get theme from session or use default
        $this->theme = session('admin_theme', 'orange');
        $this->darkMode = session('admin_dark_mode', false);
        
        // Define theme colors
        $themes = [
            'orange' => [
                'primary' => '#f05a28',
                'primary_dark' => '#d94a1c',
                'primary_light' => '#fff7ed',
                'secondary' => '#ff8c42'
            ],
            'blue' => [
                'primary' => '#2563eb',
                'primary_dark' => '#1e40af',
                'primary_light' => '#dbeafe',
                'secondary' => '#3b82f6'
            ],
            'green' => [
                'primary' => '#16a34a',
                'primary_dark' => '#15803d',
                'primary_light' => '#dcfce7',
                'secondary' => '#22c55e'
            ],
            'purple' => [
                'primary' => '#9333ea',
                'primary_dark' => '#7e22ce',
                'primary_light' => '#f3e8ff',
                'secondary' => '#a855f7'
            ],
            'red' => [
                'primary' => '#dc2626',
                'primary_dark' => '#b91c1c',
                'primary_light' => '#fee2e2',
                'secondary' => '#ef4444'
            ],
            'monochrome' => [
                'primary' => '#374151',
                'primary_dark' => '#1f2937',
                'primary_light' => '#f3f4f6',
                'secondary' => '#6b7280'
            ]
        ];

        $this->themeColors = $themes[$this->theme] ?? $themes['orange'];
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render()
    {
        return view('components.theme-provider');
    }
}
