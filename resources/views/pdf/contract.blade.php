<!DOCTYPE html>
<html lang="{{ $lang ?? app()->getLocale() }}" dir="{{ ($lang ?? app()->getLocale()) == 'ar' ? 'rtl' : 'ltr' }}">

<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    body {
      font-family: 'tajawal', sans-serif;
      color: #1f2937;
      font-size: 13px;
      line-height: 1.7;
    }

    .header {
      border-bottom: 2px solid #1f2937;
      padding-bottom: 16px;
      margin-bottom: 24px;
    }

    .logo-img {
      max-height: 55px;
      max-width: 180px;
    }

    .site-name {
      font-size: 22px;
      font-weight: bold;
    }

    .contract-title {
      font-size: 20px;
      font-weight: bold;
      color: #111827;
      margin-bottom: 4px;
    }

    .contract-number {
      font-size: 11px;
      color: #6b7280;
      margin-top: 8px;
    }

    .parties {
      margin-bottom: 28px;
      width: 100%;
    }

    .party {
      width: 48%;
      display: inline-block;
      vertical-align: top;
    }

    .party-title {
      font-weight: bold;
      font-size: 14px;
      color: #3b82f6;
      border-bottom: 1px solid #e5e7eb;
      margin-bottom: 8px;
      padding-bottom: 4px;
    }

    .content {
      margin-bottom: 36px;
    }

    .clause {
      margin-bottom: 16px;
    }

    .clause-title {
      font-weight: bold;
      margin-bottom: 5px;
      color: #111827;
    }

    .clause-text {
      color: #374151;
    }

    .total-amount {
      margin-top: 18px;
      font-weight: bold;
      font-size: 17px;
      text-align: center;
      border-top: 1px solid #e5e7eb;
      padding-top: 14px;
    }

    .signatures {
      margin-top: 55px;
      width: 100%;
    }

    .signature-box {
      width: 45%;
      display: inline-block;
      text-align: center;
      border-top: 1px solid #1f2937;
      padding-top: 10px;
    }

    .footer {
      position: fixed;
      bottom: 0;
      width: 100%;
      text-align: center;
      font-size: 10px;
      color: #9ca3af;
      border-top: 1px solid #f3f4f6;
      padding-top: 8px;
    }

    @page {
      @if($options['showBackground'] ?? true)
        @php
          $targetLogoKey = $options['pdfLogo'] ?? 'logo_dark';
          $langSuffix = $lang ?? app()->getLocale();
          $watermarkPath = $settings["logo_pdf_watermark_{$langSuffix}"] ?? ($settings['logo_pdf_watermark'] ?? ($settings['logo_pdf'] ?? ($settings[$targetLogoKey] ?? null)));
        @endphp
        @if($watermarkPath)
          background: url("{{ storage_path('app/public/' . $watermarkPath) }}") no-repeat center center;
          background-image-resize: 6;
        @endif
      @endif
    }
  </style>
</head>

<body>
  {{-- Background is now handled in @page CSS to ensure it stays behind content --}}

  @if(($options['showBackground'] ?? true) && !($watermarkPath ?? false))
    <watermarktext content="{{ $settings['site_name'] ?? config('app.name') }}" alpha="0.1" />
  @endif


  {{-- HEADER: Logo + Title --}}
  <div class="header">
    <table style="width: 100%; border: none;">
      <tr style="background: transparent;">
        <td style="width: 55%; vertical-align: middle; border: none; background: transparent;">
          @if($options['showLogo'] ?? true)
            @php
              $targetLogoKey = $options['pdfLogo'] ?? 'logo_dark';
              $logoPath = $settings['logo_pdf'] ?? ($settings[$targetLogoKey] ?? null);
            @endphp
            @if($logoPath)
              <img src="{{ storage_path('app/public/' . $logoPath) }}" class="logo-img" alt="logo">
            @else
              <div class="site-name">{{ $settings['site_name'] ?? config('app.name') }}</div>
            @endif
          @endif
        </td>
        <td style="width: 45%; vertical-align: middle; text-align: left; border: none; background: transparent;">
          <div class="contract-title">{{ $contract->getTranslation('title', $lang ?? app()->getLocale()) }}</div>
          <div class="contract-number">{{ __('Contract No') }}: {{ $contract->contract_number }}</div>
          @if($contract->expires_at)
            <div style="font-size: 11px; color: #9ca3af; margin-top: 3px;">
              {{ __('Expires') }}: {{ $contract->expires_at->format('Y/m/d') }}
            </div>
          @endif
        </td>
      </tr>
    </table>
  </div>

  {{-- PARTIES --}}
  @php
    $companyName = $settings['site_name'] ?? config('app.name');
    $companyEmail = $settings['contact_email'] ?? '';
    $companyPhone = $settings['contact_phone'] ?? '';
    $companyAddress = $settings['address'] ?? '';
  @endphp

  <div class="parties">
    <div class="party" style="float: right;">
      <div class="party-title">{{ __('First Party (Company)') }}</div>
      <div><strong>{{ $companyName }}</strong></div>
      @if($companyEmail)
      <div>{{ __('Email') }}: {{ $companyEmail }}</div>@endif
      @if($companyPhone)
      <div>{{ __('Phone') }}: {{ $companyPhone }}</div>@endif
      @if($companyAddress)
      <div>{{ __('Address') }}: {{ $companyAddress }}</div>@endif
    </div>
    <div class="party" style="float: left;">
      <div class="party-title">{{ __('Second Party (Client)') }}</div>
      <div><strong>{{ $client->user->name }}</strong></div>
      <div>{{ __('Email') }}: {{ $client->user->email }}</div>
      @if($client->phone ?? false)
      <div>{{ __('Phone') }}: {{ $client->phone }}</div>@endif
      @if($client->address ?? false)
      <div>{{ __('Address') }}: {{ $client->address }}</div>@endif
    </div>
    <div style="clear: both;"></div>
  </div>

  {{-- CLAUSES with variable replacement --}}
  <div class="content">
    @php
      $contractService = app(\App\Services\ContractService::class);
      $locale = $lang ?? app()->getLocale();
      $clauses = is_array($contract->content) ? $contract->content : json_decode($contract->content, true);
      $localizedClauses = $clauses[$locale] ?? ($clauses[config('app.fallback_locale')] ?? []);
    @endphp

    @foreach($localizedClauses as $index => $clause)
      <div class="clause">
        <div class="clause-title">{{ __('Clause') }} {{ $index + 1 }}</div>
        <div class="clause-text">
          {!! nl2br(e($contractService->parseClause($clause, $client, $contract, $settings))) !!}
        </div>
      </div>
    @endforeach
  </div>

  {{-- TOTAL AMOUNT --}}
  @if($contract->total_amount)
    <div class="total-amount">
      {{ __('Total Amount') }}: {{ number_format((float) $contract->total_amount, 2) }} {{ $contract->currency }}
    </div>
  @endif

  {{-- SIGNATURES --}}
  <div class="signatures">
    @if($options['showCompanySignature'] ?? true)
      <div class="signature-box" style="float: right;">
        <div>{{ __('First Party Signature') }}</div>
        <div style="margin-top: 38px;">(________________________)</div>
        <div style="margin-top: 6px; font-size: 11px; color: #6b7280;">{{ $companyName }}</div>
      </div>
    @endif
    @if($options['showClientSignature'] ?? true)
      <div class="signature-box" style="float: left;">
        <div>{{ __('Second Party Signature') }}</div>
        <div style="margin-top: 38px;">(________________________)</div>
        <div style="margin-top: 6px; font-size: 11px; color: #6b7280;">{{ $client->user->name }}</div>
      </div>
    @endif
    <div style="clear: both;"></div>
  </div>

  {{-- FOOTER --}}
  <div class="footer">
    {{ $companyName }} — {{ date('Y') }} — {{ __('All Rights Reserved') }}
  </div>
</body>

</html>