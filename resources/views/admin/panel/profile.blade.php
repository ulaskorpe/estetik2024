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
                            <form class="form" id="user-form" name="user-form" action="{{ route('profile-post') }}"
                                method="post" enctype="multipart/form-data">
                                <input type="hidden" name="_token" id="_token" value="{{ csrf_token() }}">

                                <div class="form-group">
                                    <div class="input-group">
                                        <div class="input-group-addon">Admin Kodu</div>
                                        <input type="text" id="admin_code" name="admin_code" disabled
                                            value="{{ $user['admin_code'] }}" class="form-control">
                                        <div class="input-group-addon"><i class="fa fa-check"></i></div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="input-group">
                                        <div class="input-group-addon">Ad Soyad</div>
                                        <input type="text" id="name" name="name" value="{{ $user['name'] }}"
                                            class="form-control">
                                        <div class="input-group-addon"><i class="fa fa-user"></i></div>
                                    </div>
                                </div>
                                
                                <div class="form-group">
                                    <div class="input-group">
                                        <div class="input-group-addon">Email</div>
                                        <input type="email" id="email" name="email" value="{{ $user['email'] }}"
                                            class="form-control">
                                        <div class="input-group-addon"><i class="fa fa-envelope"></i></div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="input-group">
                                        <div class="input-group-addon">Telefon Numarası</div>
                                        <input type="text" id="phone_number" name="phone_number"
                                            value="{{ $user['phone_number'] }}" class="form-control">
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
                               


                                <div class="form-actions form-group">
                                    <button type="submit" class="btn btn-primary btn-sm">Güncelle</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="col-lg-6">
                    <div class="card">
                        <div class="card-header">Şifre Değiştir</div>
                        <div class="card-body card-block">
                            <form class="form" id="password-form" name="password-form"
                                action="{{ route('password-post') }}" method="post" enctype="multipart/form-data">
                                <input type="hidden" name="_token" id="_token" value="{{ csrf_token() }}">

                                <div class="form-group">
                                    <div class="input-group">
                                        <input type="password" id="password_old" name="password_old"
                                            placeholder="Eski Şifre" class="form-control">
                                        <div class="input-group-addon"><i class="fa fa-asterisk"></i></div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="input-group">
                                        <input type="password" id="password" name="password" placeholder="Yeni Şifre"
                                            class="form-control">
                                        <div class="input-group-addon"><i class="fa fa-asterisk"></i></div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="input-group">
                                        <input type="password" id="password_confirm" name="password_confirm"
                                            placeholder="Yeni Şifre Tekarr" class="form-control">
                                        <div class="input-group-addon"><i class="fa fa-asterisk"></i></div>
                                    </div>
                                </div>
                                <div class="form-actions form-group"><button type="submit" onclick="passwordSubmit()"
                                        class="btn btn-primary btn-sm">Güncelle</button></div>
                            </form>
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

async function passwordSubmit(){

    let error = false;
if ($('#password_old').val() == '') {

$('#password_old').focus();
Swal.fire({
    icon: 'error',
    text: 'eski şifrenizi giriniz'
});

error = true;
return false;
} else {
  
    const response = await fetch('/admin-panel/check-old-pw/' + $('#password_old').val());
        const data = await response.json();
        if(data !== 'ok'){
        Swal.fire({
                    icon: 'error',
                    text: data
                });

                error = true;
                return false;
            }

}

if ($('#password').val()=='') {
            $('#password').focus();
            Swal.fire({
                icon: 'error',
                text: ' şifrenizi giriniz'
            });

            error = true;
            return false;

        }
    if ($('#password').val().length < 6) {
            $('#password').focus();
            Swal.fire({
                icon: 'error',
                text: 'şifreniz en az 6 karakter olmalıdır'
            });

            error = true;
            return false;

        }

        if ($('#password').val()!== $('#password_confirm').val()) {
            $('#password_confirm').focus();
            Swal.fire({
                icon: 'error',
                text: 'şifrenizi yeniden giriniz'
            });

            error = true;
            return false;
        }
    //console.log(error);
    var formData = new FormData(document.getElementById('password-form'));
 
             save(formData, '{{ route('password-post') }}', 'password-form', '');
             document.getElementById('password-form').reset();
           
            
}

 
 

        $('#password-form').submit(function(e) {
            e.preventDefault();
            var error = false;
            var formData = new FormData(this);
           //  save(formData, '{{ route('password-post') }}', '', '');
          


        });

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


            if ($('#email').val() == '') {

                $('#email').focus();
                Swal.fire({
                    icon: 'error',
                    text: 'Email adresi giriniz'
                });

                error = true;
                return false;
            } else {
                $.get('/admin-panel/check-email/' + $('#email').val()+{{Auth::id()}}, function(data, status) {
                    // alert("Data: " + data + "\nStatus: " + status);
                    error = true;
                    if (data != 'ok') {
                        $('#email').val('');
                        $('#email').focus();
                        Swal.fire({
                            icon: 'error',
                            text: data
                        });
                        return false;
                    } else {
                        error = false;
                    }
                });
            }
            if (error) {
                return false;
            }


            //function save(formData,route,formID,btn,reload) {
            var formData = new FormData(this);

            save(formData, '{{ route('profile-post') }}', 'user-form', '', false);


        });
    </script>
@endsection
