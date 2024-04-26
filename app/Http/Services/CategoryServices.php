<?php

namespace App\Http\Services;
use App\Models\Category;
use Intervention\Image\Facades\Image;
use Illuminate\Http\Request;
use App\Http\Controllers\Helpers\GeneralHelper;
use App\Models\CategoryImage;
use Illuminate\Support\Facades\Log;
class CategoryServices{
    private $allowed_array = ['jpg', 'jpeg','png'];

    public function getCategories($parent_id=0){
        $cats =   Category::where('parent_id','=',$parent_id)->orderBy('rank', 'ASC') ;
        return  ['data'=>$cats->get(),'count'=>$cats->count()];
    }


    // public function find_lower_cats($cat_id){
    //     return  Category::select('id','name')->where('parent_id','=',$cat_id)->orderBy('rank')->get();
    // }

    public function find_siblings($parent_id){
        return Category::select('id','name','parent_id')->where('parent_id','=',$parent_id)->orderBy('rank')->get();
    }
    
    public function create_icon(Request $request,$slug){

       
        $icon = "";
        $file = $request->file('icon');
       
        if ($request->hasFile('icon')) {
             
            $ext = GeneralHelper::findExtension($file->getClientOriginalName());
            if (in_array($ext, $this->allowed_array)) {
            $path = public_path("files/categories/" . $slug);
            $filename = GeneralHelper::fixName($request['name']) . "_" . date('YmdHis') . "." . GeneralHelper::findExtension($file->getClientOriginalName());
            $file->move($path, $filename);
           
            $path = public_path("files/categories/" . $slug . "/" . $filename);


           $resizedImage = Image::make($path)->resize(100, null, function ($constraint) {
               $constraint->aspectRatio();
           });


            $resizedImage->save(public_path("files/categories/" . $slug . "/100".$filename));
           $icon ="100".$filename;

           }

      }
      return $icon;
    }/// upload icon


    public function upload_multi_files(Request $request,Category $category){
        if ($request->hasFile('multiple_files')) {
        
            $files = $request->file('multiple_files');
            $rank = CategoryImage::where('category_id','=',$category->id)->count() +1;
           
              
            foreach ($files as $file) {
                $ext = GeneralHelper::findExtension($file->getClientOriginalName());
                if (in_array($ext, $this->allowed_array)) {
                $path = public_path("files/categories/" . $category['slug']);
                $filename =  rand(1000,99999). "_" . date('YmdHis') . "." . GeneralHelper::findExtension($file->getClientOriginalName());
                $file->move($path, $filename);
               
                $path = public_path("files/categories/" . $category['slug'] . "/" . $filename);

               $resizedImage = Image::make($path)->resize(200, null, function ($constraint) {
                   $constraint->aspectRatio();
               });


                $resizedImage->save(public_path("files/categories/" . $category['slug'] . "/200".$filename));
               $image200 ="200".$filename;

               $resizedImage = Image::make($path)->resize(50, null, function ($constraint) {
                $constraint->aspectRatio();
            });


             $resizedImage->save(public_path("files/categories/" . $request['slug'] . "/50".$filename));
            $image50 ="50".$filename;
                    CategoryImage::create([
                        'category_id'=>$category['id'],
                        'image'=>$filename,
                        'image200'=> $image200,
                        'image50'=> $image50,
                            'rank'=>$rank

                    ]);
                    $rank++;
               }
            }
             
        }
    }
    
    public $cats_array = [];
    public function getTree($cat_id){
        $this->cats_array[]=(int)$cat_id;
        $sub_cats = Category::where('parent_id','=',$cat_id)->get();
        foreach($sub_cats as $sub_cat){
            $this->getTree($sub_cat['id']);
        }
       
    }

    public function decrese_rank(Category $category){
      // Log::channel('data_check')->info($category->rank.":".$category['parent_id']);
        Category::where('rank', '>=', $category['rank'])
        ->where('id', '!=', $category['id'])
        ->where('parent_id', '=', $category['parent_id'])
        ->decrement('rank', 1);
    }

    public function deleteCategory(Category $category){
        $dir = 'files/categories/'.$category->slug."/";
       if(is_dir($dir)){
        $files = scandir($dir);
        foreach ($files as $file) {
            if ($file != '.' && $file != '..') {
                $filePath = $dir . DIRECTORY_SEPARATOR . $file;
                if(is_file($filePath)){
                    @unlink($filePath);
                    //echo $filePath."<br>";
                }
            }
        }
        rmdir($dir);
        CategoryImage::where('category_id','=',$category->id)->delete();
       }

    }
}
