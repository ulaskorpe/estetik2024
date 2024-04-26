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
                                class="btn btn-primary"><i class="fa fa-plus"></i>&nbsp; Kategoriler</button>
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
                                    <input type="text" name="parent_id" id="parent_id" value="0">
                                    <div class="col col-md-3"><label for="select" class=" form-control-label">Üst
                                            Kategori</label></div>
                                    <div class="col-12 col-md-9">
                                        <select name="cat_select" id="cat_select" class="form-control"
                                            onchange="select_sub_cat(this.value)">
                                            <option value="0">Seçiniz</option>
                                             
                                        </select>
                                        <div id="upper_cats_div" style="background-color: red"></div>
                                        <div id="cats_div" style="background-color: blue"></div>
                                    </div>
                                </div>

                                <div class="row form-group">
                                    <div class="col col-md-3"><label for="select" class=" form-control-label">Sıra</label>
                                    </div>
                                    <div class="col-12 col-md-9">
                                        <select name="rank" id="rank" class="form-control" disabled></select>
                                    </div>
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
      
    </script>

 
@endsection
