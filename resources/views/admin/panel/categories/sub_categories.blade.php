<table id="example" class="table table-striped table-bordered" style="width:100%">
@foreach($categories as $category)
<tr  >
    <td>{{$category->rank}}
        <form id="deleteform{{$category->id}}" action=" {{route('category-delete')}}" method="POST">
            <input type="hidden" name="_token" id="_token" value="{{ csrf_token() }}">
            <input type="hidden" name="id" id="id" value="{{ $category['id'] }}">
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
    <td>
        <button type="button" class="btn btn-primary" onclick="window.open('{{route('categories.edit',$category['slug'])}}','_self')">Güncelle</button>
        <button type="button" onclick="showSubs({{ $category->id }},'dv{{$category->id}}','tr{{$category->id}}')"
            class="btn btn-secondary">Alt Kategoriler</button>
        <button type="button" onclick="deleteCategory({{ $category->id }})"
            class="btn btn-danger">Sil</button>

            <button type="button" onclick="hideCategory('dv{{$category->id}}','tr{{$category->id}}')"
                class="btn btn-success">Gizle</button>
    </td>
</tr>


<tr id="tr{{$category->id}}" style="display:none;  ">
    <td colspan="6">
        <div id="dv{{$category->id}}"></div>
    </td>
</tr>
@endforeach
 
 