<?php

namespace App\Http\Controllers;

use App\Http\Services\CategoryServices;
use App\Models\CategoryImage;
use App\Traits\HttpResponses;
use Exception;
use Illuminate\Http\Request;
use App\Http\Controllers\Helpers\GeneralHelper;
use App\Models\Category;
use Intervention\Image\Facades\Image;
 

use App\Http\Resources\CategoryResource;

class CategoryController extends Controller
{
    use HttpResponses;
    private $service ;
    public function __construct(CategoryServices $service){
        $this->service =  $service;
    }



    public function index()
    {
        $cats = $this->service->getCategories(0);
        return view('admin.panel.categories.index',['categories'=>$cats['data'],'count'=>$cats['count']]);
    }

    public function create()
    {
        $cats = $this->service->getCategories(0);
        
        return view('admin.panel.categories.create',['categories'=>$cats['data'],'count'=>$cats['count']]);
    }

    
    public function store(Request $request)
    {
         try{
            
        $icon = $this->service->create_icon($request,$request['slug']);
      
        $category= Category::create([
            'name'=>$request['name'],
            'slug'=>$request['slug'],
            'icon'=>$icon,
            'description'=>$request['description'],
            'parent_id'=>0,
            'rank'=>$request['rank']
        ]);
     
    $this->service->upload_multi_files($request,$category);
        
        return  $this->success([''],"Kategori Eklendi" ,201);
    }catch (Exception $e){
       // return response()->json(['error' => $e->getMessage()], 500);
        return  $this->error([''], $e->getMessage() ,500);
    } 

       

    }
    public function check_slug($slug,$id=0 ){
    $ch = Category::where('slug','=',$slug)->where('id','<>',$id) ->first();
        if($ch){
            return response()->json('bu isimde başka bir kategori mevcut');
        }
    
    
    return response()->json("ok");
    }
    
    public function show($id)
    {
        // Show the specified resource
    }

    public function edit( $slug)
    {
        try{
            $cats = $this->service->getCategories(0);
            return view('admin.panel.categories.update',['categories'=>$cats['data'],
            'count'=>$cats['count'],'category'=>Category::where('slug','=',$slug)->first()]);

        }catch(Exception $exception){
            return response()->json( $exception->getMessage());
        }


    }

    public function update(Request $request )
    {
 
        try{
            $category = Category::find($request['id']);


            if($request['slug']!=$category['slug']){
                rename(public_path('files/categories/'.$category->slug."/"),public_path('files/categories/'.$request['slug']."/"));
            }

            $icon = $this->service->create_icon($request,$request['slug']);
            
            if(!empty($icon)  ){
                if( !empty($category['icon'])){
               @unlink(public_path('files/categories/'.$category->slug."/".$category->icon));
                @unlink(public_path('files/categories/'.$category->slug."/".substr($category->icon,3)));
                    }
                $category->icon = $icon;
               
            }
          
      

            $category->name = $request['name'];
            $category->slug = $request['slug'];
            $category->description = $request['description'];
          
            $category->rank = $request['rank'];
             $category->save();
          
         
        $this->service->upload_multi_files($request,$category);
  
            return  $this->success([''],"Kategori Güncellendi" ,200);
        }catch (Exception $e){
           // return response()->json(['error' => $e->getMessage()], 500);
            return  $this->error([''], $e->getMessage() ,500);
        } 
    }

    public function destroy(Request $request)
    {
        try{
          $this->service->getTree($request['id']);
         $categories = Category::with('images')->whereIn('id', $this->service->cats_array)->get();
         foreach($categories as $category){
            $this->service->decrese_rank($category);
            $this->service->deleteCategory($category);
            
         }
         Category::whereIn('id',$this->service->cats_array)->delete();
         return redirect()->route('categories.index');
        }catch (Exception $e){
            // return response()->json(['error' => $e->getMessage()], 500);
             return  $this->error([''], $e->getMessage() ,500);
         } 
        // Remove the specified resource
    }



    public function show_up_categories($cat_id){
        
        $category = Category::select('id','name','parent_id')->find($cat_id);
        $parent_id =  $category['parent_id'];
        $array = ['cat_select_'.$category['parent_id']];
        while($parent_id > 0){
            $category = Category::find($parent_id);
            $parent_id =  $category['parent_id'];
            if($parent_id>0){
            array_push($array,'cat_select_'.$parent_id) ;
            }
        }

        return response()->json( ['data'=> $array]);
    }
    
    public function select_categories($cat_id){
        $array = [];
        $category = Category::select('id','name','parent_id')->find($cat_id);
        $parent_id =  $category['parent_id'];
        $array[]=['categories'=>$this->service->find_siblings($category['parent_id']),'selected'=>$category['id']];
        while($parent_id > 0){
            $category = Category::find($parent_id);
            $parent_id =  $category['parent_id'];
            
            $array[]=['categories'=>$this->service->find_siblings($category['parent_id']),'selected'=>$category['id']];
        }
        $subs=[];
        $sub_cats = Category::select('id','name','parent_id')->where('parent_id','=',$cat_id);
        if($sub_cats->count()>0){
            $subs=['categories'=>$sub_cats->orderBy('rank')->get(),'count'=>$sub_cats->count()];
        }

        return response()->json( ['data'=> array_reverse($array),'sub_categories'=>$subs]);
 
    }
    

    public function show_sub_categories($cat_id){
     //   return response()->json("ok".$cat_id);
     $cats = $this->service->getCategories($cat_id);
     if($cats['count']){
     return view('admin.panel.categories.sub_categories',['categories'=>$cats['data'],'count'=>$cats['count']]);
    }else{
        return "Alt kategori yok";
    }
    }

    public function show_category_images($cat_id,$img_id=0,$rank=0 ){
       

        if($img_id>0 && $rank>0){
                $img = CategoryImage::find($img_id);

                if($rank>$img['rank']){
                    CategoryImage::where('id', '!=', $img['id'])
                        ->where('rank','>',$img['rank'])
                        ->where('category_id','=',$img['category_id'])
                        ->where('rank','<=',$rank)->decrement('rank',1);
                }else{
                    CategoryImage::where('rank','<',$img['rank'])
                        ->where('rank','>=',$rank)
                        ->where('category_id','=',$img['category_id'])
                        ->where('id', '!=', $img['id'])
                        ->increment('rank',1);
                }   
                $img->rank = $rank;
                $img->save();

        }////change

        $images = CategoryImage::where('category_id','=',$cat_id);
        return view('admin.panel.categories.category_images',[ 
            'count'=>$images->count(),'images'=>$images->orderBy('rank')->get()]);
    }


    public function delete_category_image($img_id){
        $img = CategoryImage::find($img_id);
 
        unlink(public_path('files/categories/'.$img->category()->first()->slug."/".$img->image));
        unlink(public_path('files/categories/'.$img->category()->first()->slug."/".$img->image200));
        unlink(public_path('files/categories/'.$img->category()->first()->slug."/".$img->image50));
        CategoryImage:: where('category_id','=',$img['category_id'])
        ->where('rank','>=',$img['rank'])->decrement('rank',1);
         $img->delete();
        return response()->json("ok");
    }

    public function show_image($type='image',$id){
        if($type=='image'){
            $image = CategoryImage::find($id);
            $img= 'files/categories/'.$image->category()->first()->slug.'/'.$image->image;
        }else{
            $image = Category::find($id);
            $img= 'files/categories/'.$image->slug.'/'.substr($image->icon,3);
        }

        return view('admin.panel.categories.show_image',[ 
            'img'=>$img]);
    }

    public function categories_div($cat_id){
        
        $selected_cat = Category::find($cat_id);
        
        $parent_id = $selected_cat['parent_id'];
        $cats_array= [];
        while($parent_id>0){
           
            
            $cat = Category::find($parent_id);
          //  echo $cat['name']."<br>";
            $parent_id = $cat['parent_id'];
                $cats = $this->service->find_siblings($cat['parent_id']);

            $cats_array[] =['cats'=>$cats,'selected'=>$cat['id'],'count'=>count($cats)];
        }
        $cats_array = array_reverse( $cats_array);
         
        
        $up_selected =  ( count( $cats_array))?$cats_array[0]['selected'] :0 ;
       $cats_array = array_splice($cats_array, 1, count($cats_array));
     //   $rank_count = Category::where('parent_id','=', $cats_array[count($cats_array)]['selected'])->count();
 
    $rank_count =  Category::where('parent_id','=',$selected_cat['parent_id'])->count();
   //     return $cats_array ;
      //   return response()->json( $cats_array);
        // die();

        $cats = $this->service->getCategories(0);
        return view('admin.panel.categories.categories_div',['cats_array'=>$cats_array , 'selected_cat'=>$selected_cat,
        'up_selected'=> $up_selected  ,'categories'=>$cats['data'],'count'=>$cats['count'],'rank_count'=>$rank_count]);
 
    }

}
