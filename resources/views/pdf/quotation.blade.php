<!DOCTYPE html>
<html lang="{{ $quotation->language }}" dir="{{ $quotation->language == 'ar' ? 'rtl' : 'ltr' }}">

<head>
  <meta charset="UTF-8">
  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    body {
      font-family: 'tajawal', sans-serif;
      color: #000000;
      font-size: 13px;
      line-height: 1.7;
    }

    /* ===== HEADER ===== */
    .header {
      background: transparent;
      color: #000000;
      padding: 10px 0;
      margin-bottom: 25px;
      border-bottom: 2px solid #000000;
    }

    .header-logo-cell {
      width: 50%;
      vertical-align: middle;
    }

    .header-info-cell {
      width: 50%;
      vertical-align: middle;
      text-align: left;
      color: #000000;
    }

    .logo-img {
      max-height: 55px;
      max-width: 180px;
    }

    .site-name {
      font-size: 22px;
      font-weight: bold;
    }

    .quote-badge {
      background: transparent;
      border-radius: 0;
      padding: 0;
      display: inline-block;
      font-size: 18px;
      font-weight: bold;
      margin-bottom: 6px;
      color: #000000;
    }

    .header-meta {
      font-size: 11px;
      opacity: 0.85;
      line-height: 1.8;
    }

    .expiry {
      color: #000000;
      font-weight: bold;
    }

    /* ===== CLIENT BOX ===== */
    .client-box {
      background: #f8fafc;
      border: 1px solid #e2e8f0;
      border-radius: 8px;
      padding: 16px 20px;
      margin-bottom: 22px;
    }

    .client-box .label {
      font-size: 10px;
      color: #64748b;
      text-transform: uppercase;
      letter-spacing: 1px;
      margin-bottom: 6px;
    }

    .client-name {
      font-size: 16px;
      font-weight: bold;
    }

    .client-detail {
      font-size: 12px;
      color: #475569;
    }

    /* ===== WATERMARK ===== */
    /* Handled by mPDF tags <watermarkimage> and <watermarktext> */


    /* ===== TABLE ===== */
    table {
      width: 100%;
      border-collapse: collapse;
      margin-bottom: 20px;
    }

    thead tr {
      background: #f1f5f9;
      color: #000000;
      border-bottom: 2px solid #000000;
    }

    thead th {
      padding: 11px 14px;
      text-align: right;
      font-size: 12px;
      font-weight: bold;
      color: #000000;
    }

    tbody tr:nth-child(even) {
      background: #f8fafc;
    }

    tbody td {
      padding: 12px 14px;
      border-bottom: 1px solid #e2e8f0;
      font-size: 13px;
    }

    .num-col {
      text-align: center;
    }

    .price-col {
      text-align: center;
      font-weight: bold;
      color: #000000;
    }

    /* ===== TOTAL ===== */
    .total-wrapper {
      text-align: left;
      margin-bottom: 25px;
    }

    .total-box {
      display: inline-block;
      background: #f1f5f9;
      color: #000000;
      border: 1px solid #000000;
      border-radius: 6px;
      padding: 16px 24px;
      min-width: 220px;
    }

    .total-label {
      font-size: 11px;
      opacity: 0.85;
      margin-bottom: 4px;
    }

    .total-amount {
      font-size: 26px;
      font-weight: bold;
    }

    .total-currency {
      font-size: 14px;
      opacity: 0.9;
    }

    /* ===== NOTES ===== */
    .notes-box {
      background: #f8fafc;
      border-{{ $quotation->language == 'ar' ? 'right' : 'left' }}: 4px solid #000000;
      padding: 12px 16px;
      border-radius: 0 6px 6px 0;
      margin-bottom: 20px;
      font-size: 12px;
      color: #000000;
    }

    .notes-title {
      font-weight: bold;
      margin-bottom: 6px;
      color: #000000;
      border-bottom: 1px solid #e2e8f0;
    }

    .notes-content {
      color: #000000;
    }

    /* ===== FOOTER ===== */
    .footer {
      position: fixed;
      bottom: 0;
      left: 0;
      right: 0;
      background: #f8fafc;
      border-top: 1px solid #000000;
      padding: 10px 30px;
    }

    .footer-left {
      width: 50%;
      vertical-align: middle;
      font-size: 11px;
      color: #000000;
    }

    .footer-right {
      width: 50%;
      vertical-align: middle;
      text-align: left;
      font-size: 11px;
      color: #000000;
    }

    .footer-brand {
      font-weight: bold;
      color: #000000;
      font-size: 13px;
    }

    /* ===== SIGNATURES ===== */
    .signatures {
      margin-top: 50px;
      margin-bottom: 30px;
    }

    .sig-cell {
      width: 50%;
      vertical-align: top;
      text-align: center;
    }

    .sig-line {
      border-top: 1px solid #000000;
      width: 200px;
      margin: 40px auto 10px auto;
    }

    .sig-label {
      font-weight: bold;
      font-size: 12px;
    }

    .footer-expiry {
      color: #000000;
      font-weight: bold;
    }
  </style>
</head>

<body>
  {{-- WATERMARK --}}
  @if(($options['showBackground'] ?? true))
    @php
      $targetLogoKey = $options['pdfLogo'] ?? 'logo_dark';
      $logoPath = $settings['logo_pdf_watermark'] ?? ($settings['logo_pdf'] ?? ($settings[$targetLogoKey] ?? null));
    @endphp
    @if($logoPath)
      <watermarkimage src="{{ storage_path('app/public/' . $logoPath) }}" alpha="0.1" size="300,300" />
    @else
      <watermarktext content="{{ $settings['site_name'] }}" alpha="0.1" />
    @endif
  @endif


  {{-- HEADER --}}
  <div class="header">
    <table style="width: 100%; border: none;">
      <tr style="background: transparent;">
        <td class="header-logo-cell" style="border: none; background: transparent;">
          @php
            $targetLogoKey = $options['pdfLogo'] ?? 'logo_dark';
            $logoPath = $settings['logo_pdf'] ?? ($settings[$targetLogoKey] ?? null);
          @endphp
          @if($logoPath)
            <img src="{{ storage_path('app/public/' . $logoPath) }}" class="logo-img" alt="logo">
          @else
            <div class="site-name" style="color: #000000;">{{ $settings['site_name'] }}</div>
          @endif
        </td>
        <td class="header-info-cell" style="border: none; background: transparent;">
          <div class="quote-badge" style="color: #000000;">{{ __('Quotation') }}
            #Q-{{ str_pad($quotation->id, 5, '0', STR_PAD_LEFT) }}</div>
          <div class="header-meta" style="color: #000000;">
            {{ __('Issue Date') }}: {{ $quotation->created_at->format('Y/m/d') }}<br>
            @if($quotation->expired_at)
              <span class="expiry" style="color: #000000;">{{ __('Valid Until') }}:
                {{ $quotation->expired_at->format('Y/m/d') }}</span>
            @endif
          </div>
        </td>
      </tr>
    </table>
  </div>

  {{-- CLIENT INFO --}}
  <div class="client-box">
    <div class="label" style="color: #000000;">{{ __('Addressed To') }}</div>
    <div class="client-name">{{ $quotation->display_name }}</div>
    @if($quotation->client_email ?: ($quotation->client?->user->email))
      <div class="client-detail">{{ $quotation->client_email ?: $quotation->client->user->email }}</div>
    @endif
    @if($quotation->client_phone ?: ($quotation->client?->phone))
      <div class="client-detail">{{ $quotation->client_phone ?: $quotation->client->phone }}</div>
    @endif
  </div>

  {{-- ITEMS TABLE --}}
  <table>
    <thead>
      <tr>
        <th>{{ __('Description') }}</th>
        <th style="width:80px;" class="num-col">{{ __('Qty') }}</th>
        <th style="width:120px;" class="num-col">{{ __('Unit Price') }}</th>
        <th style="width:130px;" class="num-col">{{ __('Total') }}</th>
      </tr>
    </thead>
    <tbody>
      @foreach($quotation->items as $item)
        <tr>
          <td>{{ $item['description'] }}</td>
          <td class="num-col">{{ $item['quantity'] }}</td>
          <td class="price-col">{{ number_format($item['unit_price'], 2) }}</td>
          <td class="price-col">{{ number_format($item['quantity'] * $item['unit_price'], 2) }}</td>
        </tr>
      @endforeach
    </tbody>
  </table>

  {{-- TOTAL --}}
  <div class="total-wrapper">
    <div class="total-box" style="color: #000000;">
      <div class="total-label" style="color: #000000; opacity: 0.8;">{{ __('Total Amount') }}</div>
      <div class="total-amount" style="color: #000000;">
        {{ number_format($quotation->amount, 2) }}
        <span class="total-currency" style="color: #000000; opacity: 0.8;">{{ $quotation->currency }}</span>
      </div>
    </div>
  </div>

  {{-- NOTES --}}
  @if($quotation->notes)
    <div class="notes-box">
      <div class="notes-title">{{ __('Terms & Notes') }}</div>
      <div class="notes-content">{!! nl2br(e($quotation->notes)) !!}</div>
    </div>
  @endif

  {{-- SIGNATURES --}}
  <div class="signatures">
    <table style="width: 100%; border: none;">
      <tr style="background: transparent;">
        @if(($options['showCompanySignature'] ?? true))
          <td class="sig-cell" style="border: none;">
            <div class="sig-line"></div>
            <div class="sig-label">{{ __('Company Signature') }}</div>
          </td>
        @endif

        @if(($options['showClientSignature'] ?? true))
          <td class="sig-cell" style="border: none;">
            <div class="sig-line"></div>
            <div class="sig-label">{{ __('Client Signature') }}</div>
          </td>
        @endif
      </tr>
    </table>
  </div>

  {{-- FOOTER --}}
  <div class="footer">
    <table style="width:100%;">
      <tr>
        <td class="footer-left">
          <span class="footer-brand">{{ $settings['site_name'] }}</span><br>
          @if($settings['contact_email']) {{ $settings['contact_email'] }} @endif
          @if($settings['contact_phone']) &nbsp;|&nbsp; {{ $settings['contact_phone'] }} @endif
          @if($settings['whatsapp'] && $settings['whatsapp'] !== $settings['contact_phone']) &nbsp;|&nbsp;
          {{ $settings['whatsapp'] }} @endif
        </td>
        <td class="footer-right">
          {{ __('This quotation is valid for a limited period from the issue date.') }}
          @if($quotation->expired_at)
            <br><span class="footer-expiry">{{ __('Valid Until') }}: {{ $quotation->expired_at->format('Y/m/d') }}</span>
          @endif
        </td>
      </tr>
    </table>
  </div>

</body>

</html>