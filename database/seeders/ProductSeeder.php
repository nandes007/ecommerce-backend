<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\ProductImage;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Faker\Factory as Faker;

class ProductSeeder extends Seeder
{
    public function run()
    {
        $fake = Faker::create('id_ID');

        $codes = [
            '011194568047',
            '011194558550',
            '5201065463532',
            '6901009370009',
            '045666638334',
            '8888140282421',
            '011194156770',
            '8888140202124',
            '011194173432',
            '8887333090029',
            '011194564407',
            '011194172855',
            '8888140202056',
            '9556041603263',
            '8850649000044',
            '8992726932210',
            '8992726932203',
            '8992717781001',
            '8992726953604',
            '8998288100043',
            '8998288360386',
            '8992726965355',
            '8992726964808',
            '8992726965362',
            '8888192820307',
            '8888192820017',
            '024000010920',
            '071943617655',
            '8888192820758',
            '053800028217',
            '8992917295193',
            '053800298801',
            '8992726898059',
            '8888192820352',
            '8888192820482',
            '8995027201603',
            '8995027201535',
            '8993138231069',
            '8886319511015',
            '8886319511039',
            '690109185757',
            '8997021610023',
            '9556041604727',
            '8433260504001',
            '8433260503004',
            '8433260502007',
            '8433260505008',
            '8992717900129',
            '8992717783616',
            '8992717822209',
            '8997002050350',
            '8997002050367',
            '8997002050374',
            '8992932110372',
            '8410159048976',
            '8410159044336',
            '9310179004923',
            '9310179004992',
            '5201065113536',
            '8886319511046',
            '8992932110501',
            '053800750057',
            '053800750040',
            '053800750095',
            '4892912030116',
            '6921790660158',
            '8992726897366',
            '9310179191197',
            '041580530013',
            '0190016',
            '0190017',
            '0190182',
            '8995001110013',
            '8995001130011',
            '8997218620064',
            '9556041612852',
            '011194384890',
            '9300657035259',
            '9300657009885',
            '9300657006143',
            '9300657006068',
            '011194390242',
            '011194385880',
            '6920611932955',
            '0200848',
            '6901009073603',
            '6901009052028',
            '8888111740006',
            '8888111740013',
            '011194310707',
            '4710063111228',
            '8997218620026',
            '8888140202131',
            '6901009000289',
            '8999005000066',
            '011194362447',
            '073214004027',
            '8888140202803',
            '9556041602198',
            '9556041603409',
            '4892958102884',
            '824690103908',
            '8997218620019',
            '9556041602204',
            '011194367237',
            '024000163015',
            '024000163022',
            '2414636029027'
        ];

        $products = [
            'CHERRY PIE FILLING 12/21OZ',
            'RIPE OLIVE 24/16OZ',
            'MAMMOTH QUEEN OLIVES 12/4,75OZ',
            'FRUIT COCKTAIL 14OZ',
            'LEMON PIE FILLING 12/15,75OZ',
            'CHERRIE MERAH CUP 36/50GR',
            'CHERRIE HIJAU CUP 36/50GR',
            'CHERRIE MERAH W/STEM 24/100GR',
            'CHERRIE HIJAU W/STEM 24/100GR',
            'FRUIT COCKTAIL 24/30OZ',
            'FRUIT COCKTAIL 24/17OZ',
            'FRUIT COCKTAIL 24/565GR',
            'FRUIT COCKTAIL 12/820GR',
            'FRUIT COCKTAIL 24/850GR',
            'FRUIT COCKTAIL 24/565GR',
            'RAMBUTAN PINEAPLE 24/565GR',
            'SLICED PINEAPPLE 24/565GR',
            'M.RED CHERRIES W/STEMS 12/8OZ',
            'APRICOT HALVES 12/15,25OZ',
            'LYCHEE 12/565GR',
            'LONGAN 24/565GR',
            'PEAR HALVES 24/15,25OZ',
            'SEEDLES GRAPE 24/8,25OZ',
            'KOLANG KALING 24/565GR',
            'FRUIT COCKTAIL 24/15 OZ',
            'LITE FRUIT COCKTAIL 24/15OZ',
            'FRUIT COCKTAIL 24/565GR',
            'FRUIT COCKTAIL 24/565GR',
            'FRUIT COCKTAIL 24/850GR',
            'FRUIT COCKTAIL 24/565GR',
            'FRUIT COCKTAIL 24/850GR',
            'RAMBUTAN LONGAN 24/565GR',
            'RAMBUTAN NANAS 24/565GR',
            'SLICED PINEAPPLE 24/15,5OZ',
            'SLICED PINEAPPLE 24/565GR',
            'SALAK BALI 24/565GR',
            'PITTED D.SWEET CHERRI 12/15,5OZ',
            'GREEN CHERRIES 12/8OZ',
            'RED CHERRIES 12/14OZ',
            'BLUEBERRY IN SYRUP 12/15OZ',
            'LONGAN 24/565GR',
            'KING LONGAN 24/565GR',
            'MANDARIN ORANGE 24/11OZ',
            'MANDARIN ORANGE 24/11OZ',
            'PEACH HALVES 12/825GR',
            'PEACH HALVES 24/15,25OZ',
            'PEACH HALVES I/SYRUP 12/29OZ',
            'PEAR HALVES 24/29OZ',
            'STRAWBERRIES I/EX SRP 12/17OZ',
            'SEEDLESS GRAPES 24/15,25OZ',
            'GRAPE 24/425GR',
            'PINEAPPLE SLICED 24/565GR',
            'KOLANG KALING 24/565GR',
            'KOLANG KALING 24/565GR',
            'RAMBUTAN NANAS 24/565GR'
        ];

        $units = [
            'BAG',
            'BAL',
            'BH',
            'BKS',
            'BOX',
            'BP',
            'BTL',
            'COX',
            'CR',
            'CRT',
            'CTN',
            'CUP',
            'DOS',
            'DUS',
            'EKR',
            'GLN',
            'GLS',
            'GP',
            'GRS',
            'HC',
            'HD',
            'IKT',
            'JAR',
            'KDI',
            'KG',
            'KLG',
            'KRJ',
            'LBR',
            'LSN',
            'LYG',
            'PAK',
            'PCK',
            'PCS',
            'PKT',
            'PLS',
            'POT',
            'PPN',
            'PSC',
            'PSG',
            'PTI',
            'RIM',
            'ROL',
            'SAK',
            'SCH',
            'SET',
            'SLP',
            'SSN',
            'SSR',
            'STR',
            'TBE',
            'TIN',
            'TPL',
            'TPS',
            'TUB',
            'UNT',
            'ZAK'
        ];

        $fraction = [
            '24',
            '60',
            '1',
            '1',
            '1',
            '1',
            '1',
            '12',
            '10',
            '12',
            '36',
            '1',
            '1',
            '1',
            '1',
            '1',
            '1',
            '1',
            '144',
            '24',
            '30',
            '20',
            '15',
            '20',
            '1000',
            '1',
            '1',
            '1',
            '12',
            '1',
            '1',
            '12',
            '1',
            '1',
            '10',
            '1',
            '1',
            '1',
            '1',
            '1',
            '1',
            '12',
            '1',
            '1',
            '1',
            '10',
            '1',
            '1',
            '1',
            '1',
            '1',
            '1',
            '1',
            '1',
            '1',
            '1'
        ];

        $flag = [true, false];

        for ($i = 1; $i <= 30; $i++) {
            $code = $fake->unique()->randomElement($codes);
            $product_name = $fake->unique()->randomElement($products);
            $unit = $fake->randomElement($units);
            $frac = $fake->randomElement($fraction);
            $status = $fake->randomElement($flag);
            $data[] = [
                'barcode' => $code,
                'product_name' => $product_name,
                'slug' => Str::slug($product_name),
                'unit' => $unit,
                'fraction' => $frac,
                'status' => $status,
                'unitprice_old' => rand(1, 100) * 1000,
                'unitprice' => $fake->numberBetween(1, 100) * 1000,
                'price_old' => $fake->numberBetween(1, 100) * 1000,
                'price' => $fake->numberBetween(1, 100) * 1000,
                'weight' => $fake->numberBetween(1, 100) * 100,
                'stock' => $fake->numberBetween(1, 100),
                'tax' => $fake->randomElement($flag),
                'description' => $fake->text(100),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ];
        }
        // $product = (new Product())->insert($data);
        Product::insert($data);

        $product = Product::find(1);
        $product->productImages()->saveMany([
            new ProductImage(['path' => 'uploads/images/original/product1.jpg'])
        ]);

        $product = Product::find(1);
        $product->productImages()->saveMany([
            new ProductImage(['path' => 'uploads/images/original/product16.jpg'])
        ]);

        $product = Product::find(2);
        $product->productImages()->saveMany([
            new ProductImage(['path' => 'uploads/images/original/product1.jpg'])
        ]);

        $product = Product::find(3);
        $product->productImages()->saveMany([
            new ProductImage(['path' => 'uploads/images/original/product3.jpg'])
        ]);

        $product = Product::find(4);
        $product->productImages()->saveMany([
            new ProductImage(['path' => 'uploads/images/original/product4.jpg'])
        ]);

        $product = Product::find(5);
        $product->productImages()->saveMany([
            new ProductImage(['path' => 'uploads/images/original/product5.jpg'])
        ]);

        $product = Product::find(6);
        $product->productImages()->saveMany([
            new ProductImage(['path' => 'uploads/images/original/product6.jpg'])
        ]);

        $product = Product::find(7);
        $product->productImages()->saveMany([
            new ProductImage(['path' => 'uploads/images/original/product7.jpg'])
        ]);

        $product = Product::find(8);
        $product->productImages()->saveMany([
            new ProductImage(['path' => 'uploads/images/original/product8.jpg'])
        ]);

        $product = Product::find(9);
        $product->productImages()->saveMany([
            new ProductImage(['path' => 'uploads/images/original/product9.jpg'])
        ]);

        $product = Product::find(10);
        $product->productImages()->saveMany([
            new ProductImage(['path' => 'uploads/images/original/product10.jpg'])
        ]);

        $product = Product::find(11);
        $product->productImages()->saveMany([
            new ProductImage(['path' => 'uploads/images/original/product11.jpg'])
        ]);

        $product = Product::find(12);
        $product->productImages()->saveMany([
            new ProductImage(['path' => 'uploads/images/original/product12.jpg'])
        ]);

        $product = Product::find(13);
        $product->productImages()->saveMany([
            new ProductImage(['path' => 'uploads/images/original/product13.jpg'])
        ]);

        $product = Product::find(14);
        $product->productImages()->saveMany([
            new ProductImage(['path' => 'uploads/images/original/product14.jpg'])
        ]);

        $product = Product::find(15);
        $product->productImages()->saveMany([
            new ProductImage(['path' => 'uploads/images/original/product15.jpg'])
        ]);

    }
}
