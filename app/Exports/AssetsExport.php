<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class AssetsExport implements FromView
{
    protected $assets;

    public function __construct($assets)
    {
        $this->assets = $assets;
    }

    public function view(): View
    {
        return view('reports.export_excel', [
            'assets' => $this->assets
        ]);
    }
} 