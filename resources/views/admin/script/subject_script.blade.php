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
    var count_sub = 1 ; 
    function add_subject() {
        var Html = `<div id='sub${count_sub}'>
            <div class="col-md-10 col-sm-10 col-xs-12 mb-3" >
                <label for="name"></label>
                <input type="text" class="form-control" name="name[]"  placeholder="Enter Subject Name"  required >
            </div>
            <div class="col-md-2 col-sm-2 col-xs-12 mb-3" id="sub_div">
                <button type="button" class="btn btn-sm btn-danger" style="margin-top: 25px;" onclick="remove_subject(${count_sub})">Remove</button>
            </div>
        </div>`;
        $("#sub_div").append(Html);
        count_sub++;
    }

    function remove_subject(id) {
        $("#sub"+id).remove();
    }
</script>