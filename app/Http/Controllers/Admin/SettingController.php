<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use App\Models\WebsitePolicy;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function manageSetting ()
    {
        $websiteSettings = Setting::first();
        return view('admin.settings.website-settings', compact('websiteSettings'));
    }

    public function updateSetting (Request $request)
    {
        $websiteSettings = Setting::first();

        $websiteSettings->phone = $request->phone;
        $websiteSettings->email = $request->email;
        $websiteSettings->address = $request->address;
        $websiteSettings->facebook = $request->facebook;
        $websiteSettings->twitter = $request->twitter;
        $websiteSettings->instagram = $request->instagram;
        $websiteSettings->youtube = $request->youtube;

        if(isset($request->logo)){

            if($websiteSettings->logo && file_exists('admin/settings/'.basename($websiteSettings->logo))){
                unlink('admin/settings/'.basename($websiteSettings->logo));
            }

            $image = $request->file('logo');
            $imageName = rand().'.'.$image->getClientOriginalExtension(); //4347657.jpg
            $image->move('admin/settings', $imageName);

            $websiteSettings->logo = url('admin/settings/'.$imageName); //http://127.0.0.1:8000/admin/settings/4347657.jpg
        }

        if(isset($request->hero_image)){

            if($websiteSettings->hero_image && file_exists('admin/settings/'.basename($websiteSettings->hero_image))){
                unlink('admin/settings/'.basename($websiteSettings->hero_image));
            }

            $imageHero = $request->file('hero_image');
            $imageNameHero = rand().'.'.$imageHero->getClientOriginalExtension(); //4347657.jpg
            $imageHero->move('admin/settings', $imageNameHero);

            $websiteSettings->hero_image = url('admin/settings/'.$imageNameHero); //http://127.0.0.1:8000/admin/settings/4347657.jpg
        }

        $websiteSettings->save();

        toastr()->success('Updated successfully');
        return redirect()->back();
    }

    public function managePolicy ()
    {
        $policyData = WebsitePolicy::first();
        return view('admin.settings.website-policy', compact('policyData'));
    }

    public function updatePolicy (Request $request)
    {
        $policyData = WebsitePolicy::first();

        $policyData->privacy_policy = $request->privacy_policy;
        $policyData->terms_conditions = $request->terms_conditions;
        $policyData->refund_policy = $request->refund_policy;
        $policyData->payment_policy = $request->payment_policy;
        $policyData->about_us = $request->about_us;

        $policyData->save();

        toastr()->success('Policy updated successfully');
        return redirect()->back();
    }
}
