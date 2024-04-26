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
                            <h1>Kategori Ekle</h1>
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
                                action="{{ route('categories.store') }}" method="post" enctype="multipart/form-data">
                                <input type="hidden" name="_token" id="_token" value="{{ csrf_token() }}">


                                <div class="row form-group">
                                    <div class="col col-md-3"><label for="maöe" class="form-control-label">Kategori
                                            Adı</label></div>
                                    <div class="col-12 col-md-9">

                                        <input type="text" id="name" name="name" placeholder="Kategori adı"
                                            class="form-control">
                                    </div>
                                </div>
                                <div class="row form-group">
                                    <div class="col col-md-3"><label for="text-input" class=" form-control-label">Etiket
                                            (slug)</label></div>
                                    <div class="col-12 col-md-9">
                                        <span id="slug-span"></span>
                                        <input type="hidden" id="slug" name="slug" placeholder="Text"
                                            class="form-control">
                                    </div>
                                </div>


                                <div class="row form-group">
                                    <div class="col col-md-3"><label for="description"
                                            class=" form-control-label">Açıklama</label></div>
                                    <div class="col-12 col-md-9">
                                        <textarea name="description" id="description" rows="9" placeholder="açıklama..." class="form-control"></textarea>
                                    </div>
                                </div>
                                @if(false)
                                <div class="row form-group">
                                    <input type="hidden" name="parent_id" id="parent_id" value="0" >
                                   
                                    <div class="col col-md-3"><label for="select" class=" form-control-label">Üst
                                            Kategori</label></div>
                                    <div class="col-12 col-md-9">
                                        <select name="cat_select" id="cat_select" class="form-control"
                                        onchange="select_cat(this.value)">
                                        <option value="0">Seçiniz</option>
                                        @foreach ($categories as $cat)
                                            <option value="{{ $cat['id'] }}">{{ $cat['name'] }}</option>
                                        @endforeach
                                    </select>
                                        <div id="cats_div">  </div>
                                    </div>
                                </div>
                                @else 
                                <input type="hidden" name="parent_id" id="parent_id" value="0" >

                                @endif

                                <div class="row form-group">
                                    <div class="col col-md-3"><label for="select" class=" form-control-label">Sıra</label>
                                    </div>
                                    <div class="col-12 col-md-9"> 
                                        <select name="rank" id="rank" class="form-control" >
                                            @for($i=1;$i<$count+2;$i++)
                                            <option value="{{$i}}">{{$i}}</option>
                                            @endfor
                                        </select>
                                    </div>
                                </div>



                                <div class="row form-group">
                                    <div class="col col-md-3"><label for="file-input" class=" form-control-label">Kategori
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

                                <div class="row form-group" id="preview_pic" style="display: none">
                                    <div class="col col-md-3"></div>
                                    <div class="col-12 col-md-9">
                                        <img id="previewImage" src="#" alt="Preview Image"
                                            style="max-width: 300px">
                                    </div>
                                </div>
                                <div class="row form-group">
                                    <div class="col col-md-3"><label for="file-multiple-input"
                                            class=" form-control-label"></label></div>
                                    <div class="col-12 col-md-9"><button onclick="formSubmit()"
                                            class="btn btn-primary">Ekle</button></div>
                                </div>
                            </form>
                        </div>
                        <div class="card-footer">

                        </div>
                    </div>

                </div>


            </div>
        </div><!-- .animated -->
    </div><!-- .content -->
@endsection

@section('scripts')
    <script type="text/javascript">

 
$('#category-form').submit(function(e) {
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

document.getElementById('name').addEventListener('input', function(event) {
    // This function will be called whenever the text input changes
    let slug = slugify($('#name').val());
    $('#slug').val(slug);
    $('#slug-span').html(slug);

});
 
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

    const response = await fetch('/admin-panel/categories/check-slug/' + $('#slug').val());
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

//console.log(error);
var formData = new FormData(document.getElementById('category-form'));
console.log(formData);
save(formData, '/admin-panel/categories', '', '');
 
setTimeout(() => {
    window.open("/admin-panel/categories/", "_self")
}, 2000);

}

    
    </script>


    <script type="text/javascript" src="{{ url('assets/js/categories.js') }}"></script>
@endsection
