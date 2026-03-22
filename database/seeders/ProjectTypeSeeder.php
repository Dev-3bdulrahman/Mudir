<?php

namespace Database\Seeders;

use App\Models\Project;
use App\Models\ProjectType;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class ProjectTypeSeeder extends Seeder
{
  /**
   * Run the database seeds.
   */
  public function run(): void
  {
    // 1. Clean up existing types to prevent duplicates
    // Disable foreign key checks for safety during truncation
    DB::statement('SET FOREIGN_KEY_CHECKS=0;');
    ProjectType::truncate();
    DB::statement('SET FOREIGN_KEY_CHECKS=1;');

    // 2. Define independent, clean Project Types
    $defaults = [
      [
        'slug' => 'web-development',
        'name' => ['en' => 'Web Development', 'ar' => 'تطوير المواقع'],
        'color' => '#3b82f6',
        'icon' => 'globe'
      ],
      [
        'slug' => 'mobile-apps',
        'name' => ['en' => 'Mobile Apps', 'ar' => 'تطبيقات الجوال'],
        'color' => '#8b5cf6',
        'icon' => 'smartphone'
      ],
      [
        'slug' => 'graphics-design',
        'name' => ['en' => 'Graphics Design', 'ar' => 'التصميم الجرافيكي'],
        'color' => '#f59e0b',
        'icon' => 'palette'
      ],
      [
        'slug' => 'social-media',
        'name' => ['en' => 'Social Media Management', 'ar' => 'إدارة مواقع التواصل'],
        'color' => '#ec4899',
        'icon' => 'share-2'
      ],
      [
        'slug' => 'devops',
        'name' => ['en' => 'Servers & DevOps', 'ar' => 'السيرفرات والعمليات'],
        'color' => '#10b981',
        'icon' => 'server'
      ],
      [
        'slug' => 'n8n-automation',
        'name' => ['en' => 'Workflow Automation', 'ar' => 'أتمتة سير العمل'],
        'color' => '#f97316',
        'icon' => 'zap'
      ],
      [
        'slug' => 'other',
        'name' => ['en' => 'General / Other', 'ar' => 'عام / أخرى'],
        'color' => '#6b7280',
        'icon' => 'more-horizontal'
      ],
    ];

    foreach ($defaults as $type) {
      ProjectType::create([
        'slug' => $type['slug'],
        'name' => $type['name'],
        'color' => $type['color'],
        'icon' => $type['icon'],
        'is_active' => true,
      ]);
    }

    // 3. Map existing projects (if any)
    $projects = Project::whereNull('project_type_id')->get();
    foreach ($projects as $project) {
      $typeSlug = match ($project->type) {
        'web' => 'web-development',
        'devops' => 'devops',
        'content' => 'graphics-design',
        'social_media' => 'social-media',
        'n8n' => 'n8n-automation',
        default => 'other',
      };

      $type = ProjectType::where('slug', $typeSlug)->first();
      if ($type) {
        $project->update(['project_type_id' => $type->id]);
      }
    }
  }
}
