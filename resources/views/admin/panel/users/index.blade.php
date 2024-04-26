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
                            <h1>Kullanıcılar</h1>
                        </div>
                    </div>
                </div>
                <div class="col-sm-8">
                    <div class="page-header float-right">
                        <div class="page-title">
                            <button type="button" onclick="window.open('{{ route('users.create') }}','_self')"
                                class="btn btn-primary"><i class="fa fa-plus"></i>&nbsp; Kullanıcı Ekle</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="content">
        <div class="animated fadeIn">
            <div class="row">

                <div class="col-md-12">
                    <div class="card">

                        <div class="card-body">
                            <table id="bootstrap-data-table" class="table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th>Resim</th>
                                        <th>Adı Soyadı</th>
                                        <th>Kodu</th>
                                        <th>Email</th>
                                        <th>Telefon</th>
                                       
                                        <th>#</th>
                                    </tr>
                                </thead>
                                <tbody>
                                   
                                 @foreach($users as $user)
                                 <tr>
                                    <td>

                                        <form id="deleteform{{$user['id']}}"
                                            action=" {{ route('users-delete') }}" method="POST">
                                            <input type="hidden" name="_token" id="_token"
                                                value="{{ csrf_token() }}">
                                            <input type="hidden" name="id" id="id"
                                                value="{{ $user['id'] }}">
                                        </form>
                                        @if(!empty($user['avatar']))
                                        <div class="form-group" id="avatar_pic">
                                            <div class="input-group">
                                               <img src="{{url("files/users/".$user['id']."/200".$user['avatar'])}}" style="width:100px">
                                            </div>
                                        </div>
                                        @endif
                                </td>
                                <td>{{$user['name']}}</td>
                                <td>{{$user['admin_code']}}</td>
                                <td>{{$user['email']}}</td>
                                <td>{{$user['phone_number']}}</td>
                         
                            
                                <td style="width: 200px">


                                    <button type="button" class="btn btn-primary"
                                        onclick="window.open('{{route('users.edit',$user['id'])}}','_self')">Güncelle</button>


                                    <button type="button" onclick="deleteUser({{$user['id']}})"
                                        class="btn btn-danger">Sil</button>


                                </td>
                            </tr>
                                 @endforeach
                               
                                
                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>


            </div>
        </div><!-- .animated -->
    </div><!-- .content -->
@endsection

@section('scripts')
    @include("admin.panel.partials.datatable_scripts")
 

 

     
    <script type="text/javascript">
        $(document).ready(function() {
            $('#bootstrap-data-table-export').DataTable();
        });

        function deleteUser(id) {
            Swal.fire({
                text: 'Kullanıcı silinecek, emin misin?',
                //text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Evet',
                cancelButtonText: 'Hayır'
            }).then((result) => {

                if (result.isConfirmed) {
                     
                    $('#deleteform' + id).submit();
                       
                }
            });
        }
    </script>
@endsection
