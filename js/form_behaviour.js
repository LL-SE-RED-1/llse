

var college_and_department;

var base_url;

$("input[name='college']").change(function(){
    var picked = $(this).attr('value');
    var department_list = college_and_department['college'][picked]['department'];
    $("#department-menu").empty();
    $("#department-text").empty();
    department_list.forEach(function(el, i) {
        $("#department-menu").append("<div class='item'>" + el + "</div>");
    });
});

$("#back").click(function() {
    history.go(-1);
});

$(".close.icon").click(function() {
    $(this).parent().transition('scale out');
});


      $(document)
              .ready(function(){
                $('.ui.dropdown').dropdown();
                $('.ui.menu .dropdown')
                        .dropdown({
                          on: 'hover'
                        })
                ;
                $('.demo .ui.checkbox')
                         .checkbox()
                ;

                base_url = window.location.protocol + "//" + window.location.host + "/ims/";

                $.getJSON( base_url + "metadata/college_and_department.json", function( data ) {
                    college_and_department = data;

                    for (el in college_and_department['college']){
                        console.log(el);
                        $('#college-menu').append("<div class='item'>" + el + "</div>");
                    }
                }).done(function(){
                    var picked = $("#colcollege > input").attr('value');
                    console.log("Wow " +picked);
                    var department_list = college_and_department['college'][picked]['department'];
                    $("#department-menu").empty();
                    $("#department-text").empty();
                    department_list.forEach(function(el, i) {
                        $("#department-menu").append("<div class='item'>" + el + "</div>");
                    });

                });

         


              })
      ;