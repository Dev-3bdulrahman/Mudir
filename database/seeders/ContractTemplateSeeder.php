<?php

namespace Database\Seeders;

use App\Models\ContractTemplate;
use Illuminate\Database\Seeder;

class ContractTemplateSeeder extends Seeder
{
  /**
   * Run the database seeds.
   */
  public function run(): void
  {
    $templates = [
      [
        'title' => [
          'en' => 'Web Development Agreement',
          'ar' => 'اتفاقية تطوير مواقع إلكترونية',
        ],
        'content' => [
          'en' => [
            'This agreement is made between {{company_name}} (First Party) and {{client_name}} (Second Party).',
            'The First Party shall provide web development services as described in the project proposal.',
            'The total amount for the project is agreed upon as specified in the contract details.',
            'Both parties agree to the terms and conditions set forth in this document.',
            'This contract is valid until {{current_date}} plus project duration.',
          ],
          'ar' => [
            'تم إبرام هذه الاتفاقية بين {{company_name}} (طرف أول) و {{client_name}} (طرف ثاني).',
            'يلتزم الطرف الأول بتقديم خدمات تطوير المواقع الإلكترونية كما هو موضح في مقترح المشروع.',
            'تم الاتفاق على المبلغ الإجمالي للمشروع كما هو محدد في تفاصيل العقد.',
            'يوافق الطرفان على الشروط والأحكام الواردة في هذه الوثيقة.',
            'هذا العقد ساري المفعول حتى {{current_date}} بالإضافة إلى مدة تنفيذ المشروع.',
          ],
        ],
        'is_active' => true,
      ],
      [
        'title' => [
          'en' => 'Social Media Management Contract',
          'ar' => 'عقد إدارة مواقع التواصل الاجتماعي',
        ],
        'content' => [
          'en' => [
            'First Party: {{company_name}}, Second Party: {{client_name}}.',
            'Scope of work includes managing social media accounts, content creation, and monthly reporting.',
            'Service period starts on {{current_date}}.',
            'The Second Party shall provide all necessary access to accounts.',
          ],
          'ar' => [
            'الطرف الأول: {{company_name}}، الطرف الثاني: {{client_name}}.',
            'نطاق العمل يشمل إدارة حسابات التواصل الاجتماعي، صناعة المحتوى، والتقارير الشهرية.',
            'تبدأ فترة الخدمة في {{current_date}}.',
            'يلتزم الطرف الثاني بتوفير كافة صلاحيات الوصول الضرورية للحسابات.',
          ],
        ],
        'is_active' => true,
      ],
    ];

    foreach ($templates as $template) {
      ContractTemplate::create($template);
    }
  }
}
