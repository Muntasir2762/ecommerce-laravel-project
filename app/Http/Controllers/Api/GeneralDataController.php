<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;

class GeneralDataController extends Controller
{
    public function getGeneralData ()
    {
        try{
            $settings = Setting::first();

            if(!$settings){
                return response()->json([
                    'error' => true,
                    'message' => 'No Data found',
                    'gneralData' => []
                ], 404);
            }

            return response()->json([
                'error' => false,
                'message' => 'General Data Retrived Successfully',
                'gneralData' => $settings
            ], 200);

        } catch(\Exception $e){
            return response()->json([
                'error' => true,
                'message' => 'An Error Occured While Retriving Data',
                'gneralData' => [],
                // 'errorMessage' => $e->getMessage()
            ], 500);
        }
    }
}
