<?php

namespace App\Http\Controllers;

use App\Http\Services\BlogServices;
use App\Traits\HttpResponses;
use Illuminate\Http\Request;
use App\Models\Blog;
use App\Models\BlogImage;
use App\Models\Category;
use Exception;
use Illuminate\Support\Facades\Auth;
class BlogController extends Controller
{

    use HttpResponses;
    private $service ;
    public function __construct(BlogServices $service){
        $this->service =  $service;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.panel.blogs.index',['blogs'=>Blog::with('category','user')->get()]);
    }
 

    public function check_slug($slug,$id=0 ){
        $ch = Blog::where('slug','=',$slug)->where('id','<>',$id) ->first();
            if($ch){
                return response()->json('bu isimde başka bir blog mevcut');
            }
        
        
        return response()->json("ok");
        }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.panel.blogs.create',['categories'=>Category::all()]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

     
        try{
            
            $icon = $this->service->create_icon($request,$request['slug']);
          
            $blog= Blog::create([
                'title'=>$request['title'],
                'slug'=>$request['slug'],
                'icon'=>$icon,
                'blog'=>$request['blog'],
                'category_id'=>$request['category_id'],
                'user_id'=>Auth::user()->id,
                'youtube_link'=>$request['youtube_link'],
                'prologue'=>$request['prologue']
            ]);
         
        $this->service->upload_multi_files($request,$blog);
            
            return  $this->success([''],"Blog Eklendi" ,201);
        }catch (Exception $e){
           // return response()->json(['error' => $e->getMessage()], 500);
            return  $this->error([''], $e->getMessage() ,500);
        } 
    
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
       
    }

    public function show_image($type='image',$id){
        if($type=='image'){
            $image = BlogImage::find($id);
            $img= 'files/blogs/'.$image->blog()->first()->slug.'/'.$image->image;
        }else{
            $image = Blog::find($id);
            $img= 'files/blogs/'.$image->slug.'/'.substr($image->icon,3);
        }

        return view('admin.panel.blogs.show_image',[ 
            'img'=>$img]);
    }
    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $blog = Blog::with('images','user')->find($id);
        
 
        return view('admin.panel.blogs.update',['categories'=>Category::all(),'blog'=>$blog,'blog_txt'=>str_replace("\"","'",($blog['blog'])),'youtube_link'=>  (!empty($blog['youtube_link'])) ? $this->service->makeYouTube($blog['youtube_link']) : '' ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        try{
            $blog = Blog::find($request['id']);
            if($request['slug']!=$blog['slug']){
                rename(public_path('files/blogs/'.$blog->slug."/"),public_path('files/blogs/'.$request['slug']."/"));
            }
            $icon = $this->service->create_icon($request,$request['slug']);
            if(!empty($icon)  ){
                if( !empty($category['icon'])){
               @unlink(public_path('files/blogs/'.$request['slug']."/".$blog->icon));
                @unlink(public_path('files/blogs/'.$request['slug']."/".substr($blog->icon,3)));
                    }
                $blog->icon = $icon;
               
            }
          
            $blog->title = $request['title'];
            $blog->slug = $request['slug'];
            $blog->category_id = $request['category_id'];
            $blog->blog = $request['blog'];
            $blog->youtube_link = $request['youtube_link'];
            $blog->slug = $request['slug'];
            $blog->prologue = $request['prologue'];
             $blog->save();
          

         
        $this->service->upload_multi_files($request,$blog);
          return  $this->success([''],"Blog Güncellendi" ,200);
        }catch (Exception $e){
           // return response()->json(['error' => $e->getMessage()], 500);
            return  $this->error([''], $e->getMessage() ,500);
        } 
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $blog = Blog::find($request['id']);
       
            $this->service->deleteBlog($blog);
        $blog->delete();
        return redirect()->route('blogs.index');
    }


    public function show_blog_images($blog_id,$img_id=0,$rank=0 ){
       

        if($img_id>0 && $rank>0){
                $img = BlogImage::find($img_id);

                if($rank>$img['rank']){
                    BlogImage::where('id', '!=', $img['id'])
                        ->where('rank','>',$img['rank'])
                        ->where('blog_id','=',$img['blog_id'])
                        ->where('rank','<=',$rank)->decrement('rank',1);
                }else{
                    BlogImage::where('rank','<',$img['rank'])
                        ->where('rank','>=',$rank)
                        ->where('blog_id','=',$img['blog_id'])
                        ->where('id', '!=', $img['id'])
                        ->increment('rank',1);
                }   
                $img->rank = $rank;
                $img->save();

        }////change

        $images = BlogImage::where('blog_id','=',$blog_id);
        return view('admin.panel.blogs.blog_images',[ 
            'count'=>$images->count(),'images'=>$images->orderBy('rank')->get()]);
    }


    public function delete_blog_image($img_id){
        $img = BlogImage::find($img_id);
 
        unlink(public_path('files/blogs/'.$img->blog()->first()->slug."/".$img->image));
        unlink(public_path('files/blogs/'.$img->blog()->first()->slug."/".$img->image200));
        unlink(public_path('files/blogs/'.$img->blog()->first()->slug."/".$img->image50));
        BlogImage:: where('blog_id','=',$img['blog_id'])
        ->where('rank','>=',$img['rank'])->decrement('rank',1);
         $img->delete();
        return response()->json("ok");
    }

}
