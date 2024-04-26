<div class="row">
    
@foreach($images as $img)
<div class="col-md-3 mt-3">
    <div class="row">
<div class="col-md-6">
    <a href="#" data-toggle="modal" data-target="#mediumModal" onclick="show_image('image',{{$img->id}})">

    <img src="{{url('/files/categories/'.$img->category()->first()->slug.'/200'.$img->image)}}"/>
    </a>
    <select name="" id="" class="form-control mt-2" style="width: 100px" onchange="bring_images({{$img->id}},this.value)">
        @for($i=$count;$i>0;$i--)
         <option value="{{$i}}" @if($i==$img->rank) selected @endif>{{$i}}</option>
        @endfor
    </select>
   
    </div>
    <div class="col-md-6 pt-6">
        <a href="#" onclick="deleteImage({{$img->id}})"><i class="fa fa-times danger"></i></a>
    </div>
    
    </div>
</div>

@endforeach
</div>