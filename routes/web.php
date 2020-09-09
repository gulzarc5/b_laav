<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::group(['namespace' => 'Admin'],function(){
    Route::get('/','LoginController@loginForm')->name('admin.login_form');    
    Route::post('login', 'LoginController@adminLogin');

    Route::group(['middleware'=>'auth:admin','prefix'=>'admin'],function(){
        Route::get('/dashboard', 'DashboardController@dashboardView')->name('admin.deshboard');        
        Route::post('logout', 'LoginController@logout')->name('admin.logout');

        Route::get('/change/password/form', 'DashboardController@changePasswordForm')->name('admin.change_password_form');
        Route::post('/change/password', 'DashboardController@changePassword')->name('admin.change_password');


        Route::group(['prefix' => 'organization'],function(){
            Route::get('/list', 'OrganizationController@listOrg')->name('admin.org_list');
            Route::get('/add/form', 'OrganizationController@addOrg')->name('admin.org_add');
            Route::get('/edit/form/{id}', 'OrganizationController@editOrg')->name('admin.org_edit');
            Route::post('/insert', 'OrganizationController@insertOrg')->name('admin.insert_org');
            Route::put('/update/{id}', 'OrganizationController@updateOrg')->name('admin.update_org');
        });

        Route::group(['prefix' => 'student'],function(){
            Route::get('/premium/list', 'StudentController@listPreStudent')->name('admin.pre_student_list');
            Route::get('/premium/list/ajax', 'StudentController@listPreStudentAjax')->name('admin.pre_student_list_ajax');

            Route::get('/org/list', 'StudentController@listOrgStudent')->name('admin.org_student_list');
            Route::get('/org/list/ajax', 'StudentController@listOrgStudentAjax')->name('admin.org_student_list_ajax');
           
            Route::get('/add/form', 'StudentController@addStudent')->name('admin.student_add');
            Route::post('/insert', 'StudentController@insertStudent')->name('admin.insert_student');
            Route::get('/edit/form/{id}', 'StudentController@editStudent')->name('admin.student_edit');
            Route::put('/update/{id}', 'StudentController@updateStudent')->name('admin.update_student');
            Route::get('/request/list', 'StudentController@listRequestStudent')->name('admin.request_student_list');
            Route::get('/request/delete/{id}', 'StudentController@deleteRequestStudent')->name('admin.request_student_delete');
            Route::get('/request/list/ajax', 'StudentController@listRequestStudentAjax')->name('admin.request_student_list_ajax');
        });

        Route::group(['prefix' => 'class'],function(){
            Route::get('/list', 'ClassController@listClass')->name('admin.class_list');
            Route::get('/add/form', 'ClassController@addClass')->name('admin.class_add');
            Route::post('/insert', 'ClassController@insertClass')->name('admin.insert_class');
            Route::get('/list/ajax/{stream_id}/{org_id?}', 'ClassController@listClassAjax')->name('admin.list_class_ajax');
            
            Route::get('/edit/form/{id}', 'ClassController@editClass')->name('admin.class_edit');
            Route::put('/update/{id}', 'ClassController@updateClass')->name('admin.update_class');

        });

        Route::group(['prefix' => 'subject'],function(){
            Route::get('/list', 'SubjectController@listSubject')->name('admin.subject_list');
            Route::get('/add/form', 'SubjectController@addSubject')->name('admin.subject_add');
            Route::post('/insert', 'SubjectController@insertSubject')->name('admin.insert_subject');
            Route::put('/update/{subject_id}', 'SubjectController@updateSubject')->name('admin.update_subject');
            Route::get('/edit/{subject_id}', 'SubjectController@editSubject')->name('admin.edit_subject');
            
            Route::get('/list/ajax/{class_id}', 'SubjectController@listSubjectAjax')->name('admin.list_subject_ajax');
        });

        Route::group(['prefix' => 'subject/file'],function(){
            Route::get('/list', 'SubjectController@listSubjectFile')->name('admin.subject_file_list');
            Route::get('/list/ajax', 'SubjectController@listSubjectFileAjax')->name('admin.subject_file_list_ajax');
            Route::get('/add/form', 'SubjectController@addSubjectFile')->name('admin.subject_file_add');
            Route::post('/insert', 'SubjectController@insertSubjectFile')->name('admin.insert_file_subject');
            Route::get('/view/{file_name}', 'SubjectController@viewSubjectFile')->name('admin.view_file_subject');
            Route::get('/edit/form/{file_id}', 'SubjectController@editSubjectFile')->name('admin.subject_file_edit');
            Route::put('/update/form/{file_id}', 'SubjectController@updateSubjectFile')->name('admin.subject_file_update');
        });

        Route::group(['prefix' => 'subject/video'],function(){
            Route::get('/list', 'VideoController@listSubjectVideo')->name('admin.subject_video_list');
            Route::get('/list/ajax', 'VideoController@listSubjectVideoAjax')->name('admin.subject_video_list_ajax');
            Route::get('/add/form', 'VideoController@addSubjectVideo')->name('admin.subject_video_add');
            Route::post('/insert', 'VideoController@insertSubjectVideo')->name('admin.insert_video_subject');
        });

        Route::group(['prefix' => 'exam'],function(){
            Route::get('/list', 'ExamController@listExams')->name('admin.exam_list');
            Route::get('/list/ajax', 'ExamController@listExamsAjax')->name('admin.exam_list_ajax');
            Route::get('/add/form', 'ExamController@addExamForm')->name('admin.new_exam_form');
            Route::get('/edit/form/{exam_id}', 'ExamController@editExamForm')->name('admin.edit_exam_form');
            Route::put('/update/{exam_id}', 'ExamController@updateExamForm')->name('admin.update_exam');
            Route::post('/insert', 'ExamController@insertExam')->name('admin.insert_exam');
            Route::get('/view/question/{exam_id}', 'ExamController@viewQuestion')->name('admin.view_question');
            Route::get('/add/question/form/{exam_id}', 'ExamController@addQuestionForm')->name('admin.add_question_form');
            Route::post('insert/exam/question','ExamController@insertQuestion')->name('admin.insert_question');
            
            Route::get('/view/{file_name}', 'ExamController@viewQuestionFile')->name('admin.view_file_question');

            Route::get('/edit/question/form/{question_id}', 'ExamController@editQuestionForm')->name('admin.edit_question_form');
            Route::post('/update/question/', 'ExamController@updateQuestion')->name('admin.update_question');
        });

        Route::group(['prefix' => 'bidya/exam'],function(){
            Route::get('/list', 'BidyaExamController@listExams')->name('admin.bidya_exam_list');
            Route::get('/list/ajax', 'BidyaExamController@listExamsAjax')->name('admin.bidya_exam_list_ajax');
            Route::get('/add/form', 'BidyaExamController@addExamForm')->name('admin.new_bidya_exam_form');
            // Route::get('/edit/form/{exam_id}', 'ExamController@editExamForm')->name('admin.edit_exam_form');
            // Route::put('/update/{exam_id}', 'ExamController@updateExamForm')->name('admin.update_exam');
            Route::post('/insert', 'BidyaExamController@insertExam')->name('admin.insert_bidya_exam');
            Route::get('/view/question/{exam_id}', 'BidyaExamController@viewQuestion')->name('admin.view_bidya_question');
            Route::get('/add/question/form/{exam_id}', 'BidyaExamController@addQuestionForm')->name('admin.add_bidya_question_form');
            Route::post('insert/exam/question','BidyaExamController@insertQuestion')->name('admin.insert_bidya_question');
            
            // Route::get('/view/{file_name}', 'BidyaExamController@viewQuestionFile')->name('admin.view_vidya_file_question');

            Route::get('/edit/question/form/{question_id}', 'BidyaExamController@editQuestionForm')->name('admin.edit_bidya_question_form');
            Route::post('/update/question/', 'BidyaExamController@updateQuestion')->name('admin.update_bidya_question');
            Route::get('/add/org/student/{exam_id}', 'BidyaExamController@addOtherOrgStudent')->name('admin.add_other_org_student');

            Route::get('/add/org/student/form/{exam_id}', 'BidyaExamController@addOtherOrgStudentForm')->name('admin.add_other_org_student_form');
            Route::post('/insert/org/student/', 'BidyaExamController@insertOtherOrgStudent')->name('admin.insert_other_org_student');
            Route::get('/org/student/check/{exam_id}/{student_id}', 'BidyaExamController@checkOtherOrgStudent')->name('admin.check_other_org_student');
        });

        Route::group(['prefix' => 'student/exam'],function(){
            Route::get('/list', 'StudentExamController@listExams')->name('admin.student_exam_list');
            Route::get('/list/ajax', 'StudentExamController@listExamsAjax')->name('admin.student_exam_list_ajax');
            // Route::get('/add/form', 'BidyaExamController@addExamForm')->name('admin.new_bidya_exam_form');
            // // Route::get('/edit/form/{exam_id}', 'ExamController@editExamForm')->name('admin.edit_exam_form');
            // // Route::put('/update/{exam_id}', 'ExamController@updateExamForm')->name('admin.update_exam');
            // Route::post('/insert', 'BidyaExamController@insertExam')->name('admin.insert_bidya_exam');
            // Route::get('/view/question/{exam_id}', 'BidyaExamController@viewQuestion')->name('admin.view_bidya_question');
            // Route::get('/add/question/form/{exam_id}', 'BidyaExamController@addQuestionForm')->name('admin.add_bidya_question_form');
            // Route::post('insert/exam/question','BidyaExamController@insertQuestion')->name('admin.insert_bidya_question');
            
            // // Route::get('/view/{file_name}', 'BidyaExamController@viewQuestionFile')->name('admin.view_vidya_file_question');

            // Route::get('/edit/question/form/{question_id}', 'BidyaExamController@editQuestionForm')->name('admin.edit_bidya_question_form');
            // Route::post('/update/question/', 'BidyaExamController@updateQuestion')->name('admin.update_bidya_question');
        });

        Route::group(['prefix' => 'app/setting'],function(){
            Route::get('/list', 'DashboardController@ListData')->name('admin.app_setting_list');
            Route::get('/image/form', 'DashboardController@imageForm')->name('admin.imageForm');
            Route::post('/image/insert', 'DashboardController@imageInsert')->name('admin.imageInsert');
            Route::get('/image/delete/{id}', 'DashboardController@imageDelete')->name('admin.imageDelete');

            Route::get('/video/form', 'DashboardController@videoForm')->name('admin.videoForm');
            Route::post('/video/insert', 'DashboardController@videoInsert')->name('admin.videoInsert');
        });


    });
});