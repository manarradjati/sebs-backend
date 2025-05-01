<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // جلب جميع الفئات من قاعدة البيانات
        $categories = Category::all();

        // تعامل مع الفئات هنا (مثلاً إظهارها أو التلاعب بها)
        foreach ($categories as $category) {
            echo $category->name . "\n";  // عرض أسماء الفئات
        }

        // إضافة الفئات إذا كانت غير موجودة مسبقًا
        Category::firstOrCreate(
            ['name' => 'رياضة'], // تحقق من وجود الفئة مسبقًا
            ['description' => 'فئة رياضية']
        );

        Category::firstOrCreate(
            ['name' => 'ترفيه'], // تحقق من وجود الفئة مسبقًا
            ['description' => 'فئة ترفيهية']
        );
    }
}
