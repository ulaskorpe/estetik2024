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
                            <h1>Kategoriler</h1>
                        </div>
                    </div>
                </div>
                <div class="col-sm-8">
                    <div class="page-header float-right">
                        <div class="page-title">
                            <button type="button" onclick="window.open('{{ route('categories.create') }}','_self')"
                                class="btn btn-primary"><i class="fa fa-plus"></i>&nbsp; Kategori Ekle</button>
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
                                        <th>Sıra</th>
                                        <th>Simge</th>
                                        <th>Kategori Adı</th>
                                        <th>Açıklama</th>
                                       
                                        <th>#</th>
                                    </tr>
                                </thead>
                                <tbody>
                                   
                                    @php
                                    $div_array = [];
                                @endphp
                                @foreach ($categories as $category)
                                    <tr>
                                        <td>{{ $category->rank }}

                                            <form id="deleteform{{ $category->id }}"
                                                action=" {{ route('category-delete') }}" method="POST">
                                                <input type="hidden" name="_token" id="_token"
                                                    value="{{ csrf_token() }}">
                                                <input type="hidden" name="id" id="id"
                                                    value="{{ $category['id'] }}">
                                            </form>
                                        </td>
                                        <td>
                                            @if ($category['icon'])
                                                <img
                                                    src="{{ url('files/categories/' . $category['slug'] . '/' . $category['icon']) }}">
                                            @endif
                                        </td>
                                        <td>{{ $category['name'] }}</td>
                                        <td>{{ $category['description'] }}</td>
                                        <td style="width: 200px">

                                            <button type="button" class="btn btn-primary"
                                                onclick="window.open('{{ route('categories.edit', $category['slug']) }}','_self')">Güncelle</button>


                                            <button type="button" onclick="deleteCategory({{ $category->id }})"
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

        function deleteCategory(id) {
            Swal.fire({
                text: 'Kategori silinecek, emin misin?',
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
                    //   Swal.fire('Deleted!', 'Your file has been deleted.', 'success');
                }
            });
        }
    </script>
@endsection
