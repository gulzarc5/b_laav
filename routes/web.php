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
            Route::post('/insert', 'OrganizationController@insertOrg')->name('admin.insert_org');
        });

        Route::group(['prefix' => 'student'],function(){
            Route::get('/premium/list', 'StudentController@listPreStudent')->name('admin.pre_student_list');
            Route::get('/premium/list/ajax', 'StudentController@listPreStudentAjax')->name('admin.pre_student_list_ajax');
            Route::get('/Free/list', 'StudentController@listFreeStudent')->name('admin.free_student_list');
            Route::get('/Free/list/ajax', 'StudentController@listFreeStudentAjax')->name('admin.free_student_list_ajax');
            Route::get('/add/form', 'StudentController@addStudent')->name('admin.student_add');
            Route::post('/insert', 'StudentController@insertStudent')->name('admin.insert_student');
            Route::get('/request/list', 'StudentController@listRequestStudent')->name('admin.request_student_list');
        });

        Route::group(['prefix' => 'class'],function(){
            Route::get('/list', 'ClassController@listClass')->name('admin.class_list');
            Route::get('/add/form', 'ClassController@addClass')->name('admin.class_add');
            Route::post('/insert', 'ClassController@insertClass')->name('admin.insert_class');
            Route::get('/list/ajax/{stream_id}', 'ClassController@listClassAjax')->name('admin.list_class_ajax');
        });

        Route::group(['prefix' => 'subject'],function(){
            Route::get('/list', 'SubjectController@listSubject')->name('admin.subject_list');
            Route::get('/add/form', 'SubjectController@addSubject')->name('admin.subject_add');
            Route::post('/insert', 'SubjectController@insertSubject')->name('admin.insert_subject');
            
            Route::get('/list/ajax/{class_id}', 'SubjectController@listSubjectAjax')->name('admin.list_subject_ajax');
        });

        Route::group(['prefix' => 'subject/file'],function(){
            Route::get('/list', 'SubjectController@listSubjectFile')->name('admin.subject_file_list');
            Route::get('/list/ajax', 'SubjectController@listSubjectFileAjax')->name('admin.subject_file_list_ajax');
            Route::get('/add/form', 'SubjectController@addSubjectFile')->name('admin.subject_file_add');
            Route::post('/insert', 'SubjectController@insertSubjectFile')->name('admin.insert_file_subject');
            Route::get('/view/{file_name}', 'SubjectController@viewSubjectFile')->name('admin.view_file_subject');
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

    });
});