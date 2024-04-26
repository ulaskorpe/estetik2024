function rankSelect(){
    var sel = ($('#parent_id').val()>0)? '#cat_select_'+$('#parent_id').val() : '#cat_select';
    var count = ( $( sel+' option').length >0) ? $( sel+' option').length - 1 : 0;
    console.log(sel);
    var rankSelect = $('#rank');
    rankSelect.empty(); 
    for (var i = count+1; i >0 ; i--) {
        $('<option>').val(i).text(i).appendTo(rankSelect);
    }
    rankSelect.prop('disabled', false); 
 }

 var categories_added = [];
async function remove_selects(){
    const up_cats = await fetch('/admin-panel/categories/show-up-categories/' +  $('#parent_id').val(), {
        headers: {
            'Accept': 'application/json'
        }
        });
    const up_data = await up_cats.json();    

    $.each(categories_added, function(index, selectId) {
    if(!up_data.data.includes(selectId)){
          $('#' + selectId).remove();
          
        }
    
      });
      categories_added = up_data.data;
}


async function add_selects(cat_id){
    if(cat_id>0){
    const response = await fetch('/admin-panel/categories/select-categories/' + cat_id, {
        headers: {
            'Accept': 'application/json'
        }
        });
        const contentType = response.headers.get('content-type');
        if (contentType && contentType.includes('application/json')) {

            const jsonData = await response.json();
            $.each(jsonData , function(index, categoryData) {
                if(categoryData.categories != undefined){
                 appendSelect(categoryData.categories  ,cat_id);
                }
            });
           
        }
    }
}

 async function select_cat(cat_id){
    if(cat_id>0){
   categories_added.push('cat_select_'+cat_id);
    $('#parent_id').val(cat_id);
   ////remove first 
    await remove_selects();
    await add_selects(cat_id) 
        rankSelect();
    
    ////remove first 
   

    }else{
        await remove_selects();
        $('#parent_id').val($('#cat_select').val());
        add_selects($('#cat_select').val());
        
       console.log(categories_added);
        $.each(categories_added, function(index, selectId) {
                  $('#' + selectId).remove();
            
              });
    }
   
 }  


function appendSelect(jsonData,cat_id){
 
        

        var newSelect = $("<select>")
            .attr("name", "cat_select_"+cat_id)
            .attr("id", "cat_select_"+cat_id)
            .attr("class", "form-control mt-2")
            .attr("onchange", "select_cat(this.value)");
        
        // Append the new select element to the specific div
        $("#cats_div").append(newSelect);
        const categorySelect = $('#cat_select_'+cat_id);
        categorySelect.empty();
        categorySelect.append($('<option>', {
                value: "0", 
                text: "seçiniz"
            }));
        // Iterate over categories and append options to select element
        $.each(jsonData , function(index, category) {
           if(category.id == cat_id){
            categorySelect.append($('<option >', {
                value: category.id, 
                text:  category.name  ,
                selected :true
            }));

            }else{
                categorySelect.append($('<option>', {
                    value: category.id, 
                    text: category.name  
                }));
            }
        });
       
 } //// appendSelect


function slugify(str) {
    return String(str)
        .normalize('NFKD') // split accented characters into their base characters and diacritical marks
        .replace(/[\u0300-\u036f]/g,
        '') // remove all the accents, which happen to be all in the \u03xx UNICODE block.
        .trim() // trim leading or trailing whitespace
        .toLowerCase() // convert to lowercase
        .replace(/[^a-z0-9 -]/g, '') // remove non-alphanumeric characters
        .replace(/\s+/g, '-') // replace spaces with hyphens
        .replace(/-+/g, '-'); // remove consecutive hyphens
}

function makeSlug() {
    let slug = slugify($('#name').val());
    $('#slug').val(slug);
    console.log(slug)
}