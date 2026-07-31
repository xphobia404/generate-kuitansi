<?php

namespace App\Http\Controllers;

use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App\Models\KuitansiSequence;

class KuitansiController extends Controller
{
    public function create()
    {
        return view('kuitansi.create');
    }

    public function generatePdf(Request $request)
    {
        $data = $this->prepareData($request);

        $pdf = Pdf::loadView('kuitansi.pdf', $data)->setPaper('a4', 'portrait');

        $filename = 'kuitansi-' . $data['nomor_kuitansi'] . '.pdf';
        $path = 'kuitansi/' . $filename;

        Storage::disk('public')->put($path, $pdf->output());

        return response()->download(storage_path('app/public/' . $path));
    }

    private function prepareData(Request $request): array
    {
        $validated = $request->validate([
            'company_name' => ['nullable', 'string', 'max:255'],
            'recipient_name' => ['required', 'string', 'max:255'],
            'recipient_npwp' => ['nullable', 'string', 'max:255'],
            'recipient_address' => ['nullable', 'string'],
            'doctor_name' => ['nullable', 'string', 'max:255'],
            'doctor_speciality' => ['nullable', 'string', 'max:255'],
            'consultation_id' => ['nullable', 'string', 'max:255'],
            'pharmacy_name' => ['nullable', 'string', 'max:255'],
            'pharmacy_sia' => ['nullable', 'string', 'max:255'],
            'pharmacy_address' => ['nullable', 'string'],
            'pharmacy_phone' => ['nullable', 'string', 'max:50'],
            'help_contact' => ['nullable', 'string', 'max:255'],
            'metode_pembayaran' => ['nullable', 'string', 'max:100'],
            'id_kiriman' => ['nullable', 'string', 'max:255'],
            'biaya_layanan' => ['nullable', 'numeric', 'min:0'],
            'items' => ['nullable', 'array'],
            'items.*.name' => ['required_with:items', 'string', 'max:255'],
            'items.*.qty' => ['required_with:items', 'numeric', 'min:1'],
            'items.*.price' => ['required_with:items', 'numeric', 'min:0'],
        ]);

        $items = collect($validated['items'] ?? [])
            ->map(function ($item) {
                $qty = (int) ($item['qty'] ?? 0);
                $price = (float) ($item['price'] ?? 0);

                return [
                    'name' => $item['name'] ?? '',
                    'qty' => $qty,
                    'price' => $price,
                    'total' => $qty * $price,
                ];
            })
            ->values()
            ->all();

        $subtotal = collect($items)->sum('total');
        $biayaLayanan = (float) ($validated['biaya_layanan'] ?? 0);
        $grandTotal = $subtotal + $biayaLayanan;

        $companyName = $validated['company_name'] ?? 'Halodoc';

        return array_merge($validated, [
            'company_name' => $companyName,
            'header_note' => 'Terima kasih telah bertransaksi di ' . $companyName,
            'items' => $items,
            'subtotal' => $subtotal,
            'biaya_layanan' => $biayaLayanan,
            'grand_total' => $grandTotal,
            'nomor_kuitansi' => $this->generateNomorKuitansi(),
            'terbilang_total' => ucfirst(trim(terbilang($grandTotal))) . ' rupiah',
            'help_contact' => $validated['help_contact'] ?? 'help@halodoc.com',
            'metode_pembayaran' => $validated['metode_pembayaran'] ?? 'Wallet',
        ]);
    }

    private function generateNomorKuitansi(): string
    {
        $date = now()->format('dmY');
        $yearRoman = $this->toRoman((int) now()->format('Y'));
        $period = now()->format('Ymd');

        return DB::transaction(function () use ($date, $yearRoman, $period) {
            $sequence = KuitansiSequence::where('period', $period)
                ->lockForUpdate()
                ->first();

            if (! $sequence) {
                $sequence = KuitansiSequence::create([
                    'period' => $period,
                    'last_number' => 0,
                ]);
                $sequence->refresh();
            }

            $sequence->increment('last_number');

            $serial = str_pad($sequence->last_number, 4, '0', STR_PAD_LEFT);

            return "INV/{$date}/{$yearRoman}/{$serial}";
        });
    }

    private function toRoman(int $number): string
    {
        $map = [
            1000 => 'M', 900 => 'CM', 500 => 'D', 400 => 'CD',
            100 => 'C', 90 => 'XC', 50 => 'L', 40 => 'XL',
            10 => 'X', 9 => 'IX', 5 => 'V', 4 => 'IV', 1 => 'I',
        ];

        $result = '';

        foreach ($map as $value => $roman) {
            while ($number >= $value) {
                $result .= $roman;
                $number -= $value;
            }
        }

        return $result;
    }
}