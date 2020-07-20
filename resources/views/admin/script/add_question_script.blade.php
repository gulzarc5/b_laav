<script>
var question_div = 2;
var option_div = 2;

function check_question_type(question_type) {
    if (question_type == '1') {
        var q_html = `<label for="question">Enter Question<span style="color:red"> * </span></label>
            <textarea class="form-control" name="question"  placeholder="Enter Question">{{old('question')}}</textarea>`;
    } else {
        var q_html = `<label for="question">Select Question Image<span style="color:red"> * </span></label>
                                    <input type="file" class="form-control" name="question">`;
    }
    $("#question-input-div").html(q_html);
}

function check_exam_type(option_value,option_id) {
    if (option_value =='1') {
        var option_html = `<label for="option">Enter Option Value <span style="color:red"> * </span></label>
                            <input type="text"  class="form-control" name='option${option_id}' >`;
    } else {
        var option_html = `<label for="option">Select option Image <span style="color:red"> * </span></label>
                            <input type="file"  class="form-control" name='option${option_id}'>`;
    }
    $("#option-input-div"+option_id).html(option_html);
}



</script>