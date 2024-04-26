@extends('front.layout')

@section('main')
<div class="row">

    <div class="col-md-12">
        <div class="card">

            <div class="card-body">
              <h2>  {{$blog['title']}}</h2>
              <h3>{{$blog->user()->first()->name}} , {{$date}}</h3>
              <hr>
              <div id='blog_body'>
                @if(!empty($blog['icon']))
                <img src="{{url("files/blogs/".$blog['slug']."/".$img)}}" class="img-fluid rounded float-left mr-3 mb-3" style="max-width:300px" alt="Responsive image">
                 
                @endif
                
                @php
                  echo $blog['blog']
                 
              @endphp</div>
            </div>

        </div>
    </div>
 
</div>

<div class="row">
    
    @foreach($blog->images()->get() as $img)
    <div class="col-md-3 mt-3">
        <div class="row">
    <div class="col-md-6">
        <a href="#" data-toggle="modal" data-target="#mediumModal" onclick="show_image('image',{{$img->id}})">
    
        <img src="{{url('/files/blogs/'.$img->blog()->first()->slug.'/200'.$img->image)}}"/>
        </a>
       
       
        </div>
       
        
        </div>
    </div>
    
    @endforeach
    </div>
@endsection


@section('scripts')
    @include("admin.panel.partials.datatable_scripts")
 

 

     
    <script type="text/javascript">
        $(document).ready(function() {
       $('#bootstrap-data-table-export').DataTable();
            
            //editor1.setHTMLCode($('#tmptxt').val());
        });


        async function show_image(type='image',id){
        await $.get('/show-image/'+type+'/'+id , function(data, status) {
              
              $("#mediumModalBody").html(data);
          });
    
     
          }
       
    </script>
@endsection
