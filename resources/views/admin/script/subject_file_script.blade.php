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


    var count_sub = 1 ; 
    function add_file() {
        var Html = `<div id='subfile${count_sub}'>
            <div class="col-md-12 col-sm-12 col-xs-12 mb-3" >
                <label for="title">File Title</label>
                <input type="text" class="form-control" name="title[]"  placeholder="Enter File Title"  required >
            </div>

            <div class="col-md-10 col-sm-10 col-xs-12 mb-3" >
                <label for="file">Select File</label>
                <input type="file" class="form-control" name="file[]" required >
            </div>

            <div class="col-md-2 col-sm-2 col-xs-12 mb-3" id="sub_div">
                <button type="button" class="btn btn-sm btn-danger" style="margin-top: 25px;" onclick="remove_file(${count_sub})">Remove</button>
            </div>
        </div>`;
        $("#sub_file_div").append(Html);
        count_sub++;
    }

    function remove_file(id) {
        $("#subfile"+id).remove();
    }
</script>