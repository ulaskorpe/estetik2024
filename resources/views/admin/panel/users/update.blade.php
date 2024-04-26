@extends('admin.panel.main_layout')
@section('css-section')
    <link href='https://fonts.googleapis.com/css?family=Open+Sans:400,600,700,800' rel='stylesheet' type='text/css'>
@endsection
@section('main')
    <div class="content">
        <div class="animated fadeIn">


            <div class="row">

                <div class="col-lg-6">
                    <div class="card">
                        <div class="card-header">Kullanıcı Bilgileri</div>
                        <div class="card-body card-block">
                            <form class="form" id="user-form" name="user-form" action="{{ route('users-update') }}"
                                method="post" enctype="multipart/form-data">
                                <input type="hidden" name="_token" id="_token" value="{{ csrf_token() }}">
                                <input type="hidden" name="id" id="id" value="{{ $user['id'] }}">

                                <div class="form-group">
                                    <div class="input-group">
                                        <div class="input-group-addon">Admin Kodu</div>
                                        <input type="hidden" id="admin_code" name="admin_code" value="{{$user['admin_code']}}">
                                        <input type="text"  disabled
                                        value="{{$user['admin_code']}}" class="form-control">
                                        <div class="input-group-addon"><i class="fa fa-check"></i></div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="input-group">
                                        <div class="input-group-addon">Ad Soyad</div>
                                        <input type="text" id="name" name="name"  value="{{$user['name']}}"
                                            class="form-control">
                                        <div class="input-group-addon"><i class="fa fa-user"></i></div>
                                    </div>
                                </div>
                                
                                <div class="form-group">
                                    <div class="input-group">
                                        <div class="input-group-addon">Email</div>
                                        <input type="email" id="email" name="email"  value="{{$user['email']}}"
                                            class="form-control">
                                        <div class="input-group-addon"><i class="fa fa-envelope"></i></div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="input-group">
                                        <div class="input-group-addon">Telefon Numarası</div>
                                        <input type="text" id="phone_number" name="phone_number"  value="{{$user['phone_number']}}"
                                           class="form-control">
                                        <div class="input-group-addon"><i class="fa fa-phone"></i></div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="input-group">
                                        <div class="input-group-addon">Avatar</div>
                                        <input type="file" id="avatar" name="avatar"  
                                            class="form-control">
                                        <div class="input-group-addon"><i class="fa fa-picture-o"></i></div>
                                    </div>
                                </div>
                         
                               
                               


                                <div class="form-actions form-group">

                                    <div class="row justify-content-center">
                                        <div class="col-auto">
                                            <button type="submit" class="btn btn-primary btn-sm">Güncelle</button>
                                        </div>
                                    </div>
                                  
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="col-lg-6">
                    <div class="card">
                        <div class="card-header">Resim</div>
                        <div class="card-body card-block">
                    @if(!empty($user['avatar']))
                    <div class="form-group" id="avatar_pic">
                        <div class="input-group">
                           <img src="{{url("files/users/".$user['id']."/200".$user['avatar'])}}" >
                        </div>
                    </div>
                    @endif
                    <div class="form-group" id="preview_pic" style="display: none">
                        <div class="input-group">
                            <img id="previewImage"   src="#" alt="Preview Image">
                        </div>
                    </div>
                        </div>
                    </div>
                </div>
                </div>

            </div>

            <div class="row" style="height: 500px"></div>
        </div><!-- .animated -->
    </div><!-- .content -->
@endsection

@section('scripts')
    <script>
 document.getElementById('avatar').addEventListener('change', function(event) {
        const file = event.target.files[0];
        const reader = new FileReader();

        reader.onload = function(e) {
            document.getElementById('previewImage').src = e.target.result;
          $('#avatar_pic').hide();
          $('#preview_pic').show();
        };

        reader.readAsDataURL(file);
    });
 

 
  
async function checkemail(){

 
if ($('#email').val() == '') {

    $('#email').focus();
                Swal.fire({
                    icon: 'error',
                    text: 'Email adresi giriniz'
                });

               
                return false;

 
} else {

    await   $.get('/admin-panel/check-email/' + $('#email').val()+'/{{$user['id']}}', function(data, status) {
                    // alert("Data: " + data + "\nStatus: " + status);
                    
                    if (data != 'ok') {
                        $('#email').val('');
                        $('#email').focus();
                        Swal.fire({
                            icon: 'error',
                            text: data
                        });
                        return false;
                    } else {
                        return true;
                      
                    }
                });

}
}//check email 

        $('#user-form').submit(function(e) {
            e.preventDefault();
            var error = false;

            if ($('#name').val() == '') {

                $('#name').focus();
                Swal.fire({
                    icon: 'error',
                    text: 'Ad Soyad giriniz'
                });

                error = true;
                return false;
            }


    
            if(checkemail()){


            //function save(formData,route,formID,btn,reload) {
        
                var formData = new FormData(this);
                    
                    save(formData, '{{ route('users-update') }}', 'user-form', '', false);
                    setTimeout(function() {
    window.open('{{route('users.index')}}','_self');
}, 3000);
                }

        });
    </script>
@endsection
