<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Browsershot\Browsershot;

class KuitansiController extends Controller
{
    public function preview()
    {
        $items = [
            ['name' => 'Becom-Zet 10 Kaplet', 'qty' => 1, 'price' => 29500],
            ['name' => 'Indexon 0.5 mg 10 Tablet', 'qty' => 1, 'price' => 12100],
            ['name' => 'Sanadryl Expectorant Sirup 120 ml', 'qty' => 1, 'price' => 20100],
        ];

        $subtotal = collect($items)->sum(fn ($i) => $i['qty'] * $i['price']);
        $fee = 18000;
        $total = $subtotal + $fee;

        return view('kuitansi', [
            'customer_name' => 'Yohanes Limbong',
            'npwp'          => '00.000.000.0-0.000',
            'customer_addr' => 'Jl. Taruna 5 No.11, RT.19/RW.3, Serdang, ...',
            'items'         => $items,
            'subtotal'      => $subtotal,
            'fee_label'     => 'Biaya layanan',
            'fee'           => $fee,
            'total'         => $total,
            // dan variable lain (dokter, invoice, dsb)
        ]);
    }

    public function downloadPdf()
    {
        // render blade ke HTML string
        $html = view('kuitansi', $this->dummyData())->render();

        $path = storage_path('app/public/kuitansi-halodoc.pdf');

        Browsershot::html($html)
            ->format('A4')            // ukuran A4 [web:17][web:23]
            ->showBackground()        // supaya warna tabel ikut tercetak [web:17]
            ->margins(12, 12, 12, 12) // top,right,bottom,left (mm kira-kira) [web:17]
            ->save($path);            // simpan file PDF [web:17]

        return response()->download($path)->deleteFileAfterSend();
    }

    private function dummyData(): array
    {
        $items = [
            ['name' => 'Becom-Zet 10 Kaplet', 'qty' => 1, 'price' => 29500],
            ['name' => 'Indexon 0.5 mg 10 Tablet', 'qty' => 1, 'price' => 12100],
            ['name' => 'Sanadryl Expectorant Sirup 120 ml', 'qty' => 1, 'price' => 20100],
        ];

        $subtotal = collect($items)->sum(fn ($i) => $i['qty'] * $i['price']);
        $fee = 18000;
        $total = $subtotal + $fee;

        return [
            'customer_name' => 'Yohanes Limbong',
            'npwp'          => '00.000.000.0-0.000',
            'customer_addr' => 'Jl. Taruna 5 No.11, RT.19/RW.3, Serdang, ...',
            'items'         => $items,
            'subtotal'      => $subtotal,
            'fee_label'     => 'Biaya layanan',
            'fee'           => $fee,
            'total'         => $total,
            // tambahkan semua field lain yang dipakai di Blade
        ];
    }
}