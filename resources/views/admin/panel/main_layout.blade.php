<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html lang="en">
@include('admin.panel.partials.head')

<body>
    @include('admin.panel.partials.left_menu')

    <!-- Right Panel -->
    <div id="right-panel" class="right-panel">
        <!-- Header-->
        @include('admin.panel.partials.header')

        <!-- /#header -->
        <!-- Content -->
         
        <div class="content">
            <!-- Animated -->
            <div class="animated fadeIn">



                @yield("main")
             
                @include("admin.panel.partials.modals");
            </div>
            <!-- .animated -->
        </div>
        <!-- /.content -->
        <div class="clearfix"></div>
        @include("admin.panel.partials.footer")
    
    </div>
    <!-- /#right-panel -->
     @include('admin.panel.partials.scripts')
    <!--Local Stuff-->
    @yield("scripts")

    <script>
        function logoutfx(){
            Swal.fire({
            title: 'Çıkış yapılacak eminmisiniz',
         
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Evet!',
            cancelButtonText: 'Hayır'
        }).then((result) => {
            // If confirmed
            if (result.isConfirmed) {
                    $('#logout-form').submit();
            }
        });
        }
        </script>
</body>
</html>
