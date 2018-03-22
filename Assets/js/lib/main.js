//call rich text editor 
$(document).ready(function() {


    var $summernote = $('#summernote').summernote({
        height: 500,
        
      minHeight: null,
      maxHeight: null,
      focus: true,
    //   popover: {
    //     image: [],
    //     link: [],
    //     air: []
    //     },
 
      placeholder: "Enter Content here ",


        //Call image upload
      callbacks: {

          onImageUpload: function (files) {
              sendFile($summernote, files[0]);
          },
        }
    });

   //Ajax upload image
   function sendFile($summernote, file) 
   {

    var formData = new FormData();
    formData.append("file", file);
debugger;
        $.ajax({
            url:"<?php echo URLROOT; ?>/Posts/imageProcess?>",//
            data: formData,
            type: 'POST',   
            mimeType: "multipart/form-data",         
        // If submit data is FormData type, then the following three sentences must be added
            cache: false,
            contentType: false,
            processData: false,


            success: function (data) {
                $('#summernote').summernote('insertImage', data);  //Directly insert the path, filename optional
                debugger;
            console.log(data);
            },

            error: function () {
                debugger;
                alert("Failed to upload pictures!");
            }
        });
    }


});