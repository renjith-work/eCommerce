        $(document).ready(function(){
            // Initialize Select2 features
            $(function () {
                $('.select2').select2()
            });

            tinymce.init({
                selector: '.wysiwyg',
                theme: 'modern',
                plugins: 'print preview searchreplace autolink directionality visualblocks visualchars fullscreen image link media template codesample table charmap hr pagebreak nonbreaking anchor toc insertdatetime advlist lists textcolor wordcount imagetools contextmenu colorpicker textpattern help',
                toolbar1: 'formatselect | bold italic strikethrough forecolor backcolor | link | alignleft aligncenter alignright alignjustify  | numlist bullist outdent indent  | removeformat',
                image_advtab: true,
            });

            $.ajaxSetup({
            headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }});

            var _token = $("input[name='_token']").val();

            // Load Fabric Class
            
            loadFabricClass();
            function loadFabricClass(){
                $('#fabric_class').html('');
                $.ajax({
                    url: "/admin/api/fabric/class/load",
                    type:'GET',
                    dataType: 'json',
                    success:function(response){
                        $('#fabric_class').append('<option disabled selected>Select a fabric class</option>');
                        $.each(response, function(key,value){
                            $('#fabric_class').append('<option value="'+value.id+'">'+value.name+'</option>');
                        });
                    }
                });
            }

            $(document).on('change', '#fabric_class', function(){
                var id = $("#fabric_class").val();
                loadFabric(id);
            });

            function loadFabric(id){
                $('#fabric').html('');
                $.ajax({
                    url: "/admin/api/fabric/find",
                    type:'POST',
                    data: {_token:_token, id:id},
                    dataType: 'json',
                    success:function(response){
                        $('#fabric').append( '<option disabled selected>Select a fabric</option>' );
                        $.each(response, function(key,value){
                            $('#fabric').append( '<option value="'+value.id+'">'+value.name+'</option>' );
                        });
                    }
                });
            }

            // Load product attributes and values when product category is loaded;
            loadPdVals(); 

            // Load product attributes and values when product category is selected;
            $(document).on('change', '#category', function(){
                // loadPdVals();   
                var category = $("#category").val();
                loadProductAttributes(category);

                setTimeout(function(){
                    loadProductAttributeValues(category);
                }, 1000);              
            });


            function loadPdVals()
            {   
                var category = $("#category").val();
                if(category){

                    loadProductAttributes(category);
                    setTimeout(function(){
                        loadProductAttributeValues(category);
                    }, 1000);
                }
            }

            function loadProductAttributes(id){
                $('#prd-attr-cover').html('');
                $.ajax({
                    url: "/admin/api/product/attribute/load",
                    type:'POST',
                    data: {_token:_token, id:id},
                    dataType: 'json',
                    success:function(response){
                        $.each(response, function(key,value){
                            $('#prd-attr-cover').append('<div class="form-group"><label for="'+value.code+'">'+value.name+'</label><select id="'+value.code+'" class="form-control custom-select mt-15" name="'+value.code+'"></select></div>' );
                        });
                    }
                });
            }

            function loadProductAttributeValues(id){
                $.ajax({
                    url: "/admin/api/product/attribute/load",
                    type:'POST',
                    data: {_token:_token, id:id},
                    dataType: 'json',
                    success:function(response){
                        $.each(response, function(key,value){
                            $.each(value.values, function(key1,value1){
                                console.log(value1);
                                $('#'+value.code+'').append( '<option value="'+value1.attribute_value_id+'">'+value1.attribute_value_name+'</option>' );
                            });
                            // $('#prd-attr-cover').append('<div class="form-group"><label for="'+value.name+'">'+value.name+'</label><select id="'+value.name+'" class="form-control custom-select mt-15 name="'+value.name+'"></select></div>' );
                        });
                    }
                });
            }


            $('#section1N').click(function(e){
                e.preventDefault();
                $('#mainPane').removeClass("active");
                $('#attrPane').addClass("active");

                $('#mainTab').removeClass("active");
                $('#attrTab').addClass("active");

                $('#liMain').removeClass("active");
                $('#liAttr').addClass("active");
            });

            $('#section2P').click(function(e){
                e.preventDefault();
                $('#attrPane').removeClass("active");
                $('#mainPane').addClass("active");

                $('#attrTab').removeClass("active");
                $('#mainTab').addClass("active");

                $('#liAttr').removeClass("active");
                $('#liMain').addClass("active");
            });

            $('#section2N').click(function(e){
                e.preventDefault();
                $('#attrPane').removeClass("active");
                $('#imagePane').addClass("active");

                $('#attrTab').removeClass("active");
                $('#imageTab').addClass("active");

                $('#liAttr').removeClass("active");
                $('#liImage').addClass("active");
            });

            $('#section3P').click(function(e){
                e.preventDefault();
                $('#imagePane').removeClass("active");
                $('#attrPane').addClass("active");

                $('#imageTab').removeClass("active");
                $('#attrTab').addClass("active");

                $('#liImage').removeClass("active");
                $('#liAttr').addClass("active");
            });

            $('#section3N').click(function(e){
                e.preventDefault();
                $('#imagePane').removeClass("active");
                $('#seoPane').addClass("active");

                $('#imageTab').removeClass("active");
                $('#seoTab').addClass("active");

                $('#liImage').removeClass("active");
                $('#liSeo').addClass("active");
            });

            $('#section4P').click(function(e){
                e.preventDefault();
                $('#seoPane').removeClass("active");
                $('#imagePane').addClass("active");

                $('#seoTab').removeClass("active");
                $('#imageTab').addClass("active");

                $('#liSeo').removeClass("active");
                $('#liImage').addClass("active");
            });

            $("#album").change(function(){
                $('#images_preview').html("");
                var total_file=document.getElementById("album").files.length;
                for(var i=0;i<total_file;i++)
                {
                    $('#images_preview').append("<div class='col-md-4 upload-multi-img'><img src='"+URL.createObjectURL(event.target.files[i])+"'></div>");
                }
            });

            $('#p_image').change(function(){
                $('#p_image_preview').html("");
                $('#p_image_preview').append("<div class='col-md-4 upload-multi-img'><img src='"+URL.createObjectURL(event.target.files[0])+"'></div>");
            });

            $('#s_image').change(function(){
                $('#s_image_preview').html("");
                $('#s_image_preview').append("<div class='col-md-4 upload-multi-img'><img src='"+URL.createObjectURL(event.target.files[0])+"'></div>");
            });


            // $('#product_create').on('submit', function (e) {
            //     // e.preventDefault();

            //     console.log('Form Submitted');
            //     // $.ajax({
            //     //     url: "/admin/product",
            //     //     type:'POST',
            //     //     data: {_token:_token, $('#product_create').serialize()},
            //     //     dataType: 'json',
            //     //     success:function(response){
            //     //         console.log(response);
            //     //     }
            //     // });

            // });

        });