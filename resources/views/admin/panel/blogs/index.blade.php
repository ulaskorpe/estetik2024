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
                            <h1>Bloglar</h1>
                        </div>
                    </div>
                </div>
                <div class="col-sm-8">
                    <div class="page-header float-right">
                        <div class="page-title">
                            <button type="button" onclick="window.open('{{ route('blogs.create') }}','_self')"
                                class="btn btn-primary"><i class="fa fa-plus"></i>&nbsp; Blog Ekle</button>
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
                                        <th>Başlık </th>
                                        <th>Kategori</th>
                                        <th>Yazar</th>
                                        
                                       
                                        <th>#</th>
                                    </tr>
                                </thead>
                                <tbody>
                                   
                                 @foreach($blogs as $blog)
                                 <tr>
                                    <td>

                                        <form id="deleteform{{$blog['id']}}"
                                            action=" {{ route('blogs-delete') }}" method="POST">
                                            <input type="hidden" name="_token" id="_token"
                                                value="{{ csrf_token() }}">
                                            <input type="hidden" name="id" id="id"
                                                value="{{ $blog['id'] }}">
                                        </form>

                                      
                                        @if(!empty($blog['icon']))
                                        <div class="form-group" id="avatar_pic">
                                            <div class="input-group">
                                               <img src="{{url("files/blogs/".$blog['slug']."/".$blog['icon'])}}" style="width:100px">
                                            </div>
                                        </div>
                                        @endif
                                </td>
                                <td><b>{{$blog['title']}}</b><br>
                                
                                {{substr($blog['prologue'],0,50)}}
                                </td>
                                <td>{{$blog->category()->first()->name}}</td>
                                <td>{{$blog->user()->first()->name}}</td>
                                
                                
                         
                            
                                <td style="width: 200px">


                                    <button type="button" class="btn btn-primary"
                                        onclick="window.open('{{route('blogs.edit',$blog['id'])}}','_self')">Güncelle</button>


                                    <button type="button" onclick="deleteblog({{$blog['id']}})"
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

        function deleteblog(id) {
            Swal.fire({
                text: 'Blog silinecek, emin misin?',
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
