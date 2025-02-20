<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\AboutResource;
use App\Http\Resources\ImageResource;
use App\Http\Resources\SiteInfoResource;
use App\Http\Resources\SliderResource;
use App\Http\Resources\SocialResource;
use App\Http\Resources\VideoResource;
use App\Models\About;
use App\Models\Contact;
use App\Models\Gallery;
use App\Models\SiteInfo;
use App\Models\Slider;
use App\Models\SocialMedia;
use App\Models\Video;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class FullApiController extends Controller
{
   public function data( $data = null, $m = 'success', $status = 200)
   {
       return response()->json([
           'status' => $status,
           'message' => $m,
           'data' => $data,
       ], $status);
   }

   public function siteInfo(): JsonResponse
   {
       $data = SiteInfo::first();
       if(!$data){
           return $this->data(null, 'Ma\'lumot topilmadi.');
       }
       return $this->data(SiteInfoResource::make($data));
   }

    public function about(): JsonResponse
    {
        $data = About::first();
        if(!$data){
            return $this->data(null, 'Ma\'lumot topilmadi.');
        }
        return $this->data(AboutResource::make($data));
    }

    public function slider(): JsonResponse
    {
        $data = Slider::all();
        return $this->data(SliderResource::collection($data));
    }

    public function gallery(): JsonResponse
    {
        $data = Gallery::all();
        return $this->data(ImageResource::collection($data));
    }

    public function social(): JsonResponse
    {
        $data = SocialMedia::all();
        return $this->data(SocialResource::collection($data));
    }

    public function video(): JsonResponse
    {
        $data = Video::all();
        return $this->data(VideoResource::collection($data));
    }

    public function contact(): JsonResponse
    {
        $validator = Validator::make(request()->all(), [
           'name' => 'required',
           'email' => 'required|email',
        ]);
        if ($validator->fails()) {
            return $this->data(null , $validator->errors()->first(), 403);
        }
        Contact::create(request()->all());
        return $this->data(null, 'Muvaffaqiyatli yuborildi!');
    }
}
