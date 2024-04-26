@extends('front.layout')

@section('main')
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
                            onclick="window.open('{{route('blog_show',[$blog['slug'],$blog['id']])}}','_self')">Görüntüle</button>

 

                    </td>
                </tr>
                     @endforeach
                   
                    
                    </tbody>
                </table>
            </div>

        </div>
    </div>


</div>
@endsection


@section('scripts')
    @include("admin.panel.partials.datatable_scripts")
 

 

     
    <script type="text/javascript">
        $(document).ready(function() {
            $('#bootstrap-data-table-export').DataTable();
        });

       
    </script>
@endsection
