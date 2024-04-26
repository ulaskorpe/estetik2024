@extends('admin.panel.main_layout');

@section('css-section')
    <link rel="stylesheet" href="https://cdn.datatables.net/2.0.0/css/dataTables.dataTables.css" />

    <link href='https://fonts.googleapis.com/css?family=Open+Sans:400,600,700,800' rel='stylesheet' type='text/css'>
@endsection
@section('main')
    <div class="breadcrumbs">
        <div class="breadcrumbs-inner">
            <div class="row m-0">
                <div class="col-sm-4">
                    <div class="page-header float-left">
                        <div class="page-title">
                            <h1>Kategori Güncelle</h1>
                        </div>
                    </div>
                </div>
                <div class="col-sm-8">
                    <div class="page-header float-right">
                        <div class="page-title">
                            <button type="button" onclick="window.open('{{ route('categories.index') }}','_self')"
                                class="btn btn-primary">  Kategoriler</button>
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
                            <form class="form" id="category-form" name="category-form"
                                action="{{ route('category-update') }}" method="POST"
                                enctype="multipart/form-data">
                                <input type="hidden" name="_token" id="_token" value="{{ csrf_token() }}">
                                <input type="hidden" name="id" id="id" value="{{ $category['id'] }}">


                                <div class="row form-group">
 
                                    <div class="col col-md-3"><label for="maöe" class="form-control-label">Kategori
                                            Adı</label></div>
                                    <div class="col-12 col-md-9">

                                        <input type="text" id="name" name="name" placeholder="Kategori adı"
                                            value="{{ $category['name'] }}" class="form-control">
                                    </div>
                                </div>
                                <div class="row form-group">
                                    <div class="col col-md-3"><label for="text-input" class=" form-control-label">Etiket
                                            (slug)</label></div>
                                    <div class="col-12 col-md-9">
                                        <span id="slug-span">{{ $category['slug'] }}</span>
                                        <input type="hidden" id="slug" name="slug" placeholder="Text"
                                            value="{{ $category['slug'] }}" class="form-control">
                                    </div>
                                </div>


                                <div class="row form-group">
                                    <div class="col col-md-3"><label for="description"
                                            class=" form-control-label">Açıklama</label></div>
                                    <div class="col-12 col-md-9">
                                        <textarea name="description" id="description" rows="9" placeholder="açıklama..." class="form-control">{{$category['description']}}</textarea>
                                    </div>
                                </div>
                                <div id="categories_div"> </div>



                                <div class="row form-group">
                                    <div class="col col-md-3"><label for="file-input" class=" form-control-label">Kategori
                                            Resmi</label></div>
                                    <div class="col-12 col-md-9"><input type="file" id="icon" name="icon"
                                            class="form-control-file"></div>
                                </div>
                                <div class="row form-group">
                                    <div class="col col-md-3"><label for="file-multiple-input"
                                            class=" form-control-label">Diğer resimler</label></div>
                                    <div class="col-12 col-md-9"><input type="file" id="multiple_files"
                                            name="multiple_files[]" multiple="" class="form-control-file"></div>
                                </div>
                                @if($category->icon)
                                <div class="row form-group" id="preview_pic" >
                                    <div class="col col-md-3"></div>
                                    <div class="col-12 col-md-9">
                                        <a href="#" data-toggle="modal" data-target="#mediumModal" onclick="show_image('icon',{{$category->id}})">
                                        <img id="previewImage" src="{{url('/files/categories/'.$category->slug.'/'.$category->icon)}}" alt="Preview Image"
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
                                            class="btn btn-primary">Güncelle</button></div>
                                </div>
                            </form>
                        </div>
                        <div class="card-footer">

                        </div>
                    </div>
                    <div class="card">

                        <div class="card-body card-block">
                            <div id="category-images">
                            
                        </div>
                    </div>
                </div>


            </div>
        </div><!-- .animated -->
    </div><!-- .content -->
@endsection

@section('scripts')
<script type="text/javascript" src="{{ url('assets/js/categories.js') }}"></script>
    <script type="text/javascript">
        $(function() {
            bring_images();
            bring_cats();
        //    alert("{{$category['parent_id']}}")
        //   select_cat({{$category['parent_id']}});
           // rankSelect({{ $count }});
        });
        $('#category-form').submit(function(e) {
            e.preventDefault();
            var error = false;
            var formData = new FormData(this);
        });

        async function show_image(type='image',id){
        await $.get('/admin-panel/categories/show-image/'+type+'/'+id , function(data, status) {
              
              $("#mediumModalBody").html(data);
          });
    
     
          }
        async function bring_cats(image_id=0,rank=0){
        await $.get('/admin-panel/categories/categories-div/'+{{$category->id}} , function(data, status) {
              
              $("#categories_div").html(data);
          });
    
     
          }

    async function bring_images(image_id=0,rank=0){
        await $.get('/admin-panel/categories/show-category-images/'+{{$category->id}}+"/"+image_id+"/"+rank , function(data, status) {
              
              $("#category-images").html(data);
          });
    
     
    }

        document.getElementById('icon').addEventListener('change', function(event) {
           
            const file = event.target.files[0];
            const reader = new FileReader();

            reader.onload = function(e) {
                document.getElementById('previewImage').src = e.target.result;
                $('#preview_pic').show();
            };

            reader.readAsDataURL(file);
        });

        document.getElementById('name').addEventListener('input', function(event) {
            // This function will be called whenever the text input changes
            let slug = slugify($('#name').val());
            $('#slug').val(slug);
            $('#slug-span').html(slug);

        });

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

                         $.get('/admin-panel/categories/delete-category-image/'+image_id , function(data, status) {
                            if(data=="ok"){
                                bring_images();
                            }
                        
                        });
                    }
                });
            }



async function formSubmit() {

let error = false;
if ($('#name').val() == '') {

    $('#name').focus();
    Swal.fire({
        icon: 'error',
        text: 'kategori adı giriniz'
    });

    error = true;
    return false;
} else {
//console.log('/admin-panel/categories/check-slug/' + $('#slug').val()+'/'+{{$category['id']}});
    const response = await fetch('/admin-panel/categories/check-slug/' + $('#slug').val()+'/'+{{$category['id']}});
    const data = await response.json();
    if (data !== 'ok') {
        Swal.fire({
            icon: 'error',
            text: data
        });
        $('#name').val('');
        $('#name').focus();
        error = true;
        return false;
    }

}

//console.log(error);
var formData = new FormData(document.getElementById('category-form'));
console.log(formData);
save(formData, '/admin-panel/categories/update', '', '');
 
setTimeout(() => {
    window.open("/admin-panel/categories/", "_self")
}, 2000);

}
    </script>


   
@endsection
