<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class RajaOngkirController extends Controller
{
    protected $API_KEY = '68f635cfccebef3edb10c9bf849cbaa1';

    public function getProvince()
    {
        try {
            $response = Http::withHeaders([
                'key' => $this->API_KEY
            ])->get('https://api.rajaongkir.com/starter/province');
            $result = $response['rajaongkir']['results'];
            $statusCode = $response['rajaongkir']['status']['code'];
        } catch (Exception $e) {
            $result = $e->getMessage();
            $statusCode = 500;
        }
        return $this->output(data: $result, code:$statusCode);
    }

    public function getCities($provinceId)
    {
        try {
            $response = Http::withHeaders([
                'key' => $this->API_KEY
            ])->get('https://api.rajaongkir.com/starter/city?&province='.$provinceId.'');
            $result = $response['rajaongkir']['results'];
            $statusCode = $response['rajaongkir']['status']['code'];
        } catch (Exception $e) {
            $result = [];
            $statusCode = 500;
        }

        return $this->output(data: $result, code:$statusCode);
    }
}
