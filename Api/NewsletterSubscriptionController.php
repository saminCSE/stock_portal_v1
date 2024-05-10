<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\NewsletterSubscription;
use Illuminate\Http\Request;
use App\Http\Requests\NewsletterRequest;

class NewsletterSubscriptionController extends Controller
{
    public function subscribe(NewsletterRequest $request)
    {
        $formdata = [
            'email' => $request->email,
          ];
          $data = NewsletterSubscription::create($formdata);
          $data['success'] = 'Thank you for subscribing.';
          return response()->json($data, 200);
    }
}
