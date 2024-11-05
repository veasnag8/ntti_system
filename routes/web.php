<?php

use App\Http\Controllers\General\ClassesController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\General\AssingClassesController;
use App\Http\Controllers\General\AttendanceController;
use App\Http\Controllers\General\ClassScheduleController;
use App\Http\Controllers\General\SkillsController;
use App\Http\Controllers\Report\ListOfStudentController;
use App\Http\Controllers\General\StudnetController;
use App\Http\Controllers\General\SubjectsController;
use App\Http\Controllers\General\TeacherController;
use App\Http\Controllers\SystemSetup\DashboardController;
use App\Http\Controllers\SystemSetup\DepartmentController;
use App\Http\Controllers\SystemSetup\SystemSettingController;
use App\Http\Controllers\SystemSetup\TableController;
use App\Http\Controllers\SystemSetup\UsersController;
use GuzzleHttp\Middleware;
use Illuminate\support\Facades\App;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
Route::get('/greeting/{locale}', function (string $locale) {
    if (! in_array($locale, ['en', 'kh'])) {
        abort(400);
    }
    App::setLocale($locale);
    // ...
    // Route::get('department', [AuthController::class, 'department']);
});
    Route::get('/', function () {
        return view('auth.login');
    });
    Route::get('/menu-reports', function () {
        return view('general.main_menu_report');
    });Route::get('user-dont-have-permission', function () {
        return view('Error.permission_acces');
    });
    Route::get('login', [AuthController::class, 'index'])->name('login');
    Route::post('post-login', [AuthController::class, 'postLogin'])->name('login.post');
    Route::get('registration', [AuthController::class, 'registration'])->name('register');
    Route::post('post-registration', [AuthController::class, 'postRegistration'])->name('register.post');
    Route::get('/department-menu', [AuthController::class, 'departmentMenu']);
    Route::get('logout', [AuthController::class, 'logout'])->name('logout');

Route::group(['perfix' => 'student'], function (){
    Route::get('/student', [StudnetController::class, 'index'])->name('student');
    Route::get('/settings-customize-field', [StudnetController::class, 'SettingsCustomizeField'])->name('SettingsCustomizeField');
    Route::get('/student/print', [StudnetController::class, 'Print'])->name('Print');
    Route::post('/student/downlaodexcel', [StudnetController::class, 'downlaodexcel'])->name('downlaodexcel');
    Route::get('/student/transaction', [StudnetController::class, 'transaction'])->name('transaction');
    Route::get('/system/avanceSearch/student/ajaxpagination', [StudnetController::class, 'Ajaxpaginat'])->name('Ajaxpaginat');
    Route::get('/pusher/send-message', [StudnetController::class, 'sendmessage'])->name('sendmessage');
    Route::get('/system/avanceSearch/student/ajaxpagination', [StudnetController::class, 'Ajaxpaginat'])->name('Ajaxpaginat');
    Route::POST('/student/store',[StudnetController::class, 'store']);
    Route::POST('/student/delete',[StudnetController::class,'delete']);
    Route::POST('/student/update',[StudnetController::class,'update']);
    Route::get('/student/create-user-account',[StudnetController::class,'CreateUser']);
    Route::POST('/studnet/import-excel',[StudnetController::class,'ImportExcel']);
    Route::get('/manage-academic-work',[StudnetController::class,'ManageStudnetWork']);
    Route::get('/assign-classes',[StudnetController::class,'ManageAssignClasses']);
    Route::get('/student/getImage',[StudnetController::class,'GetImage']);
    Route::Post('/student/uploadimage',[StudnetController::class,'UploadImage']);
    Route::Post('/student/delete-image',[StudnetController::class,'DeleteImage']);

})->middleware('auth');

Route::group(['perfix' => 'table'], function (){
    Route::get('/table', [TableController::class, 'index']);
    Route::get('/table_field', [TableController::class, 'table_field']);
    Route::post('/build', [TableController::class, 'build']);
})->middleware('auth');

Route::group(['prefix' => 'table'], function () {
    Route::get('/table', [TableController::class, 'index']);
    Route::post('/add_table', [TableController::class, 'create']);
    Route::get('/table_field', [TableController::class, 'table_filed']);
    Route::post('/build', [TableController::class, 'build']);
    Route::get('/ajaxpagination', [TableController::class, 'Ajaxpaginat']);
})->middleware('auth');
// report
Route::group(['perfix' => 'reports-list-of-student'], function (){
    Route::get('reports-list-of-student', [ListOfStudentController::class, 'index'])->name('index');
    Route::get('reports-list-of-student-priview', [ListOfStudentController::class, 'Priview'])->name('Priview');
    Route::get('reports-list-of-student-print', [ListOfStudentController::class, 'Print'])->name('Print');
    Route::get('reports-list-of-student-print/export/', [ListOfStudentController::class, 'export']);
})->middleware('auth');
Route::group(['perfix' => 'dashboard'], function (){
    Route::get('dashboard', [DashboardController::class, 'index'])->name('index');
    // Route::get('reports-list-of-student-priview', [DashboardController::class, 'Priview'])->name('Priview');
    Route::get('dahhboard-student-print', [DashboardController::class, 'Print'])->name('Print');
    Route::get('dahhboard-student-account', [DashboardController::class, 'StudentUserAccount'])->name('StudentUserAccount');
})->middleware('auth');
Route::group(['perfix' => 'department'], function (){
    Route::get('department-setup', [DepartmentController::class, 'index'])->name('index');
    Route::post('department-delete', [DepartmentController::class, 'delete'])->name('delete');
    Route::get('departments/transaction', [DepartmentController::class, 'transaction'])->name('transaction');
    Route::post('departments/update', [DepartmentController::class, 'update'])->name('update');
    Route::post('departments/store', [DepartmentController::class, 'store'])->name('store');
    Route::get('departments/print', [DepartmentController::class, 'Print'])->name('Print');

})->middleware('auth');
Route::group(['perfix' => 'Users'], function (){
    Route::get('users', [UsersController::class, 'index'])->name('index');
    // Route::post('department-delete', [UsersController::class, 'delete'])->name('delete');
    // Route::get('departments/transaction', [UsersController::class, 'transaction'])->name('transaction');
    // Route::post('departments/update', [UsersController::class, 'update'])->name('update');
    // Route::post('departments/store', [UsersController::class, 'store'])->name('store');
})->middleware('auth');

Route::group(['perfix' => 'table'], function (){
    Route::get('/menu-search', [SystemSettingController::class, 'pageSearch']);
    Route::get('/settings-customize-fields', [SystemSettingController::class, 'SettingsCustomizeField']);
    Route::get('/system/avanceSearch/{page}',[SystemSettingController::class, 'AvanceSearch']);
    Route::get('/system/live-Search/{page}',[SystemSettingController::class, 'LiveSearch']);
})->middleware('auth');


Route::group(['perfix' => 'classes'], function (){
    Route::get('/classes', [ClassesController::class, 'index']);
    Route::get('/classes/transaction', [ClassesController::class, 'transaction']);
    Route::post('/classes/update', [ClassesController::class, 'update']);
    Route::post('/classes/store', [ClassesController::class, 'store']);
    Route::POST ('/classes-delete', [ClassesController::class, 'delete']);
})->middleware('auth');

Route::group(['perfix' => 'skills'], function (){
    Route::get('/skills', [SkillsController::class, 'index']);
    Route::get('/skills/transaction', [SkillsController::class, 'transaction']);
    Route::post('/skills/update', [SkillsController::class, 'update']);
    Route::post('/skills/store', [SkillsController::class, 'store']);
    Route::POST ('/skills-delete', [SkillsController::class, 'delete']);
})->middleware('auth');

Route::group(['perfix' => 'subject'], function (){
    Route::get('/subject', [SubjectsController::class, 'index']);
    Route::get('/subjects/transaction', [SubjectsController::class, 'transaction']);
    Route::post('/subjects/update', [SubjectsController::class, 'update']);
    Route::post('/subjects/store', [SubjectsController::class, 'store']);
    Route::POST ('/subjects-delete', [SubjectsController::class, 'delete']);
})->middleware('auth');

Route::group(['perfix' => 'teachers'], function (){
    Route::get('/teachers', [TeacherController::class, 'index']);
    Route::get('/teachers/transaction', [TeacherController::class, 'transaction']);
    Route::post('/teachers/update', [TeacherController::class, 'update']);
    Route::post('/teachers/store', [TeacherController::class, 'store']);
    Route::POST ('/teachers-delete', [TeacherController::class, 'delete']);
    Route::get('/teachers/create-user-account',[TeacherController::class,'CreateUser']);
    Route::get('/teachers_detail', [TeacherController::class, 'details']);
    Route::get('/teachers-detail/transaction', [TeacherController::class, 'teachersDetailTransaction']);
})->middleware('auth');

Route::group(['perfix' => 'teachers'], function (){
    Route::get('/assign-classes', [AssingClassesController::class, 'index']);
    Route::get('/assign-classes/transaction', [AssingClassesController::class, 'transaction']);
    Route::post('/assign-classes/update', [AssingClassesController::class, 'update']);
    Route::get('/assing-studnet-to-class', [AssingClassesController::class, 'AssingStudentToClass']);
    Route::POST('/assign-student-line/update',[AssingClassesController::class,'UpdateStudentLine']);
    Route::get ('/assign-classes-delete-studnet-line', [AssingClassesController::class, 'DeleteStudentLine']);
    Route::get('/assign-student-line-by-code',[AssingClassesController::class,'AssingStudent']);
    Route::get('/assign-student-print-print',[AssingClassesController::class,'printLine']);
    Route::get('/create-assing-classeds-new',[AssingClassesController::class,'CreateNewAssingClasses']);
    Route::get('/get-attendant-student',[AssingClassesController::class,'GetAttendantStudent']);
    Route::get('/update-attendant-date-student',[AssingClassesController::class,'UpdateAttendantDateStudent']);
    Route::get('/supdate-attendant-score-student',[AssingClassesController::class,'UpdateAttendanScoretDateStudent']);
    Route::get('/assign-classes-update-examtype',[AssingClassesController::class,'UpdateExamType']);
    Route::get('/exam-results',[AssingClassesController::class,'ExamResults']);
    Route::get('/get-exam-results',[AssingClassesController::class,'GetExamResults']);
    Route::get('/get-exam-results-print-exam',[AssingClassesController::class,'PrintExamResults']);
})->middleware('auth');
Route::group(['prefix' => 'teachers'], function () {
    Route::get('/assign-classesddd', [AttendanceController::class, 'index']);
})->middleware('auth');
Route::group(['perfix' => '/class-schedule'], function (){
    Route::get('/class-schedule', [ClassScheduleController::class, 'index']);
    Route::get('/class-schedule/transaction', [ClassScheduleController::class, 'transaction']);
    Route::post('/class-schedule/update', [ClassScheduleController::class, 'update']);
    Route::post('/class-schedule/store', [ClassScheduleController::class, 'store']);
    Route::POST ('/class-schedule-delete', [ClassScheduleController::class, 'delete']);
    Route::POST ('/class-schedule/save-schedule', [ClassScheduleController::class, 'SaveSchedule']);
})->middleware('auth');





