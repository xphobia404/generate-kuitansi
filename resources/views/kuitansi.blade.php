<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Kuitansi Generator</title>
  <style>
    :root {
      --primary: #c5165b;
      --text: #4d535b;
      --muted: #8a9097;
      --line: #dfe3e8;
      --soft: #f7f8fa;
      --soft-2: #fbfbfc;
      --white: #ffffff;
      --shadow: 0 10px 30px rgba(27, 39, 51, 0.08);
      --radius: 14px;
    }

    * { box-sizing: border-box; }
    body {
      margin: 0;
      font-family: Arial, Helvetica, sans-serif;
      background: #eef2f5;
      color: var(--text);
      padding: 24px;
    }

    .app {
      max-width: 1380px;
      margin: 0 auto;
      display: grid;
      grid-template-columns: 360px 1fr;
      gap: 24px;
      align-items: start;
    }

    .panel, .paper {
      background: var(--white);
      border-radius: 18px;
      box-shadow: var(--shadow);
    }

    .panel {
      padding: 20px;
      position: sticky;
      top: 24px;
    }

    .panel h2 {
      margin: 0 0 16px;
      font-size: 22px;
      color: #222;
    }

    .group {
      margin-bottom: 18px;
      border: 1px solid var(--line);
      border-radius: 14px;
      padding: 14px;
      background: var(--soft-2);
    }

    .group h3 {
      margin: 0 0 12px;
      font-size: 14px;
      color: #1f2933;
      text-transform: uppercase;
      letter-spacing: .04em;
    }

    .field {
      margin-bottom: 10px;
    }

    .field:last-child { margin-bottom: 0; }

    label {
      display: block;
      font-size: 12px;
      font-weight: 700;
      color: #5f6770;
      margin-bottom: 6px;
    }

    input, textarea, button {
      font: inherit;
    }

    input, textarea {
      width: 100%;
      border: 1px solid #cfd6de;
      border-radius: 10px;
      padding: 10px 12px;
      outline: none;
      background: #fff;
    }

    textarea {
      min-height: 74px;
      resize: vertical;
    }

    .item-row {
      display: grid;
      grid-template-columns: 1.8fr .7fr 1fr;
      gap: 8px;
      margin-bottom: 8px;
    }

    .btn-row {
      display: flex;
      gap: 10px;
      flex-wrap: wrap;
      margin-top: 14px;
    }

    button {
      border: 0;
      border-radius: 10px;
      padding: 11px 14px;
      font-weight: 700;
      cursor: pointer;
    }

    .btn-primary { background: var(--primary); color: #fff; }
    .btn-secondary { background: #e7ecf2; color: #243240; }
    .btn-light { background: #fff; color: #243240; border: 1px solid var(--line); }

    .paper {
      padding: 38px 40px 28px;
      min-height: 100vh;
      width: 210mm;
      margin: 0 auto;
    }

    .receipt-header {
      display: flex;
      justify-content: space-between;
      align-items: flex-start;
      gap: 24px;
      padding-bottom: 22px;
      border-bottom: 1px solid var(--line);
    }

    .brand img {
      width: 240px;
      max-width: 100%;
      height: auto;
      object-fit: contain;
    }

    .receipt-title {
      text-align: right;
    }

    .receipt-title h1 {
      margin: 0;
      color: #5b616a;
      font-size: 28px;
      letter-spacing: .02em;
    }

    .top-section {
      display: grid;
      grid-template-columns: 1.25fr .95fr;
      gap: 34px;
      padding: 28px 0;
      border-bottom: 1px solid var(--line);
    }

    .muted { color: var(--muted); }
    .small { font-size: 13px; line-height: 1.55; }
    .strong { font-weight: 700; color: #2e3640; }
    .big-name { font-size: 18px; font-weight: 700; color: #59616a; margin: 8px 0 4px; }
    .section-title { margin: 20px 0 10px; font-size: 15px; color: #606771; font-weight: 400; }

    .meta-box-wrap {
      display: flex;
      flex-direction: column;
      gap: 12px;
    }

    .invoice-code {
      padding: 15px 1px 20px 0;
      font-weight: 700;
      color: #39424d;
      min-height: 22px;
      display: flex;
      align-items: left;
      justify-content: left;
      text-align: left;
    }

    .meta-box {
      border: 1px solid var(--line);
      border-radius: 12px;
      overflow: hidden;
      background: #fff;
    }

    .meta-row {
      display: grid;
      grid-template-columns: 1fr 1fr;
      min-height: 46px;
    }

    .meta-row:not(:last-child) {
      border-bottom: 1px solid var(--line);
    }

    .meta-label, .meta-value {
      padding: 12px 14px;
      font-size: 14px;
      display: flex;
      align-items: center;
    }

    .meta-label {
      background: #fafafa;
      font-weight: 700;
      color: #5f6770;
      border-right: 1px solid var(--line);
    }

    .meta-value {
      justify-content: flex-end;
      text-align: right;
      color: #656d76;
    }

    .shipping-section {
      padding: 24px 0 14px;
    }

    .shipping-card {
      display: grid;
      grid-template-columns: 1.35fr .75fr;
      gap: 24px;
      margin-top: 14px;
    }

    .shipping-meta {
      padding-top: 6px;
      text-align: right;
    }

    .shipping-meta .field-line {
      margin-bottom: 10px;
      font-size: 14px;
    }

    .receipt-table {
      width: 100%;
      margin-top: 18px;
      border: 1px solid var(--line);
      border-collapse: separate;
      border-spacing: 0;
      overflow: hidden;
    }

    .receipt-table th,
    .receipt-table td {
      padding: 10px 12px;
      font-size: 14px;
      border-right: 1px solid var(--line);
      border-bottom: 1px solid var(--line);
    }

    .receipt-table th:last-child,
    .receipt-table td:last-child {
      border-right: 0;
    }

    .receipt-table tbody tr:last-child td {
      border-bottom: 0;
    }

    .receipt-table th {
      background: #f6f6f7;
      color: #5f6670;
      text-align: left;
      font-weight: 700;
    }

    .receipt-table th:nth-child(2),
    .receipt-table th:nth-child(3),
    .receipt-table th:nth-child(4),
    .receipt-table td:nth-child(2),
    .receipt-table td:nth-child(3),
    .receipt-table td:nth-child(4) {
      text-align: center;
    }

    .summary-label {
      text-align: right !important;
      font-weight: 400;
      color: #5f6770;
      background: #fff;
    }

    .summary-total .summary-label,
    .summary-total td:last-child {
      font-weight: 700;
      color: #3c4450;
    }

    .bottom-summary {
      margin-top: 18px;
    }

    .bottom-summary table {
      width: 100%;
      border: 1px solid var(--line);
      border-collapse: separate;
      border-spacing: 0;
      overflow: hidden;
    }

    .bottom-summary td {
      padding: 14px 16px;
      font-size: 14px;
      border-right: 1px solid var(--line);
      border-bottom: 1px solid var(--line);
    }

    .bottom-summary tr:last-child td {
      border-bottom: 0;
    }

    .bottom-summary td:last-child {
      border-right: 0;
    }

    .bottom-summary td:first-child {
      width: 66%;
      background: #fff;
    }

    .bottom-summary-label {
      text-align: right;
      color: #666f79;
      background: #fff;
    }

    .bottom-summary-value {
      width: 18%;
      text-align: right;
      color: #6a727b;
      background: #fff;
    }

    .grand-total-row .bottom-summary-label,
    .grand-total-row .bottom-summary-value {
      font-weight: 700;
      color: #4e5660;
      background: #f6f6f7;
    }

    .support-box {
      margin-top: 26px;
      border-top: 1px solid var(--line);
      padding-top: 20px;
      text-align: center;
      font-size: 18px;
      color: #505862;
    }

    .support-box a {
      color: var(--primary);
      text-decoration: none;
      font-weight: 400;
    }

    .empty-state {
      text-align: center;
      color: var(--muted);
      padding: 14px 0;
    }

    @page {
      size: A4;
      margin: 12mm;
    }

    @media print {
      html, body {
        width: 210mm;
        min-height: 297mm;
        background: #fff !important;
        -webkit-print-color-adjust: exact;
        print-color-adjust: exact;
      }

      body {
        padding: 0 !important;
        margin: 0 !important;
      }

      .panel {
        display: none !important;
      }

      .app {
        display: block !important;
        max-width: 100% !important;
      }

      .paper {
        width: 100% !important;
        min-height: auto !important;
        padding: 0 !important;
        margin: 0 !important;
        border-radius: 0 !important;
        box-shadow: none !important;
        background: #fff !important;
      }

      .receipt-header,
      .top-section,
      .shipping-section,
      .bottom-summary,
      .support-box {
        break-inside: avoid;
        page-break-inside: avoid;
      }

      .receipt-table thead {
        display: table-header-group;
      }

      .receipt-table tr,
      .meta-row,
      .bottom-summary tr {
        break-inside: avoid;
        page-break-inside: avoid;
      }
    }

    @media (max-width: 1080px) {
      .app { grid-template-columns: 1fr; }
      .panel { position: static; }
    }

    @media (max-width: 760px) {
      body { padding: 12px; }
      .paper { padding: 20px 16px; }
      .top-section, .shipping-card { grid-template-columns: 1fr; }
      .receipt-header { flex-direction: column; }
      .receipt-title { text-align: left; }
      .shipping-meta { text-align: left; }
      .item-row { grid-template-columns: 1fr; }
      .meta-row { grid-template-columns: 1fr; }
      .meta-label { border-right: 0; border-bottom: 1px solid var(--line); }
      .meta-value { text-align: left; }
      .receipt-table { display: block; overflow-x: auto; }
    }
  </style>
</head>
<body>
  <div class="app">
    <aside class="panel">
      <h2>Form Kuitansi</h2>

      <div class="group">
        <h3>Header</h3>
        <div class="field"><label>Nama brand</label><input id="brandName" value="halodoc" /></div>
        <div class="field"><label>Judul dokumen</label><input id="receiptTitle" value="KUITANSI" /></div>
        <div class="field"><label>Nomor invoice</label><input id="invoiceNumber" value="INV/03072023/MMXXIII/5K1OMP-3939" /></div>
      </div>

      <div class="group">
        <h3>Penerima</h3>
        <div class="field"><label>Kalimat pembuka</label><textarea id="introText">Terima kasih telah bertransaksi di Halodoc,</textarea></div>
        <div class="field"><label>Nama pelanggan</label><input id="customerName" value="Yohanes Limbong" /></div>
        <div class="field"><label>NPWP</label><input id="npwp" value="00.000.000.0-0.000" /></div>
        <div class="field"><label>Alamat pelanggan</label><textarea id="customerAddress">Jl. Taruna 5 No.11, RT.19/RW.3, Serdang, Kec. Kemayoran, Kota Jakarta Pusat, Daerah Khusus Ibukota Jakarta 10650, Indonesia</textarea></div>
      </div>

      <div class="group">
        <h3>Konsultasi</h3>
        <div class="field"><label>Label layanan</label><input id="serviceLabel" value="Konsultasi dari dokter :" /></div>
        <div class="field"><label>Nama dokter / layanan</label><input id="doctorName" value="Dwinta Rizky Rachel Saragih" /></div>
        <div class="field"><label>Spesialisasi</label><input id="doctorRole" value="General Practitioner" /></div>
        <div class="field"><label>Consultation ID</label><input id="consultationId" value="8WM05X-6092" /></div>
      </div>

      <div class="group">
        <h3>Info transaksi</h3>
        <div class="field"><label>No pesanan</label><input id="orderNumber" value="5K1OMP-3939" /></div>
        <div class="field"><label>Tanggal transaksi</label><input id="transactionDate" value="17 November 2021" /></div>
        <div class="field"><label>Metode pembayaran</label><input id="paymentMethod" value="Wallet" /></div>
      </div>

      <div class="group">
        <h3>Pengiriman</h3>
        <div class="field"><label>Judul section</label><input id="shippingTitle" value="Deskripsi kiriman" /></div>
        <div class="field"><label>Nama apotik/toko</label><input id="storeName" value="APOTIK K24 RAWAMANGUN (F)" /></div>
        <div class="field"><label>SIA</label><input id="siaNumber" value="3/B.13.1/31.75.02.1005.02.015.C.1/3/-1.779.3/e/2021" /></div>
        <div class="field"><label>Alamat toko</label><textarea id="storeAddress">Jalan Balai Pustaka Timur No.16B, RT.4/RW.11, Rawamangun, RT.4/RW.11, Rawamangun, Pulo Gadung, Kota Jakarta Timur, Daerah Khusus Ibukota Jakarta 13220</textarea></div>
        <div class="field"><label>Telepon toko</label><input id="storePhone" value="0214700788" /></div>
        <div class="field"><label>Tanggal delivered</label><input id="deliveredOn" value="17 November 2021" /></div>
        <div class="field"><label>ID Kiriman</label><input id="shipmentId" value="PRXJGP-8980" /></div>
      </div>

      <div class="group">
        <h3>Item produk</h3>
        <div id="itemInputs"></div>
        <div class="btn-row">
          <button type="button" class="btn-secondary" id="addItemBtn">+ Tambah item</button>
          <button type="button" class="btn-light" id="resetItemsBtn">Reset item</button>
        </div>
      </div>

      <div class="group">
        <h3>Biaya tambahan</h3>
        <div class="field"><label>Label biaya</label><input id="serviceFeeLabel" value="Biaya layanan" /></div>
        <div class="field"><label>Nominal biaya</label><input id="serviceFee" type="number" value="18000" /></div>
        <div class="field"><label>Label subtotal akhir</label><input id="finalSubtotalLabel" value="Subtotal akhir" /></div>
        <div class="field"><label>Label grand total</label><input id="grandTotalLabel" value="GRAND TOTAL DIBAYARKAN PASIEN" /></div>
      </div>

      <div class="group">
        <h3>Bantuan bawah</h3>
        <div class="field"><label>Teks bantuan</label><input id="supportText" value="Butuh bantuan? Hubungi kami di" /></div>
        <div class="field"><label>Email bantuan</label><input id="supportEmail" value="help@halodoc.com" /></div>
      </div>

      <div class="btn-row">
        <button type="button" class="btn-primary" onclick="window.print()">Print / Save PDF</button>
      </div>
    </aside>

    <main class="paper" id="receiptPaper">
      <div class="receipt-header">
        <div class="brand"><img src="asset/logo.png" alt="Logo Halodoc" /></div>
        <div class="receipt-title">
          <h1 id="viewTitle">KUITANSI</h1>
        </div>
      </div>

      <section class="top-section">
        <div>
          <p class="small muted" id="viewIntro">Terima kasih telah bertransaksi di Halodoc,</p>
          <div class="big-name" id="viewCustomerName">Yohanes Limbong</div>
          <p class="small muted">NPWP: <span id="viewNpwp">00.000.000.0-0.000</span></p>

          <p class="small strong" style="margin-top: 14px;">Alamat:</p>
          <p class="small muted" id="viewCustomerAddress">-</p>

          <div class="section-title" id="viewServiceLabel">Konsultasi dari dokter :</div>
          <div class="big-name" id="viewDoctorName">Dwinta Rizky Rachel Saragih</div>
          <p class="small muted" id="viewDoctorRole">General Practitioner</p>
          <p class="small"><span class="strong">Consultation ID</span> : <span id="viewConsultationId">8WM05X-6092</span></p>
        </div>

        <div class="meta-box-wrap">
          <div class="invoice-code" id="viewInvoiceNumber">INV/03072023/MMXXIII/5K1OMP-3939</div>
          <div class="meta-box">
            <div class="meta-row">
              <div class="meta-label">No pesanan</div>
              <div class="meta-value" id="viewOrderNumber">5K1OMP-3939</div>
            </div>
            <div class="meta-row">
              <div class="meta-label">Tanggal transaksi</div>
              <div class="meta-value" id="viewTransactionDate">17 November 2021</div>
            </div>
            <div class="meta-row">
              <div class="meta-label">Metode pembayaran</div>
              <div class="meta-value" id="viewPaymentMethod">Wallet</div>
            </div>
          </div>
        </div>
      </section>

      <section class="shipping-section">
        <h3 style="font-size: 16px; color: #565e67;" id="viewShippingTitle">Deskripsi kiriman</h3>
        <div class="shipping-card">
          <div>
            <p class="small muted">Nama apotik/toko:</p>
            <div class="big-name" id="viewStoreName">APOTIK K24 RAWAMANGUN (F)</div>
            <p class="small muted">SIA: <span id="viewSiaNumber">3/B.13.1/31.75.02.1005.02.015.C.1/3/-1.779.3/e/2021</span></p>

            <p class="small strong" style="margin-top: 14px;">Alamat:</p>
            <p class="small muted" id="viewStoreAddress">-</p>
            <p class="small muted" id="viewStorePhone">0214700788</p>
          </div>
          <div class="shipping-meta">
            <div class="field-line"><span class="strong">Delivered on</span> &nbsp; <span class="muted" id="viewDeliveredOn">17 November 2021</span></div>
            <div class="field-line"><span class="strong">ID Kiriman</span> &nbsp; <span class="muted" id="viewShipmentId">PRXJGP-8980</span></div>
          </div>
        </div>

        <table class="receipt-table">
          <thead>
            <tr>
              <th>RINCIAN PRODUK</th>
              <th>QTY</th>
              <th>HARGA</th>
              <th>TOTAL</th>
            </tr>
          </thead>
          <tbody id="receiptBody"></tbody>
        </table>

        <div class="bottom-summary">
          <table>
            <tbody>
              <tr>
                <td class="bottom-summary-label" id="viewFinalSubtotalLabel">Subtotal akhir</td>
                <td class="bottom-summary-value" id="viewGrandTotalValue">Rp 79,700.00</td>
              </tr>
              <tr class="grand-total-row">
                <td class="bottom-summary-label" id="viewGrandTotalLabel">GRAND TOTAL DIBAYARKAN PASIEN</td>
                <td class="bottom-summary-value" id="viewFinalSubtotalValue">79,700.00</td>
              </tr>
            </tbody>
          </table>
        </div>

        <div class="support-box">
          <span id="viewSupportText">Butuh bantuan? Hubungi kami di</span>
          <a href="mailto:help@halodoc.com" id="viewSupportEmail">help@halodoc.com</a>
        </div>
      </section>
    </main>
  </div>

  <script>
    const itemInputs = document.getElementById('itemInputs');
    const receiptBody = document.getElementById('receiptBody');

    const fieldMap = {
      brandName: 'viewBrand',
      receiptTitle: 'viewTitle',
      introText: 'viewIntro',
      customerName: 'viewCustomerName',
      npwp: 'viewNpwp',
      customerAddress: 'viewCustomerAddress',
      serviceLabel: 'viewServiceLabel',
      doctorName: 'viewDoctorName',
      doctorRole: 'viewDoctorRole',
      consultationId: 'viewConsultationId',
      invoiceNumber: 'viewInvoiceNumber',
      orderNumber: 'viewOrderNumber',
      transactionDate: 'viewTransactionDate',
      paymentMethod: 'viewPaymentMethod',
      shippingTitle: 'viewShippingTitle',
      storeName: 'viewStoreName',
      siaNumber: 'viewSiaNumber',
      storeAddress: 'viewStoreAddress',
      storePhone: 'viewStorePhone',
      deliveredOn: 'viewDeliveredOn',
      shipmentId: 'viewShipmentId',
      supportText: 'viewSupportText',
      supportEmail: 'viewSupportEmail'
    };

    function formatCurrency(value) {
      const number = Number(value) || 0;
      return number.toLocaleString('id-ID', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
    }

    function createItemInput(item = { name: '', qty: 1, price: 0 }) {
      const wrapper = document.createElement('div');
      wrapper.className = 'item-row';
      wrapper.innerHTML = `
        <input type="text" class="item-name" placeholder="Nama produk" value="${item.name}">
        <input type="number" class="item-qty" placeholder="Qty" min="1" value="${item.qty}">
        <div style="display:flex; gap:8px;">
          <input type="number" class="item-price" placeholder="Harga" min="0" value="${item.price}" style="flex:1;">
          <button type="button" class="btn-light remove-item" style="padding:10px 12px;">✕</button>
        </div>
      `;

      wrapper.querySelectorAll('input').forEach(input => {
        input.addEventListener('input', renderReceipt);
      });

      wrapper.querySelector('.remove-item').addEventListener('click', () => {
        wrapper.remove();
        renderReceipt();
      });

      itemInputs.appendChild(wrapper);
    }

    function getItems() {
      return [...document.querySelectorAll('.item-row')]
        .map(row => ({
          name: row.querySelector('.item-name').value.trim(),
          qty: Number(row.querySelector('.item-qty').value) || 0,
          price: Number(row.querySelector('.item-price').value) || 0,
        }))
        .filter(item => item.name || item.qty || item.price);
    }

    function renderStaticFields() {
      Object.entries(fieldMap).forEach(([inputId, viewId]) => {
        const input = document.getElementById(inputId);
        const view = document.getElementById(viewId);
        if (input && view) {
          view.textContent = input.value || '-';
        }
      });
    }

    function renderReceipt() {
      renderStaticFields();
      const items = getItems();
      const feeLabel = document.getElementById('serviceFeeLabel').value || 'Biaya layanan';
      const fee = Number(document.getElementById('serviceFee').value) || 0;
      const subtotal = items.reduce((sum, item) => sum + (item.qty * item.price), 0);
      const total = subtotal + fee;
      const finalSubtotalLabel = document.getElementById('finalSubtotalLabel').value || 'Subtotal akhir';
      const grandTotalLabel = document.getElementById('grandTotalLabel').value || 'GRAND TOTAL DIBAYARKAN PASIEN';

      receiptBody.innerHTML = '';

      if (!items.length) {
        const emptyRow = document.createElement('tr');
        emptyRow.innerHTML = '<td colspan="4" class="empty-state">Belum ada item. Isi produk dari panel kiri.</td>';
        receiptBody.appendChild(emptyRow);
      } else {
        items.forEach(item => {
          const tr = document.createElement('tr');
          tr.innerHTML = `
            <td>${item.name}</td>
            <td>${item.qty}</td>
            <td>${formatCurrency(item.price)}</td>
            <td>${formatCurrency(item.qty * item.price)}</td>
          `;
          receiptBody.appendChild(tr);
        });
      }

      const summaryRows = [
        { label: 'Subtotal', value: formatCurrency(subtotal), totalClass: '' },
        { label: feeLabel, value: formatCurrency(fee), totalClass: '' },
        { label: 'Total', value: 'Rp ' + formatCurrency(total), totalClass: 'summary-total' }
      ];

      summaryRows.forEach(row => {
        const tr = document.createElement('tr');
        tr.className = row.totalClass;
        tr.innerHTML = `
          <td colspan="3" class="summary-label">${row.label}</td>
          <td>${row.value}</td>
        `;
        receiptBody.appendChild(tr);
      });

      document.getElementById('viewFinalSubtotalLabel').textContent = finalSubtotalLabel;
      document.getElementById('viewGrandTotalLabel').textContent = grandTotalLabel;
      document.getElementById('viewFinalSubtotalValue').textContent = formatCurrency(total);
      document.getElementById('viewGrandTotalValue').textContent = 'Rp ' + formatCurrency(total);
      const supportEmail = document.getElementById('supportEmail').value || 'help@halodoc.com';
      const emailView = document.getElementById('viewSupportEmail');
      emailView.textContent = supportEmail;
      emailView.href = 'mailto:' + supportEmail;
    }

    document.querySelectorAll('input, textarea').forEach(el => {
      el.addEventListener('input', renderReceipt);
    });

    document.getElementById('addItemBtn').addEventListener('click', () => {
      createItemInput();
      renderReceipt();
    });

    document.getElementById('resetItemsBtn').addEventListener('click', () => {
      itemInputs.innerHTML = '';
      seedItems();
      renderReceipt();
    });

    function seedItems() {
      [
        { name: 'Becom-Zet 10 Kaplet', qty: 1, price: 29500 },
        { name: 'Indexon 0.5 mg 10 Tablet', qty: 1, price: 12100 },
        { name: 'Sanadryl Expectorant Sirup 120 ml', qty: 1, price: 20100 }
      ].forEach(createItemInput);
    }

    seedItems();
    renderReceipt();
  </script>
</body>
</html>
