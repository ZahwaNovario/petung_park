<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Http\Request;
use App\Models\Generic;

class FooterServiceProvider extends ServiceProvider
{
    public function boot()
    {
        // Prevent execution during migrations, seeding, or CLI commands
        if ($this->app->runningInConsole()) {
            return;
        }

        $footerData = Generic::where('status', 1)->get();
        $footerInfo = [
            'instagram' => null,
            'whatsapp' => null,
            'tiktok' => null,
            'alamat' => null,
            'youtube' => null,
            'websiteDesa' => null,
        ];

        // Loop through the data and assign values
        foreach ($footerData as $item) {
            switch ($item->key) {
                case 'sosial_media_instagram':
                    $footerInfo['instagram'] = $item->value; 
                    $footerInfo['instagram_logo'] = $item->icon_picture_link; 
                    break;
                case 'kontak_whatsapp':
                    $footerInfo['whatsapp'] = $item->value; 
                    $footerInfo['whatsapp_logo'] = $item->icon_picture_link; 
                    break;
                case 'sosial_media_tiktok':
                    $footerInfo['tiktok'] = $item->value; 
                    $footerInfo['tiktok_logo'] = $item->icon_picture_link; 
                    break;
                case 'sosial_media_youtube':
                    $footerInfo['youtube'] = $item->value; 
                    $footerInfo['youtube_logo'] = $item->icon_picture_link;
                    break;
                case 'link_tautan_website_desa':
                    $footerInfo['websiteDesa'] = $item->value; 
                    break;
                case 'alamat_petung_park_trawas':
                    $footerInfo['alamat'] = $item->value; 
                    break;
            }
        }

        view()->share('footerInfo', $footerInfo);
    }

    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }
}
