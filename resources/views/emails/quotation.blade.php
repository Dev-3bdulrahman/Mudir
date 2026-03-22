<!DOCTYPE html>
<html dir="rtl" lang="ar">

<head>
  <style>
    body {
      font-family: sans-serif;
      line-height: 1.6;
      color: #333;
    }

    .container {
      padding: 20px;
      border: 1px solid #eee;
      border-radius: 10px;
      max-width: 600px;
      margin: auto;
    }

    .header {
      border-bottom: 2px solid #3b82f6;
      padding-bottom: 10px;
      margin-bottom: 20px;
    }

    .footer {
      margin-top: 30px;
      font-size: 12px;
      color: #777;
      border-top: 1px solid #eee;
      padding-top: 10px;
    }
  </style>
</head>

<body>
  <div class="container">
    <div class="header">
      <h2>{{ __('عرض سعر جديد من') }} {{ config('app.name') }}</h2>
    </div>
    <p>{{ __('عزيزنا') }} {{ $quotation->display_name }}،</p>
    <p>{{ __('نتمنى أن تكونوا بخير.') }}</p>
    <p>{{ __('تجدون مرفقاً طيه عرض السعر الخاص بطلبكم رقم') }} <strong>#{{ $quotation->id }}</strong>.</p>
    <p>{{ __('المبلغ الإجمالي:') }} <strong>{{ number_format($quotation->amount, 2) }}
        {{ $quotation->currency }}</strong></p>

    <p>{{ __('إذا كان لديكم أي استفسار، لا تترددوا في الرد على هذا البريد أو التواصل معنا عبر الواتساب.') }}</p>

    <div class="footer">
      <p>{{ __('شكراً لثقتكم بنا.') }}</p>
      <p>{{ config('app.name') }}</p>
    </div>
  </div>
</body>

</html>