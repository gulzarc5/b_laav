<script>
var question_div = 2;
var option_div = 2;

function check_student(student_id) {
    var exam_id = $("#exam_id_inpt").val();
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $.ajax({
        type: "GET",
        url: "{{ url('admin/bidya/exam/org/student/check/') }}/"+exam_id+"/"+ student_id,
        dataType: 'json',
        beforeSend: function () {
            $("#student_info").html('<center><i class="fa fa-circle-o-notch fa-spin" style="font-size:50px;color:red"></i></center>');
            
            $("#st_add_btn").hide();
        },
        success: function (response) {
            $("#student_info").html('');
            var data=response;
            console.log(data);
            if (!$.isEmptyObject(data)) {
                if (data == '2') {
                    $("#student_info").html('<center>Sorry! No Student Found</center>');
                    $("#st_add_btn").hide();
                } else if(data == '3'){
                    $("#student_info").html('<center>Sorry! Student Class Does Not matched With Exam Class</center>');
                    $("#st_add_btn").hide();
                } else if(data == '4'){
                    $("#student_info").html('<center>Student Already in bidyalaav</center>');
                    $("#st_add_btn").hide();
                }else{
                    $("#student_info").html(data);
                    $("#st_add_btn").show();
                }
            }else{
                $("#student_info").html('<p>No data found</p>');
                $("#st_add_btn").hide();
            }
        }
    })
}

</script>