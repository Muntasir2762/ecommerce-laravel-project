<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Setting;
use App\Models\SubCategory;
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

    public function getCategories ()
    {
        try{
            $categories = Category::with('subCtaegory')->orderBy('name', 'asc')->get();

            if($categories->isEmpty()){
                return response()->json([
                    'error' => true,
                    'message' => 'No Data found',
                    'categories' => []
                ], 404);
            }

            return response()->json([
                'error' => false,
                'message' => 'Categories Retrived Successfully',
                'categories' => $categories
            ], 200);

        } catch(\Exception $e){
            return response()->json([
                'error' => true,
                'message' => 'An Error Occured While Retriving Data',
                'categories' => [],
                // 'errorMessage' => $e->getMessage()
            ], 500);
        }
    }

    public function getSubCategories ()
    {
        try{
            $subCategories = SubCategory::orderBy('name', 'asc')->get();

            if($subCategories->isEmpty()){
                return response()->json([
                    'error' => true,
                    'message' => 'No Data found',
                    'subCategories' => []
                ], 404);
            }

            return response()->json([
                'error' => false,
                'message' => 'Categories Retrived Successfully',
                'subCategories' => $subCategories
            ], 200);

        } catch(\Exception $e){
            return response()->json([
                'error' => true,
                'message' => 'An Error Occured While Retriving Data',
                'subCategories' => [],
                // 'errorMessage' => $e->getMessage()
            ], 500);
        }
    }
}
