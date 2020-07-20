<script>
    function get_class_list(stream_id) {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            type: "GET",
            url: "{{ url('admin/class/list/ajax/') }}/"+ stream_id,
            dataType: 'json',
            beforeSend: function () {
                $("#classes").html('');
            },
            success: function (response) {
                var data=response;
                if (!$.isEmptyObject(data)) {
                    var state_html = '<option value=""> Select Class</option>';
                    $.each(data, function(i, e) {
                        state_html += '<option value="' + e.id + '">' + e.name + '</option>';
                    });
                    $("#classes").html(state_html);
                }else{
                    $("#classes").html('<option ""> No Sub Category Found </option>');
                }
            }
        })
    }

    function get_subject_list(class_id) {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            type: "GET",
            url: "{{ url('admin/subject/list/ajax/') }}/"+ class_id,
            dataType: 'json',
            beforeSend: function () {
                $("#subject").html('');
            },
            success: function (response) {
                var data=response;
                if (!$.isEmptyObject(data)) {
                    var state_html = '<option value=""> Select Subject</option>';
                    $.each(data, function(i, e) {
                        state_html += '<option value="' + e.id + '">' + e.name + '</option>';
                    });
                    $("#subject").html(state_html);
                }else{
                    $("#subject").html('<option ""> No Subject Found </option>');
                }
            }
        })
    }

    function check_exam_type(exam_type){
        if (exam_type == '2') {
            $("#s_date").show();
            $("#e_date").show();
        } else {
            $("#s_date").hide();
            $("#e_date").hide();
        }
    }
</script>