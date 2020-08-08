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
    Route::group(['middleware'=>'auth:api'],function(){
        Route::get('user/profile/{user_id}','LoginController@userProfile');
        Route::post('user/update/','LoginController@userProfileUpdate');
        Route::post('user/change/password','LoginController@userPasswordChange');


        Route::get('user/dashboard/{user_id}','DashboardController@userDashboard');
        Route::get('org/list/{user_id}','StudentController@orgList');
        Route::get('class/list/{org_id}','StudentController@classList');
        Route::get('subject/file/{user_id}/{subject_id}','StudentController@subjectFileList');

        Route::get('/view/{file_name}', 'StudentController@viewSubjectFile');

        
        Route::get('/exam/list/{subject_id}/{user_id}', 'ExamController@examList');

        Route::get('/exam/start/{exam_id}/{user_id}', 'ExamController@examStart');
        Route::get('/submit/question/{stuednt_exam_id}/{question_id}/{answer_id}', 'ExamController@submitQuestion');
        Route::get('/end/exam/{stuednt_exam_id}/{question_id}/{answer_id}', 'ExamController@endExam');
    });
});

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
