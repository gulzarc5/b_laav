<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
Route::group(['namespace'=>'Api'], function(){
    Route::post('user/login','LoginController@userLogin');
    Route::post('user/reg/request','DashboardController@regRequest');

    Route::get('/view/exam/{file_name}', 'ExamController@viewQuestionFile');
    
    Route::group(['middleware'=>'auth:api'],function(){
        Route::get('user/profile/{user_id}','LoginController@userProfile');
        Route::post('user/update/','LoginController@userProfileUpdate');
        Route::post('user/change/password','LoginController@userPasswordChange');


        Route::get('user/dashboard/{user_id}','DashboardController@userDashboard');
        Route::get('org/list/{user_id}','StudentController@orgList');
        Route::get('class/list/{org_id}','StudentController@classList');
        Route::get('subject/file/{user_id}/{subject_id}','StudentController@subjectFileList');
        Route::get('/view/{file_name}', 'StudentController@viewSubjectFile');
        
        Route::get('subject/video/{user_id}/{subject_id}','StudentController@subjectVideoList');
        
        Route::get('/exam/list/{subject_id}/{user_id}', 'ExamController@examList');

        Route::get('/exam/start/{exam_id}/{user_id}', 'ExamController@examStart');
        Route::get('/submit/question/{stuednt_exam_id}/{question_id}/{answer_id}', 'ExamController@submitQuestion');
        Route::get('/end/exam/{stuednt_exam_id}/{question_id}/{answer_id}', 'ExamController@endExam');


        Route::get('/my/exam/list/{user_id}', 'StudentController@myExamList');
        Route::get('/my/bidya/exam/list/{user_id}', 'StudentController@myBidyaExamList');



        Route::group(['prefix'=>'bidya'],function(){
            Route::get('/exam/list/{user_id}', 'BidyaExamController@examList');
            Route::post('/exam/login/check', 'BidyaExamController@examLoginCheck');
            Route::get('/exam/start/{exam_id}/{user_id}', 'BidyaExamController@examStart');
            Route::get('/submit/question/{stuednt_exam_id}/{question_id}/{answer_id}', 'BidyaExamController@submitQuestion');
            Route::get('/end/exam/{stuednt_exam_id}/{question_id}/{answer_id}', 'BidyaExamController@endExam');
        });

        Route::group(['prefix'=>'question'],function(){            
            Route::get('/list/{page}', 'ChatController@chatList');
            Route::post('/send', 'ChatController@addMessage');
            Route::get('/answer/like/{user_id}/{answer_id}', 'ChatController@ansLike');
        });
    });
});

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
