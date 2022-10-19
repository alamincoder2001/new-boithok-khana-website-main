<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Intervention\Image\Facades\Image;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    // image upload 
    public function imageUpload($request, $image, $directory)
    {
        $doUpload = function ($image) use ($directory) {
            $name = pathinfo($image->getClientOriginalName(), PATHINFO_FILENAME);
            $extention = $image->getClientOriginalExtension();
            $imageName = $name . '_' . uniqId() . '.' . $extention;
            $image->move($directory, $imageName);

            // Image::make($this)->resize(100, 200, function ($constraint) {
            //     $constraint->aspectRatio();
            // });

            return $directory . '/' . $imageName;
        };





        if (!empty($image) && $request->hasFile($image)) {
            $file = $request->file($image);
            if (is_array($file) && count($file)) {
                $imagesPath = [];
                foreach ($file as $key => $image) {
                    $imagesPath[] = $doUpload($image);
                }
                return $imagesPath;
            } else {
                return $doUpload($file);
            }
        }

        return false;
    }
    //

    public function createThumbnail($path, $width, $height)
    {
    }

    public function invoiceGenerate($model, $prefix = '')
    {
        // $date = '2021-10-28 12:27:41';


        // if($model->$date == Carbon::today() ){
        //     $code = "00001";
        //     $model = '\\App\\Models\\' . $model;
        //         $newCode = + 1;
        //         $zeros = ['0', '00', '000', '0000','00000'];
        //         $code = strlen($newCode) > count($zeros) ? $newCode : $zeros[count($zeros) - strlen($newCode)] . $newCode;
        //     return $prefix . $code;
        // }else{


        //     $code = "000001";
        //     $model = '\\App\\Models\\' . $model;
        //     $num_rows = $model::count();
        //     if ($num_rows != 0) {
        //         $newCode = $num_rows + 1;
        //         $zeros = ['0', '00', '000', '0000','00000'];
        //         $code = strlen($newCode) > count($zeros) ? $newCode : $zeros[count($zeros) - strlen($newCode)] . $newCode;
        //     }
        //     return $prefix . $code;
        // }


        // $code = "000001";
        // $model = '\\App\\Models\\' . $model;
        // $num_rows = $model::count();
        // if ($num_rows != 0) {
        //     $newCode = $num_rows + 1;
        //     $zeros = ['0', '00', '000', '0000','00000'];
        //     $code = strlen($newCode) > count($zeros) ? $newCode : $zeros[count($zeros) - strlen($newCode)] . $newCode;
        // }
        // return $prefix . $code;

    }

    public function generateProductCode($model, $prefix = '')
    {
        $code = "000001";
        $model = '\\App\\Models\\' . $model;
        $num_rows = $model::count();
        $count_char = strlen($prefix);
        if($num_rows != 0){
            $last_code = $model::withTrashed()->select('code')->take(1)->first();
            $number = substr($last_code->code, $count_char);
        }

        if ($num_rows != 0) {
            $newCode = $number + 1;
            $zeros = ['0', '00', '000', '0000', '00000'];
            $code = strlen($newCode) > count($zeros) ? $newCode : $zeros[count($zeros) - strlen($newCode)] . $newCode;
        }
        return $prefix . $code;
    }



    public function generateCode($model, $prefix = '')
    {
        $code = "00001";
        $model = '\\App\\Models\\' . $model;
        $num_rows = $model::count();
        if ($num_rows != 0) {
            $newCode = $num_rows + 1;
            $zeros = ['0', '00', '000', '0000'];
            $code = strlen($newCode) > count($zeros) ? $newCode : $zeros[count($zeros) - strlen($newCode)] . $newCode;
        }
        return $prefix . $code;
    }


 
 
}
