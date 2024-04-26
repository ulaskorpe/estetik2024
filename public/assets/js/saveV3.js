function save(formData,route,formID,btn,reload) {
 
    $.ajax({
        
        url:  route,
        type: 'POST',
        data: formData,
        cache: false,
        contentType: false,
        processData: false,
        success: function (data) {
            //console.log(data.status);
            if(data.status=='error'){
                Swal.fire({
                    title: 'Hata!',
                        text: data.message,
                        icon: 'error',
                        confirmButtonText: 'Tamamdır'
                });
            }else{
                Swal.fire({
                    title: 'Tebrikler',
                        text: data.message,
                        icon: 'success',
                        confirmButtonText: 'Tamamdır'
                });
                
            }
           
           
            if(reload){
            setTimeout(function() {
                location.reload();
            }, 2000);
            }
        
        },
        error: function (data) {
            if (data.status === 422) {
                var errors = data.responseJSON.errors;
                var message = "";
                $.each(errors, function (key, value) {
                    message += key + ' : ' + value;
                });


                  //  $('#'+arr[3]).html(message);


            

                if(btn!='') {
                    $('#'+btn).css('display', '');
                    $('#'+btn+'-hourglass').css('display', 'none');
                }

            }
            //{"msg":"Yaz\u0131 Eklendi","id":19}
            if (data.status === 500) {
                
                if(btn!='') {

                    $('#'+btn).css('display', '');
                    $('#'+btn+'-hourglass').css('display', 'none');
                }
            }
        }
    });
}