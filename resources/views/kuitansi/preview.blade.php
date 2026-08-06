<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Preview Kuitansi</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body {
            background: #f3f4f6;
        }
        .paper {
            background: #ffffff;
            box-shadow: 0 10px 25px rgba(0,0,0,.08);
        }
        .border-light {
            border-color: #e5e7eb;
        }
    </style>
</head>
<body class="py-6">
<div class="max-w-4xl mx-auto paper rounded-xl px-10 py-8">
    {{-- HEADER --}}
    <div class="flex justify-between items-start mb-6">
        <div class="flex items-center gap-3">
            <img src="{{ asset('asset/logo.png') }}" alt="Logo" style="height: 32px;">
        </div>
        <div class="text-right">
            <div class="text-sm text-gray-500">KUITANSI</div>
            <div class="text-xs text-gray-400 mt-1">{{ $nomor_kuitansi ?? 'INV/000000/MMXXIII/XXXX' }}</div>
        </div>
    </div>

    {{-- BARIS ATAS: DATA PENERIMA + BOX KANAN --}}
    <div class="grid grid-cols-3 gap-4 mb-6 text-xs">
        <div class="col-span-2 space-y-1">
            <p class="text-gray-500">Terima kasih telah bertransaksi di {{ $company_name ?? 'Halodoc' }}</p>

            <p><span class="font-semibold text-gray-800">{{ $recipient_name ?? '-' }}</span></p>
            <p>NPWP: {{ $recipient_npwp ?? '-' }}</p>
            <p>Alamat:<br>{{ $recipient_address ?? '-' }}</p>

            <p class="mt-2 text-gray-500">Konsultasi dari dokter:</p>
            <p class="font-semibold text-gray-800">{{ $doctor_name ?? '-' }}</p>
            <p class="text-gray-700">{{ $doctor_speciality ?? '-' }}</p>
            <p>Consultation ID : {{ $consultation_id ?? '-' }}</p>
        </div>

        <div class="col-span-1">
            <div class="border border-light rounded-md overflow-hidden">
                <div class="flex border-b border-light">
                    <div class="w-1/2 px-2 py-2 border-r border-light text-gray-500">No pesanan</div>
                    <div class="w-1/2 px-2 py-2 text-right">{{ $nomor_kuitansi ?? '-' }}</div>
                </div>
                <div class="flex border-b border-light">
                    <div class="w-1/2 px-2 py-2 border-r border-light text-gray-500">Tanggal transaksi</div>
                    <div class="w-1/2 px-2 py-2 text-right">
                        {{ \Carbon\Carbon::now()->format('d F Y') }}
                    </div>
                </div>
                <div class="flex">
                    <div class="w-1/2 px-2 py-2 border-r border-light text-gray-500">Metode pembayaran</div>
                    <div class="w-1/2 px-2 py-2 text-right">{{ $metode_pembayaran ?? 'Wallet' }}</div>
                </div>
            </div>
        </div>
    </div>

    <hr class="border-light my-6">

    {{-- DESKRIPSI KIRIMAN --}}
    <div class="grid grid-cols-2 gap-4 text-xs mb-6">
        <div>
            <p class="font-semibold text-gray-800 mb-1">Deskripsi kiriman</p>
            <p class="text-gray-500">Nama apotik/toko:</p>
            <p class="font-semibold text-gray-800">{{ $pharmacy_name ?? '-' }}</p>
            <p class="text-gray-700">{{ $pharmacy_sia ?? '-' }}</p>
            <p class="mt-2 text-gray-500">Alamat:</p>
            <p class="text-gray-700">{{ $pharmacy_address ?? '-' }}</p>
            <p class="mt-1 text-gray-700">{{ $pharmacy_phone ?? '-' }}</p>
        </div>
        <div class="text-right text-gray-500">
            <p>Delivered on {{ \Carbon\Carbon::now()->format('d F Y') }}</p>
            <p class="mt-1">ID Kiriman {{ $id_kiriman ?? '-' }}</p>
        </div>
    </div>

    {{-- TABEL PRODUK --}}
    <div class="mt-2 text-xs">
        <table class="w-full border-collapse">
            <thead>
                <tr class="border-y border-light bg-gray-50">
                    <th class="text-left py-2 px-2">RINCIAN PRODUK</th>
                    <th class="text-center py-2 px-2" style="width: 60px;">QTY</th>
                    <th class="text-right py-2 px-2" style="width: 120px;">HARGA</th>
                    <th class="text-right py-2 px-2" style="width: 120px;">TOTAL</th>
                </tr>
            </thead>
            <tbody>
                @foreach($items as $item)
                    <tr class="border-b border-light">
                        <td class="py-2 px-2">{{ $item['name'] }}</td>
                        <td class="py-2 px-2 text-center">{{ $item['qty'] }}</td>
                        <td class="py-2 px-2 text-right">{{ rupiah($item['price']) }}</td>
                        <td class="py-2 px-2 text-right">{{ rupiah($item['total']) }}</td>
                    </tr>
                @endforeach

                <tr class="border-b border-light">
                    <td colspan="3" class="py-2 px-2 text-right text-gray-700">Subtotal</td>
                    <td class="py-2 px-2 text-right">{{ rupiah($subtotal) }}</td>
                </tr>
                <tr class="border-b border-light">
                    <td colspan="3" class="py-2 px-2 text-right text-gray-700">Biaya layanan</td>
                    <td class="py-2 px-2 text-right">{{ rupiah($biaya_layanan ?? 0) }}</td>
                </tr>
                <tr class="border-b border-light font-semibold">
                    <td colspan="3" class="py-2 px-2 text-right text-gray-800">Total</td>
                    <td class="py-2 px-2 text-right">{{ rupiah(($subtotal ?? 0) + ($biaya_layanan ?? 0)) }}</td>
                </tr>
            </tbody>
        </table>
    </div>

    {{-- RINGKASAN BAWAH --}}
    <div class="mt-6 text-xs">
        <table class="w-full border-collapse">
            <tbody>
                <tr class="border-b border-light">
                    <td class="py-2 px-2 text-left">Subtotal akhir</td>
                    <td class="py-2 px-2 text-right">{{ rupiah($subtotal) }}</td>
                </tr>
                <tr class="border-b border-light font-semibold">
                    <td class="py-2 px-2 text-left">GRAND TOTAL DIBAYARKAN PASIEN</td>
                    <td class="py-2 px-2 text-right">{{ rupiah($grand_total) }}</td>
                </tr>
            </tbody>
        </table>
    </div>

    {{-- FOOTER --}}
    <div class="mt-8 text-center text-xs text-gray-500">
        Butuh bantuan? Hubungi kami di <span class="text-pink-500">{{ $help_contact ?? 'help@halodoc.com' }}</span>
    </div>
</div>
</body>
</html>