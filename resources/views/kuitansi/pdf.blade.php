<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Kuitansi</title>
    <style>
        @page {
            margin: 28px 34px 24px 34px;
        }

        body {
            font-family: DejaVu Sans, Arial, sans-serif;
            font-size: 10.5px;
            color: #444;
            line-height: 1.25;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        .top-table td {
            vertical-align: top;
        }

        .logo {
            height: 30px;
        }

        .title {
            font-size: 16px;
            font-weight: 700;
            color: #4b4b4b;
            text-align: right;
            padding-top: 4px;
        }

        .muted {
            color: #7a7a7a;
        }

        .section-title {
            font-size: 12px;
            font-weight: 700;
            color: #4b4b4b;
        }

        .divider {
            border-top: 1px solid #e5e5e5;
            margin: 16px 0 14px 0;
        }

        .box {
            border: 1px solid #ddd;
            border-radius: 4px;
        }

        .box td {
            padding: 8px 10px;
            border-bottom: 1px solid #e5e5e5;
        }

        .box tr:last-child td {
            border-bottom: none;
        }

        .label {
            color: #707070;
        }

        .value {
            text-align: right;
            color: #555;
        }

        .invoice-code {
            text-align: right;
            font-size: 10px;
            font-weight: 700;
            letter-spacing: 0.2px;
            color: #555;
            margin-bottom: 8px;
        }

        .product-table th,
        .product-table td {
            border: 1px solid #e5e5e5;
            padding: 7px 10px;
        }

        .product-table th {
            background: #fafafa;
            color: #666;
            font-size: 10px;
            font-weight: 700;
            text-align: center;
        }

        .product-table td {
            font-size: 10px;
            color: #555;
        }

        .right {
            text-align: right;
        }

        .center {
            text-align: center;
        }

        .summary-table td {
            border: 1px solid #e5e5e5;
            padding: 8px 10px;
            font-size: 10px;
        }

        .footer {
            margin-top: 16px;
            padding-top: 10px;
            border-top: 1px solid #e5e5e5;
            text-align: center;
            font-size: 11px;
            color: #666;
        }

        .pink {
            color: #e91e63;
        }

        .small {
            font-size: 9.5px;
        }

        .bold {
            font-weight: 700;
        }

        .spacer-8 { height: 8px; }
        .spacer-10 { height: 10px; }
        .spacer-12 { height: 12px; }
        .spacer-14 { height: 14px; }
    </style>
</head>
<body>

<table class="top-table">
    <tr>
        <td style="width: 50%;">
            <img src="{{ public_path('asset/logo.png') }}" class="logo" alt="Logo">
        </td>
        <td style="width: 50%;" class="title">KUITANSI</td>
    </tr>
</table>

<div class="divider"></div>

<table>
    <tr>
        <td style="width: 62%; vertical-align: top; padding-right: 18px;">
            <div class="small muted">Terima kasih telah bertransaksi di Halodoc,</div>
            <div style="font-size: 14px; font-weight: 700; color: #4b4b4b;">{{ $recipient_name ?? '-' }}</div>
            <div class="small muted">NPWP: {{ $recipient_npwp ?? '-' }}</div>

            <div class="spacer-8"></div>

            <div class="small bold" style="color:#666;">Alamat:</div>
            <div style="white-space: pre-line;">{{ $recipient_address ?? '-' }}</div>

            <div class="spacer-8"></div>

            <div class="small muted">Konsultasi dari dokter :</div>
            <div style="font-size: 13px; font-weight: 700; color: #4b4b4b;">{{ $doctor_name ?? '-' }}</div>
            <div>{{ $doctor_speciality ?? '-' }}</div>
            <div class="small"><span class="bold">Consultation ID</span> . {{ $consultation_id ?? '-' }}</div>
        </td>

        <td style="width: 38%; vertical-align: top;">
            <div class="invoice-code">{{ $nomor_kuitansi ?? '-' }}</div>
            <table class="box">
                <tr>
                    <td class="label" style="width: 55%;">No pesanan</td>
                    <td class="value">{{ $id_pesanan ?? $id_kiriman ?? '-' }}</td>
                </tr>
                <tr>
                    <td class="label">Tanggal transaksi</td>
                    <td class="value">{{ $tanggal_transaksi ?? now()->format('d F Y') }}</td>
                </tr>
                <tr>
                    <td class="label">Metode pembayaran</td>
                    <td class="value">{{ $metode_pembayaran ?? 'Wallet' }}</td>
                </tr>
            </table>
        </td>
    </tr>
</table>

<div class="spacer-14"></div>
<div class="divider"></div>
<div class="spacer-10"></div>

<table>
    <tr>
        <td style="width: 62%; vertical-align: top; padding-right: 18px;">
            <div class="section-title">Deskripsi kiriman</div>
            <div class="spacer-8"></div>

            <div class="small muted">Nama apotik/toko:</div>
            <div style="font-size: 13px; font-weight: 700; color: #4b4b4b;">{{ $pharmacy_name ?? '-' }}</div>
            <div class="small muted">SIA: {{ $pharmacy_sia ?? '-' }}</div>

            <div class="spacer-8"></div>

            <div class="small muted">Alamat:</div>
            <div style="white-space: pre-line;">{{ $pharmacy_address ?? '-' }}</div>
            <div>{{ $pharmacy_phone ?? '-' }}</div>
        </td>

        <td style="width: 38%; vertical-align: top;">
            <table>
                <tr>
                    <td class="right small bold" style="color:#666; width: 55%;">Delivered on</td>
                    <td class="small" style="color:#666;">{{ $tanggal_transaksi ?? now()->format('d F Y') }}</td>
                </tr>
                <tr>
                    <td class="right small bold" style="color:#666;">ID Kiriman</td>
                    <td class="small" style="color:#666;">{{ $id_kiriman ?? '-' }}</td>
                </tr>
            </table>
        </td>
    </tr>
</table>

<div class="spacer-12"></div>

<table class="product-table">
    <thead>
        <tr>
            <th style="width: 54%; text-align:left; padding-left: 18px;">RINCIAN PRODUK</th>
            <th style="width: 10%;">QTY</th>
            <th style="width: 18%;">HARGA</th>
            <th style="width: 18%;">TOTAL</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($items as $item)
            <tr>
                <td style="padding-left: 18px;">{{ $item['name'] ?? '-' }}</td>
                <td class="center">{{ $item['qty'] ?? 0 }}</td>
                <td class="right">{{ number_format($item['price'] ?? 0, 2, '.', ',') }}</td>
                <td class="right">{{ number_format($item['total'] ?? 0, 2, '.', ',') }}</td>
            </tr>
        @endforeach

        <tr>
            <td colspan="2" style="border-right: none; border-left: none; border-bottom: none;"></td>
            <td class="right" style="border-right: none;">Subtotal</td>
            <td class="right">{{ number_format($subtotal ?? 0, 2, '.', ',') }}</td>
        </tr>
        <tr>
            <td colspan="2" style="border-right: none; border-left: none; border-bottom: none;"></td>
            <td class="right" style="border-right: none;">Biaya layanan</td>
            <td class="right">{{ number_format($biaya_layanan ?? 0, 2, '.', ',') }}</td>
        </tr>
        <tr>
            <td colspan="2" style="border-right: none; border-left: none; border-bottom: none;"></td>
            <td class="right bold" style="border-right: none;">Total</td>
            <td class="right">{{ rupiah($grand_total ?? 0) }}</td>
        </tr>
    </tbody>
</table>

<div class="spacer-12"></div>

<table class="summary-table">
    <tr>
        <td style="width: 82%; text-align: center; border-right: none;" class="muted">Subtotal akhir</td>
        <td class="right" style="width: 18%;">{{ number_format($subtotal ?? 0, 2, '.', ',') }}</td>
    </tr>
    <tr style="background:#f8f8f8;">
        <td style="text-align: center; border-right: none;" class="bold">GRAND TOTAL DIBAYARKAN PASIEN</td>
        <td class="right bold">{{ rupiah($grand_total ?? 0) }}</td>
    </tr>
</table>

<div class="footer">
    Butuh bantuan? Hubungi kami di <span class="pink">{{ $help_contact ?? 'help@halodoc.com' }}</span>
</div>

</body>
</html>