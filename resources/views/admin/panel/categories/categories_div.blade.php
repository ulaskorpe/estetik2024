 

<div class="row form-group">
    <div class="col col-md-3"><label for="select" class=" form-control-label">Sıra</label>
    </div>
    <div class="col-12 col-md-9">
        <select name="rank" id="rank" class="form-control">
            @for($i=$rank_count ; $i>0;$i--)
            <option value="{{$i}}" @if($i==$selected_cat['rank']) selected @endif>{{$i}}</option>
            @endfor
        </select>
    </div>
</div>
