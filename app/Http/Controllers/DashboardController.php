<?php

namespace App\Http\Controllers;

use App\Models\Visitor;
use App\Models\Tenant;
use App\Models\Partner;
use App\Models\Media;
use App\Models\Contact;
use App\Models\Story;
use App\Models\VendorCategory;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function getStats()
    {
        return response()->json([
            'visitors'   => Visitor::count(),
            'tenants'    => Tenant::count(),
            'partners'   => Partner::count(),
            'media'      => Media::count(),
            'contacts'   => Contact::count(),
            'stories'    => Story::count(),
            'categories' => VendorCategory::count(),
        ]);
    }
}