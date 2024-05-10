<?php

namespace App\Repositories;

use File;
use Image;


class ImageUploadRepo
{
    public static function uploadImage($path, $image, $dimension, $existing_path = null,$resize = false,$thumb_path= '')
    {
      
        $database_image_path = '';
        if (!File::exists($path)) {
            File::makeDirectory($path, 0777, true, true);
        }

        if (File::exists($path)) {
            //remove existing image when update operation
            if (!empty($existing_path)) {
                $existing_image = public_path().'/'.$existing_path;
                if (file_exists($existing_image)) {
                    //first unlink the image
                    @unlink($existing_image);
                }
            }

            $databasePath = str_replace(public_path().'/', '',$path);
           

           
           // $image_name = 'icab-'.uniqid().'-'.time().'.'.$image->getClientOriginalExtension();
            $image_name = 'sheba-'.uniqid().'-'.time().'.'.$image->extension();
            $image_path =$path.$image_name;
            
          

            if($resize) {
                $database_image_path = '';
                if (!File::exists($thumb_path)) {
               File::makeDirectory($thumb_path, 0777, true, true);
                }
                $thumb_image_path = $thumb_path . $image_name;
                list($width, $height) = explode('-',$dimension);
                Image::make($image->getRealPath())->resize($width, $height)->save($thumb_image_path);
               // $image->move($thumb_path, $thumb_image_path);
            }
            $image->move($path, $image_path);
            $database_image_path=$image_name;
        }
        return $database_image_path;
    }
    
    public static function uploadVideo($path, $video, $existing_path = null)
    {
        
            $database_video_path = '';
            $databasePath = str_replace(public_path().'/', '',$path);
           
            $video_name = 'sheba-'.uniqid().'-'.time().'.'.$video->getClientOriginalExtension();
            $video_path=$path . $video_name;
            /*Image::make($image->getRealPath())->resize($width, $height)->save($image_path);*/
            /*dd($image_path);*/
            $video->move($path, $video_path);
            $database_video_path=$databasePath.$video_name;
        
        return $database_video_path;
    }

    public static function uploadPDF($path, $pdf)
    {
        
            $database_pdf_path = '';
        

        

            $databasePath = str_replace(public_path().'/', '',$path);
           
            $pdf_name = 'sheba-'.uniqid().'-'.time().'.'.$pdf->getClientOriginalExtension();
            $pdf_path=$path . $pdf_name;
            /*Image::make($image->getRealPath())->resize($width, $height)->save($image_path);*/
            /*dd($image_path);*/
            $pdf->move($path, $pdf_path);
            $database_pdf_path=$databasePath.$pdf_name;
        
        return $database_pdf_path;
    }

    public static function unlinkPath($image)
    {
        $image_path = public_path() . '/uploads/news/large/' . $image;
        if (file_exists($image_path)) {
            //first unlink the image
            @unlink($image_path);
        }
        return true;
    }

    public static function deleteDirectory($folder)
    {
        $path = public_path().'/uploads/'.$folder;
        //dd($path);
        if (File::exists($path)){
            File::deleteDirectory($path);
        }
        return true;
    }
}