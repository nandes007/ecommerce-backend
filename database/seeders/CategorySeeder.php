<?php

namespace Database\Seeders;

use App\Models\Category;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Faker\Factory as Faker;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run()
    {
        $fake = Faker::create('id_ID');
        $categories = [
            'Buah Dalam Kaleng/Botol',
            'Sayuran Dlm Kaleng/Botol',
            'Daging Dalam Kaleng',
            'Sea Food Dalam Kaleng',
            'Juice Buah Buahan',
            'Syrup',
            'Soft Drink',
            'Bier Dalam Kaleng/Botol',
            'Susu Kaleng & Pack',
            'Jam, Meisis Dan Madu',
            'Sauce,Kecap Dan Sambel',
            'Spices & Herb Olahan',
            'Soups',
            'Cake Make & Cake Decorati',
            'Kopi',
            'Cereal & Havermouth',
            'Biji Bijian Lokal',
            'Minyak Goreng',
            'Frecook Gelael',
            'Wafer & Biscuit',
            'Salties Pabrikan',
            'Cookies Kering',
            'Coklat Bar',
            'Permen & Jelly',
            'Mie Instant Noodle',
            'Mie Kering/Macaroni&Spght',
            'Ikan Asin',
            'Daging Kering & Kerupuk',
            'Telor',
            'Napkins & Pembungkus',
            'Tissue',
            'Kapas & Pembalut',
            'Sabun Mandi',
            'Kosmetika',
            'Perfum & Deodorant',
            'Shampo & Conditioner',
            'Pasta Gigi',
            'Hair Brush/Sisir',
            'Shaving & Foam',
            'Sabun Cuci',
            'Desinfektant',
            'Pemelihara & Pembersih',
            'Air Fresher & Kampir',
            'Akssrs Mbl & Prltn Tkng',
            'Keperluan Hewan',
            'Greneries/Kep Tumbuhan',
            'Batu Batery',
            'Transaksi Cntr Bon',
            'Salties Home Industries',
            'Obat-Obatan & Vitamin',
            'Perlengkapan Tobacco',
            'Tobacco',
            'Wine & Spirits',
            'Sayur Segar',
            'Beef/Chckn Sausages&Brgr',
            'Sayuran Prozeen',
            'Margarine & Mentega',
            'Spices & Herb Biji',
            'Ice Cream',
            'Jap/Korean/Taiwan Food',
            'Diatetic & Diabetic Food',
            'Preserved Fruits & Vetabl',
            'Baby Food',
            'Stationary/Hiasan & Gmbr',
            'Gelael Prcl & Prdc Banded',
            'Baby Supply Non Food',
            'Baby Care',
            'Gelael Cafe',
            'Brg Rmt Tangga Non Elctrc',
            'Glass Ware',
            'Keramik Ware',
            'Plastik/Melamin Ware',
            'Brg Rmh Tangga Elctrc',
            'Organic',
            'Sikat Gigi',
            'Talc Powder',
            'Hair Care',
            'Stainless & Aluminium',
            'Soft Goods',
            'Pork Meat Segar',
            'Buah Segar Lokal',
            'Buah Segar Import',
            'Biji Bijian Import',
            'Gula',
            'Gula Olahan',
            'Teh & Minumn Penghngt',
            'Minuman Berenergi',
            'Dressing',
            'Susu Segar &Yoghurt',
            'Keju & Whipping Cream',
            'Sea Food Segar',
            'Poultry / Ayam Segar',
            'Dog Food Gelael',
            'Daging Segar',
            'Pork Meat Olahan',
            'Bakery & Pastry Gelael',
            'Kue Basah Supplier',
            'Wet Market'
        ];


        for ($i = 1; $i <= 20; $i++) {
            $name = $fake->randomElement($categories);
            $data[] = [
                'name' => $name,
                'slug' => Str::slug($name),
                'parent_id' => rand(1, 10),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ];
        }
        (new Category())->insert($data);
    }
}
