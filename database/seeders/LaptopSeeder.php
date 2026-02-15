<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Laptop;
use Illuminate\Support\Facades\DB;

class LaptopSeeder extends Seeder
{
    public function run(): void
    {
        $file = database_path('data/laptops_1.csv');
        $handle = fopen($file, 'r');
        
        // تخطي السطر الأول (العناوين)
        fgetcsv($handle);

        // مسح البيانات القديمة لتجنب التكرار
        DB::table('laptops')->truncate();

        while (($data = fgetcsv($handle, 0, ",")) !== FALSE) {
            Laptop::create([
                'category'               => $data[0],
                'name'                   => $data[1],
                'url'                    => $data[2],
                'price'                  => $data[3],
                'rating'                 => $data[4],
                'reviews_count'          => $data[5],
                'image_url'              => $data[6],
                'description'            => $data[7],
                'brand'                  => $data[8],
                'color'                  => $data[9],
                'laptop_type'            => $data[10],
                'processor_brand'        => $data[11],
                'processor_model'        => $data[12],
                'ram_gb'                 => $data[13],
                'ram_type'               => $data[14],
                'gpu_brand'              => $data[15],
                'gpu_model'              => $data[16],
                'has_dedicated_gpu'      => $data[17],
                'storage_gb'             => $data[18],
                'storage_type'           => $data[19],
                'screen_size'            => $data[20],
                'display_type'           => $data[21],
                'touchscreen'            => $data[22],
                'weight_kg'              => $data[23],
                'battery_whr'            => $data[24],
                'os'                     => $data[25],
                'good_for_gaming'        => $data[26],
                'good_for_video_editing' => $data[27],
                'good_for_programming'   => $data[28],
                'good_for_students'      => $data[29],
                'good_for_business'      => $data[30],
            ]);
        }
        fclose($handle);
    }
}