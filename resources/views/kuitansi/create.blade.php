<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Generator Kuitansi</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <style>
        [x-cloak] {
            display: none !important;
        }

        .paper {
            background: #fff;
            box-shadow: 0 10px 25px rgba(0, 0, 0, .08);
        }

        .preview-scroll {
            max-height: calc(100vh - 120px);
            overflow: auto;
        }
    </style>
</head>

<body class="bg-gray-100">
    <div class="min-h-screen" x-data="kuitansiApp()" x-init="init()">
        <div class="max-w-[1600px] mx-auto px-4 py-4">
            <div class="mb-4">
                <h1 class="text-2xl font-bold text-gray-800">Generator Kuitansi</h1>
                <p class="text-gray-600">Isi form di kiri, preview akan langsung berubah seperti hasil final.</p>
            </div>

            <div class="grid grid-cols-1 xl:grid-cols-2 gap-4">
                <!-- FORM -->
                <div class="bg-white rounded-xl shadow p-5">
                    <form method="POST" action="{{ route('kuitansi.pdf') }}">
                        @csrf

                        <div class="space-y-5">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Nama Perusahaan</label>
                                    <input type="text" name="company_name" x-model="form.company_name"
                                        class="w-full border rounded-lg px-3 py-2">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">No Kuitansi</label>
                                    <input type="text" x-model="form.nomor_kuitansi"
                                        class="w-full border rounded-lg px-3 py-2" readonly>
                                </div>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Nama Penerima</label>
                                    <input type="text" name="recipient_name" x-model="form.recipient_name"
                                        class="w-full border rounded-lg px-3 py-2">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">NPWP</label>
                                    <input type="text" name="recipient_npwp" x-model="form.recipient_npwp"
                                        class="w-full border rounded-lg px-3 py-2">
                                </div>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Alamat</label>
                                <textarea name="recipient_address" x-model="form.recipient_address" rows="3"
                                    class="w-full border rounded-lg px-3 py-2"></textarea>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Nama Dokter</label>
                                    <input type="text" name="doctor_name" x-model="form.doctor_name"
                                        class="w-full border rounded-lg px-3 py-2">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Spesialis</label>
                                    <input type="text" name="doctor_speciality" x-model="form.doctor_speciality"
                                        class="w-full border rounded-lg px-3 py-2">
                                </div>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Consultation ID</label>
                                    <input type="text" name="consultation_id" x-model="form.consultation_id"
                                        class="w-full border rounded-lg px-3 py-2">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Metode
                                        Pembayaran</label>
                                    <input type="text" name="metode_pembayaran" x-model="form.metode_pembayaran"
                                        class="w-full border rounded-lg px-3 py-2">
                                </div>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Nama Apotek/Toko</label>
                                    <input type="text" name="pharmacy_name" x-model="form.pharmacy_name"
                                        class="w-full border rounded-lg px-3 py-2">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">SIA</label>
                                    <input type="text" name="pharmacy_sia" x-model="form.pharmacy_sia"
                                        class="w-full border rounded-lg px-3 py-2">
                                </div>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Alamat Apotek</label>
                                <textarea name="pharmacy_address" x-model="form.pharmacy_address" rows="3"
                                    class="w-full border rounded-lg px-3 py-2"></textarea>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">ID Kiriman</label>
                                    <input type="text" name="id_kiriman" x-model="form.id_kiriman"
                                        class="w-full border rounded-lg px-3 py-2">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Kontak Bantuan</label>
                                    <input type="text" name="help_contact" x-model="form.help_contact"
                                        class="w-full border rounded-lg px-3 py-2">
                                </div>
                            </div>

                            <div class="border rounded-lg p-4">
                                <div class="flex items-center justify-between mb-3">
                                    <h2 class="font-semibold text-gray-800">Rincian Produk</h2>
                                    <button type="button" @click="addItem()"
                                        class="bg-blue-600 text-white px-3 py-1.5 rounded-lg text-sm">+ Item</button>
                                </div>

                                <template x-for="(item, index) in form.items" :key="index">
                                    <div class="grid grid-cols-12 gap-2 mb-2">
                                        <div class="col-span-5">
                                            <input type="text" :name="`items[${index}][name]`" x-model="item.name"
                                                class="w-full border rounded-lg px-3 py-2" placeholder="Nama produk">
                                        </div>
                                        <div class="col-span-2">
                                            <input type="number" min="1" :name="`items[${index}][qty]`"
                                                x-model.number="item.qty" class="w-full border rounded-lg px-3 py-2"
                                                placeholder="Qty">
                                        </div>
                                        <div class="col-span-4">
                                            <input type="number" min="0" :name="`items[${index}][price]`"
                                                x-model.number="item.price" class="w-full border rounded-lg px-3 py-2"
                                                placeholder="Harga">
                                        </div>
                                        <div class="col-span-1">
                                            <button type="button" @click="removeItem(index)"
                                                class="w-full bg-red-500 text-white rounded-lg px-3 py-2">×</button>
                                        </div>
                                    </div>
                                </template>
                            </div>

                            <div class="flex gap-3 pt-2">
                                <button type="submit"
                                    class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700">
                                    Generate PDF
                                </button>
                            </div>
                        </div>
                    </form>
                </div>

                <!-- PREVIEW -->
                <div class="preview-scroll">
                    <div class="paper rounded-xl px-10 py-8">
                        <div class="flex justify-between items-start mb-6">
                            <div class="flex items-center gap-3">
                                <img src="{{ asset('asset/logo.png') }}" alt="Logo" class="h-8">
                            </div>
                            <div class="text-right">
                                <div class="text-sm text-gray-500">KUITANSI</div>
                                <div class="text-xs text-gray-400 mt-1" x-text="form.nomor_kuitansi"></div>
                            </div>
                        </div>

                        <div class="grid grid-cols-3 gap-4 mb-6 text-xs">
                            <div class="col-span-2 space-y-1">
                                <p class="text-gray-500"
                                    x-text="`Terima kasih telah bertransaksi di ${form.company_name || 'Halodoc'}`">
                                </p>

                                <p><span class="font-semibold text-gray-800"
                                        x-text="form.recipient_name || '-'"></span></p>
                                <p>NPWP: <span x-text="form.recipient_npwp || '-'"></span></p>
                                <p>Alamat:<br><span x-text="form.recipient_address || '-'"></span></p>

                                <p class="mt-2 text-gray-500">Konsultasi dari dokter :</p>
                                <p class="font-semibold text-gray-800" x-text="form.doctor_name || '-'"></p>
                                <p class="text-gray-700" x-text="form.doctor_speciality || '-'"></p>
                                <p>Consultation ID : <span x-text="form.consultation_id || '-'"></span></p>
                            </div>

                            <div class="col-span-1">
                                <div class="border border-gray-200 rounded-md overflow-hidden text-xs">
                                    <div class="flex border-b border-gray-200">
                                        <div class="w-1/2 px-2 py-2 border-r border-gray-200 text-gray-500">No pesanan
                                        </div>
                                        <div class="w-1/2 px-2 py-2 text-right" x-text="form.nomor_kuitansi"></div>
                                    </div>
                                    <div class="flex border-b border-gray-200">
                                        <div class="w-1/2 px-2 py-2 border-r border-gray-200 text-gray-500">Tanggal
                                            transaksi</div>
                                        <div class="w-1/2 px-2 py-2 text-right" x-text="today()"></div>
                                    </div>
                                    <div class="flex">
                                        <div class="w-1/2 px-2 py-2 border-r border-gray-200 text-gray-500">Metode
                                            pembayaran</div>
                                        <div class="w-1/2 px-2 py-2 text-right"
                                            x-text="form.metode_pembayaran || '-'"></div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <hr class="border-gray-200 my-6">

                        <div class="grid grid-cols-2 gap-4 text-xs mb-6">
                            <div>
                                <p class="font-semibold text-gray-800 mb-1">Deskripsi kiriman</p>
                                <p class="text-gray-500">Nama apotik/toko:</p>
                                <p class="font-semibold text-gray-800" x-text="form.pharmacy_name || '-'"></p>
                                <p class="text-gray-700" x-text="form.pharmacy_sia || '-'"></p>
                                <p class="mt-2 text-gray-500">Alamat:</p>
                                <p class="text-gray-700" x-text="form.pharmacy_address || '-'"></p>
                            </div>
                            <div class="text-right text-gray-500">
                                <p x-text="`Delivered on ${today()}`"></p>
                                <p class="mt-1">ID Kiriman <span x-text="form.id_kiriman || '-'"></span></p>
                            </div>
                        </div>

                        <div class="mt-2 text-xs">
                            <table class="w-full border-collapse">
                                <thead>
                                    <tr class="border-y border-gray-200 bg-gray-50">
                                        <th class="text-left py-2 px-2">RINCIAN PRODUK</th>
                                        <th class="text-center py-2 px-2" style="width: 60px;">QTY</th>
                                        <th class="text-right py-2 px-2" style="width: 120px;">HARGA</th>
                                        <th class="text-right py-2 px-2" style="width: 120px;">TOTAL</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <template x-for="(item, index) in form.items" :key="index">
                                        <tr class="border-b border-gray-200">
                                            <td class="py-2 px-2" x-text="item.name || '-'"></td>
                                            <td class="py-2 px-2 text-center" x-text="item.qty || 0"></td>
                                            <td class="py-2 px-2 text-right" x-text="formatRupiah(item.price || 0)">
                                            </td>
                                            <td class="py-2 px-2 text-right"
                                                x-text="formatRupiah((item.qty || 0) * (item.price || 0))"></td>
                                        </tr>
                                    </template>

                                    <tr class="border-b border-gray-200">
                                        <td colspan="3" class="py-2 px-2 text-right text-gray-700">Subtotal</td>
                                        <td class="py-2 px-2 text-right" x-text="formatRupiah(subtotal())"></td>
                                    </tr>
                                    <tr class="border-b border-gray-200">
                                        <td colspan="3" class="py-2 px-2 text-right text-gray-700">Biaya layanan
                                        </td>
                                        <td class="py-2 px-2 text-right"
                                            x-text="formatRupiah(form.biaya_layanan || 0)"></td>
                                    </tr>
                                    <tr class="border-b border-gray-200 font-semibold">
                                        <td colspan="3" class="py-2 px-2 text-right text-gray-800">Total</td>
                                        <td class="py-2 px-2 text-right"
                                            x-text="formatRupiah(subtotal() + (Number(form.biaya_layanan) || 0))"></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <div class="mt-6 text-xs">
                            <table class="w-full border-collapse">
                                <tbody>
                                    <tr class="border-b border-gray-200">
                                        <td class="py-2 px-2 text-left">Subtotal akhir</td>
                                        <td class="py-2 px-2 text-right" x-text="formatRupiah(subtotal())"></td>
                                    </tr>
                                    <tr class="border-b border-gray-200 font-semibold">
                                        <td class="py-2 px-2 text-left">GRAND TOTAL DIBAYARKAN PASIEN</td>
                                        <td class="py-2 px-2 text-right"
                                            x-text="formatRupiah(subtotal() + (Number(form.biaya_layanan) || 0))"></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <div class="mt-8 text-center text-xs text-gray-500">
                            Butuh bantuan? Hubungi kami di <span class="text-pink-500"
                                x-text="form.help_contact || 'help@halodoc.com'"></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function kuitansiApp() {
            return {
                form: {
                    company_name: 'Halodoc',
                    nomor_kuitansi: 'INV/03072023/MMXXIII/5K10MP-3939',
                    recipient_name: '',
                    recipient_npwp: '',
                    recipient_address: '',
                    doctor_name: '',
                    doctor_speciality: '',
                    consultation_id: '',
                    metode_pembayaran: 'Wallet',
                    pharmacy_name: '',
                    pharmacy_sia: '',
                    pharmacy_address: '',
                    id_kiriman: '',
                    help_contact: 'help@halodoc.com',
                    biaya_layanan: 0,
                    items: [{
                        name: '',
                        qty: 1,
                        price: 0
                    }]
                },
                init() {},
                addItem() {
                    this.form.items.push({
                        name: '',
                        qty: 1,
                        price: 0
                    });
                },
                removeItem(index) {
                    if (this.form.items.length > 1) this.form.items.splice(index, 1);
                },
                subtotal() {
                    return this.form.items.reduce((sum, item) => {
                        return sum + ((Number(item.qty) || 0) * (Number(item.price) || 0));
                    }, 0);
                },
                formatRupiah(value) {
                    return new Intl.NumberFormat('id-ID', {
                        style: 'currency',
                        currency: 'IDR',
                        maximumFractionDigits: 0
                    }).format(Number(value) || 0);
                },
                today() {
                    return new Date().toLocaleDateString('id-ID', {
                        day: '2-digit',
                        month: 'long',
                        year: 'numeric'
                    });
                }
            }
        }
    </script>
</body>

</html>
