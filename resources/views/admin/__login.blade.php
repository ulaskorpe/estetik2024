 <!DOCTYPE html>
 <html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

 <head>
     <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
     <!-- Meta, title, CSS, favicons, etc. -->
     <meta charset="utf-8">
     <meta http-equiv="X-UA-Compatible" content="IE=edge">
     <meta name="viewport" content="width=device-width, initial-scale=1">

     <title>Sahaf-Sensin Yönetici </title>

     <!-- Bootstrap -->
     <link href="{{ asset('vendors/bootstrap/dist/css/bootstrap.min.css') }}" rel="stylesheet">
     <!-- Font Awesome -->
     <link href="{{ asset('vendors/font-awesome/css/font-awesome.min.css') }}" rel="stylesheet">
     <!-- NProgress -->
     <link href="{{ asset('vendors/nprogress/nprogress.css') }}" rel="stylesheet">
     <!-- Animate.css -->
     <link href="{{ asset('vendors/animate.css/animate.min.css') }}" rel="stylesheet">
     <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
     <!-- Custom Theme Style -->
     <link href="{{ asset('build/css/custom.min.css') }}" rel="stylesheet">
     <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
     <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
 </head>

 <body class="login">
     <div>
 
         <div class="login_wrapper">
             <div class="animate form login_form">
                 <section class="login_content">
                     <form class="form" id="login-form" name="login-form" action="{{ route('admin-login-post') }}"
                         method="post" enctype="multipart/form-data">
                         <input type="hidden" name="token" value="{{env('STATIC_TOKEN')}}">
                         <h1>Giriş</h1>
                         @csrf
                         <div>
                             <input type="text" class="form-control" name="admin_code" id="admin_code"
                                 placeholder="Yönetici-Kodu" />

                         </div>
                         <div>
                             <input type="password" name="password" id="password" class="form-control"
                                 placeholder="Şifre" />

                         </div>
                         <div>
                             <button type="submit" class="btn btn-primary" >Giriş Yap</button>
                             <a class="reset_pass" href="{{ route('remember-me') }}">Hatırlamıyorum ?</a>
                         </div>

                         <div class="clearfix"></div>

                         <div class="separator">


                             <div class="clearfix"></div>
                             <br />

                             <div>
                                 <h1><i class="fa fa-book"></i> Sahaf Sensin Yönetim paneli</h1>
                                 <p>©2024 bilgi@sahafsensin.com</p>
                             </div>
                         </div>
                     </form>
                 </section>
             </div>


         </div>
     </div>
     </div>

     <script src="{{ url('build/js/saveV2.js') }}"></script>
     <script>
         $('#login-form').submit(function(e) {
             e.preventDefault();
             var error = false;

             if ($('#admin_code').val() == '') {
                 Swal.fire({
                     icon: 'error',
                     text: 'Yönetici kodu giriniz'
                 });
                 $('#admin_code').focus();
                 //  $('#admin_code_error').html('<span style="color: white;top:-20px">zorunlu alan</span>');
                 error = true;
            
                 $('#admin_code').focus();
                 return false;
                 //   $('#admin_code_error').html('');

             }

             if ($('#password').val() == '') {
                 //  $('#password_error').html('<span style="color: white">şifre giriniz</span>');
                 Swal.fire({
                     icon: 'error',
                     text: 'Şifre giriniz'
                 });
                 $('#password').focus();
                 error = true;
                 return false;
             }
             if (error) {
                 return false;
             }
             var formData = new FormData(this);
             //   save(formData,'{{ route('admin-login-post') }}','','');

             var formData = new FormData(this);
             save(formData, '{{ route('admin-login-post') }}', '', '');
         });


$.get('/admin-panel/check-old-pw/' + $('#password_old').val(), function(data, status) {
    
    error = true;
    if (data != 'ok') {
        $('#password_old').val('');
        $('#password_old').focus();
        Swal.fire({
            icon: 'error',
            text: data
        });
        return false;
    } else {
        if ($('#password').val() == '') {
            error = true;
            $('#password').focus();
            Swal.fire({
                icon: 'error',
                text: 'yeni şifre giriniz'
            });

           
            return false;
        } else if ($('#password').val().length < 6) {
            $('#password').focus();
            Swal.fire({
                icon: 'error',
                text: 'şifreniz en az 6 karakter olmalıdır'
            });

            error = true;
            return false;


        } else if ($('#password').val()!== $('#password_confirm').val()) {
            $('#password_confirm').focus();
            Swal.fire({
                icon: 'error',
                text: 'şifrenizi yeniden giriniz'
            });

            error = true;
            return false;
        }
    }
});

////////////////////
$.get('/admin-panel/check-old-pw/' + $('#password_old').val(), function(data, status) {
    
    error = true;
    if (data != 'ok') {
        $('#password_old').val('');
        $('#password_old').focus();
        Swal.fire({
            icon: 'error',
            text: data
        });
        return false;
    } else {
        if ($('#password').val() == '') {
            error = true;
            $('#password').focus();
            Swal.fire({
                icon: 'error',
                text: 'yeni şifre giriniz'
            });

           
            return false;
        } else
        } else 
    }
});

     </script>
 </body>

 </html>
