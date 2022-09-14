<?php

namespace App\Http\Controllers;

use App\Services\Cart\CartService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class RajaOngkirController extends Controller
{
    private $cartService;
    protected $API_KEY = '68f635cfccebef3edb10c9bf849cbaa1';

    public function __construct(CartService $cartService)
    {
        $this->cartService = $cartService;
    }

    public function getProvince()
    {
        try {
            $response = Http::withHeaders([
                'key' => $this->API_KEY
            ])->get('https://api.rajaongkir.com/starter/province');
            $result = $response['rajaongkir']['results'];
            $statusCode = $response['rajaongkir']['status']['code'];
            $status = true;
        } catch (Exception $e) {
            $result = $e->getMessage();
            $statusCode = 500;
            $status = false;
        }
        return $this->output(status: $status, data: $result, code:$statusCode);
    }

    public function getCities($provinceId)
    {
        try {
            $response = Http::withHeaders([
                'key' => $this->API_KEY
            ])->get('https://api.rajaongkir.com/starter/city?&province='.$provinceId.'');
            $result = $response['rajaongkir']['results'];
            $statusCode = $response['rajaongkir']['status']['code'];
            $status = true;
        } catch (Exception $e) {
            $result = [];
            $statusCode = 500;
            $status = false;
        }

        return $this->output(status: $status, data: $result, code:$statusCode);
    }

    public function checkOngkir(Request $request, $courier)
    {
        // Weight still manual
        $data = [
            'destination' => $request->user()->city_id,
        ];
        
        try {
            $response = Http::withHeaders([
                'key' => $this->API_KEY
            ])->post('https://api.rajaongkir.com/starter/cost', [
                'origin'            => "153",
                'destination'       => $data['destination'],
                'weight'            => "10",
                'courier'           => $courier
            ]);
            $statusCode = $response['rajaongkir']['status']['code'];
            $result = $response['rajaongkir']['results'];
            $status = true;
        } catch (Exception $e) {
            $result = [];
            $statusCode = 500;
            $status = false;
        }

        return $this->output(status: $status, data: $result, code:$statusCode);
    }
}
