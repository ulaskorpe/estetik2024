@extends('admin.panel.main_layout');

@section('css-section')
<link rel="stylesheet" href="{{url('richtexteditor/rte_theme_default.css')}}" />
<script type="text/javascript" src="{{url('richtexteditor/rte.js')}}"></script>
<script type="text/javascript" src="{{url('richtexteditor/plugins/all_plugins.js')}}"></script>
@endsection
@section('main')
 
    <div class="breadcrumbs">
        <div class="breadcrumbs-inner">
            <div class="row m-0">
                <div class="col-sm-4">
                    <div class="page-header float-left">
                        <div class="page-title">
                            <h1>Blog Güncelle</h1>
                        </div>
                    </div>
                </div>
                <div class="col-sm-8">
                    <div class="page-header float-right">
                        <div class="page-title">
                            <button type="button" onclick="window.open('{{ route('blogs.index') }}','_self')"
                                class="btn btn-primary">  Bloglar</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="content">
        <div class="animated fadeIn">
            <div class="row">
             
                <div class="col-lg-12">
                    <div class="card">
                        
                        <div class="card-body card-block">
                            <form class="form" id="blog-form" name="blog-form"
                                action="{{ route('blogs-update') }}" method="post" enctype="multipart/form-data">
 

                                <input type="hidden" name="_token" id="_token" value="{{ csrf_token() }}">
                                <input type="hidden" name="id" id="id" value="{{ $blog['id'] }}">
                                <div class="row form-group">
                                    <div class="col col-md-3"><label for="maöe" class="form-control-label">Yazar 
                                            Adı</label></div>
                                    <div class="col-12 col-md-9">

                                       {{$blog->user()->first()->name}}
                                    </div>
                                </div>

                                <div class="row form-group">
                                    <div class="col col-md-3"><label for="maöe" class="form-control-label">Blog
                                            Adı</label></div>
                                    <div class="col-12 col-md-9">

                                        <input type="text" id="title" name="title" placeholder="Blog adı" value="{{ $blog['title'] }}"
                                            class="form-control">
                                    </div>
                                </div>
                                <div class="row form-group">
                                    <div class="col col-md-3"><label for="text-input" class=" form-control-label">Etiket
                                            (slug)</label></div>
                                    <div class="col-12 col-md-9">
                                        <span id="slug-span">{{$blog['slug']}}</span>
                                        <input type="hidden" id="slug" name="slug" placeholder="Text" value="{{ $blog['slug'] }}"
                                            class="form-control">
                                    </div>
                                </div>


                                <div class="row form-group">
                                    <div class="col col-md-3"><label for="description"
                                            class=" form-control-label">Ön Yazı</label></div>
                                    <div class="col-12 col-md-9">
                                        <input type="text" name="prologue" id="prologue"  value="{{ $blog['prologue'] }}"
                                        placeholder="önyazı..." class="form-control" ></input>
                                    </div>
                                </div>
                                <div class="row form-group">
                                    <div class="col col-md-12">
                                        <input type="hidden" name="blog" id="blog">
                                        <div id="div_editor1"> </div>
                                    </div>
                                </div>
                                <div class="row form-group">
                               
                                    <div class="col col-md-3"><label for="select" class=" form-control-label">Kategori:</label></div>
                                    <div class="col-12 col-md-9">
                                        <select name="category_id" id="category_id" class="form-control"
                                        >
                                     
                                        @foreach ($categories as $cat)
                                            <option value="{{ $cat['id'] }}" @if($blog['category_id']==$cat['id']) selected @endif>{{ $cat['name'] }}</option>
                                        @endforeach
                                    </select>
                                        
                                    </div>
                                </div>
                                <div class="row form-group">
                                    <div class="col col-md-3"><label for="description"
                                            class=" form-control-label">Youtube Video</label></div>
                                    <div class="col-12 col-md-9">
                                        <input type="text" name="youtube_link" id="youtube_link"  value="{{$blog['youtube_link']}}"
                                        placeholder="https://www.youtube.com/watch?v...." class="form-control" ></input>
                                    </div>
                                </div>
                              @if(!empty($blog['youtube_link']))
                              <div class="row form-group">
                                <div class="col col-md-12"> 
                             
                                    <iframe width="100%" height="315" src="https://www.youtube.com/embed/{{$youtube_link}}" frameborder="0" allowfullscreen></iframe>
                                </div>
                            </div>
                        
                              @endif


                                <div class="row form-group">
                                    <div class="col col-md-3"><label for="file-input" class=" form-control-label">Blog
                                            Resmi</label></div>
                                    <div class="col-12 col-md-9"><input type="file" id="icon" name="icon"
                                            class="form-control-file"></div>
                                </div>
                                <div class="row form-group">
                                    <div class="col col-md-3"><label for="file-multiple-input"
                                            class=" form-control-label">Diğer Resimler</label></div>
                                    <div class="col-12 col-md-9"><input type="file" id="multiple_files"
                                            name="multiple_files[]" multiple="" class="form-control-file"></div>
                                </div>
                                @if($blog->icon)
                                <div class="row form-group" id="preview_pic" >
                                    <div class="col col-md-3"></div>
                                    <div class="col-12 col-md-9">
                                        <a href="#" data-toggle="modal" data-target="#mediumModal" onclick="show_image('icon',{{$blog->id}})">
                                        <img id="previewImage" src="{{url('/files/blogs/'.$blog->slug.'/'.$blog->icon)}}" alt="Preview Image"
                                            style="max-width: 300px">
                                        </a>
                                    </div>
                                </div>
                                @else
                                <div class="row form-group" id="preview_pic" style="display: none">
                                    <div class="col col-md-3"></div>
                                    <div class="col-12 col-md-9">
                                        <img id="previewImage" src="#" alt="Preview Image"
                                            style="max-width: 300px">
                                    </div>
                                </div>
                                @endif
                              
                                <div class="row form-group">
                                    <div class="col col-md-3"><label for="file-multiple-input"
                                            class=" form-control-label"></label></div>
                                    <div class="col-12 col-md-9"><button onclick="formSubmit()"
                                            class="btn btn-primary" onmouseover="fillblog()">Güncelle</button></div>
                                </div>
                            </form>
                        </div>
                        <div class="card-footer">
<textarea id="tmptxt" style="display: none">{{$blog_txt}}</textarea>
                        </div>
                        <div class="card">

                            <div class="card-body card-block">
                                <div id="blog-images">
                                
                            </div>
                        </div>
                    </div>

                </div>


            </div>
        </div><!-- .animated -->
    </div><!-- .content -->
@endsection

@section('scripts')
<script type="text/javascript">

async function show_image(type='image',id){
        await $.get('/admin-panel/blogs/show-image/'+type+'/'+id , function(data, status) {
              
              $("#mediumModalBody").html(data);
          });
    
     
          }

	var editor1cfg = {}
	editor1cfg.toolbar = "basic";
	//var editor1 = new RichTextEditor("#div_editor1", editor1cfg);
	var editor1 =  new RichTextEditor("#div_editor1", { skin: "rounded-corner", toolbar: "default" });
 
    $(document).ready(function() {
        bring_images();
        editor1.setHTMLCode($('#tmptxt').val());
    });

    async function bring_images(image_id=0,rank=0){
        await $.get('/admin-panel/blogs/show-blog-images/'+{{$blog->id}}+"/"+image_id+"/"+rank , function(data, status) {
              
              $("#blog-images").html(data);
          });
    
     
    }

    function deleteImage(image_id) {
                Swal.fire({
                    text: 'Resim silinecek silinecek, emin misin?',
                    //text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Evet',
                    cancelButtonText: 'Hayır'
                }).then((result) => {

                    if (result.isConfirmed) {

                         $.get('/admin-panel/blogs/delete-blog-image/'+image_id , function(data, status) {
                            if(data=="ok"){
                                bring_images();
                            }
                        
                        });
                    }
                });
            }

function fillblog(){
    var content =editor1.getHTMLCode();//= editor1.get('div_editor1').getContent();
    document.getElementById('blog').value =content;
}
 

$('#blog-form').submit(function(e) {
    e.preventDefault();
    var error = false;
    var formData = new FormData(this);
    formData.append('additionalData', 'value');
});


document.getElementById('icon').addEventListener('change', function(event) {
    const file = event.target.files[0];
    const reader = new FileReader();

    reader.onload = function(e) {
        document.getElementById('previewImage').src = e.target.result;
        $('#preview_pic').show();
    };

    reader.readAsDataURL(file);
});

document.getElementById('title').addEventListener('input', function(event) {
    // This function will be called whenever the text input changes
    let slug = slugify($('#title').val());
    $('#slug').val(slug);
    $('#slug-span').html(slug);

});
 
async function formSubmit() {

let error = false;
if ($('#title').val() == '') {

    $('#title').focus();
    Swal.fire({
        icon: 'error',
        text: 'Blog başlığı giriniz'
    });

    error = true;
    return false;
} else {

    const response = await fetch('/admin-panel/blogs/check-slug/' + $('#slug').val()+'/'+{{$blog['id']}});
    const data = await response.json();
    if (data !== 'ok') {
        Swal.fire({
            icon: 'error',
            text: data
        });

        error = true;
        return false;
    }

}



if ($('#prologue').val() == '') {

$('#prologue').focus();
Swal.fire({
    icon: 'error',
    text: 'Blog önyazı giriniz'
});



error = true;
return false;
} 

if ($('#blog').val().length < 30) {

$('#div_editor1').focus();
Swal.fire({
    icon: 'error',
    text: 'Blog  giriniz'
});



error = true;
return false;
} 
if ($('#category_id').val() == '0') {

$('#category_id').focus();
Swal.fire({
    icon: 'error',
    text: 'kategori seçiniz'
});



error = true;
return false;
} 



if ($('#youtube_link').val() != '' ) {
    if(doesNotStartWithYouTube($('#youtube_link').val())){
 
$('#youtube_link').focus();
$('#youtube_link').val('');
Swal.fire({
    icon: 'error',
    text: 'geçerli bir youtube linki giriniz'
});

error = true;
return false;
    }
} 

//console.log(error);
var formData = new FormData(document.getElementById('blog-form'));
console.log(formData);
save(formData, '/admin-panel/blogs/update', '', '');
 
setTimeout(() => {
    window.open("/admin-panel/blogs/", "_self")
}, 2000);

}
function doesNotStartWithYouTube(str) {
    return !str.startsWith("https://www.youtube.com/");
}
    
    
    </script>


    <script type="text/javascript" src="{{ url('assets/js/categories.js') }}"></script>
@endsection
