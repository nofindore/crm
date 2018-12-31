<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|   example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|   http://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There area two reserved routes:
|
|   $route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|   $route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router what URI segments to use if those provided
| in the URL cannot be matched to a valid route.
|
*/

$route['default_controller'] = "login";
$route['404_override'] = 'error';


/*********** USER DEFINED ROUTES *******************/

$route['loginMe'] = 'login/loginMe';
$route['dashboard'] = 'user';
$route['logout'] = 'user/logout';

$route['country'] = 'country';
$route['country/add'] = 'country/add';
$route['country/edit'] = 'country/edit';
$route['country/delete'] = 'country/delete';

$route['state'] = 'state';
$route['state/add'] = 'state/add';
$route['state/edit'] = 'state/edit';
$route['state/delete'] = 'state/delete';
$route['stateByCountry'] = 'state/loadByCountry';

$route['city'] = 'city';
$route['city/add'] = 'city/add';
$route['city/edit'] = 'city/edit';
$route['city/delete'] = 'city/delete';
$route['cityByState'] = 'city/loadByState';

$route['schools'] = "school";
$route['schoolByCity'] = 'school/loadByCity';

/* Olympiad 2018 */
$route['olympiad_school'] = "olympiadSchool";
$route['olympiad_school_add'] = "olympiadSchool/edit";
$route['olympiad_school_edit'] = "olympiadSchool/edit/$1";
$route['olympiad_school_save'] = "olympiadSchool/save";
$route['olympiad_school_delete'] = "olympiadSchool/delete";
$route['olympiad_school_send_login/(:num)'] = "olympiadSchool/sendLogin/$1";
$route['olympiad_school_admit_cards'] = "olympiadSchool/admitCard";
$route['olympiad_school_admit_cards_download/(:num)'] = "olympiadSchool/admitCardDownload/$1";

$route['olympiad_reports'] = "olympiadReports";
$route['olympiad_students_list'] = "olympiadStudents";
$route['olympiad_students_list/(:num)'] = "olympiadStudents/studentsList/$1";
$route['olympiad_students_list_print/(:num)'] = "olympiadStudents/studentsListPrint/$1";
$route['olympiad_students_attendance_list'] = "olympiadStudents/attendance";
$route['olympiad_students_attendance_list/(:num)/(:num)'] = "olympiadStudents/attendanceList/$1/$1";
$route['olympiad_students_attendance_list_print/(:num)/(:num)'] = "olympiadStudents/studentsAttendanceListPrint/$1/$1";
$route['olympiad_subjects_papers_books'] = "olympiadSubjects/reportPapersAndBooks";

$route['olympiad_print_report_all_papers_books'] = "olympiadSubjects/reportPrintPapersAndBooks";
$route['olympiad_print_report_all_papers_books/(:num)'] = "olympiadSubjects/reportPrintPapersAndBooks/$1";
$route['olympiad_print_report_all_papers'] = "olympiadSubjects/reportPrintPapers";
$route['olympiad_print_report_all_papers/(:num)'] = "olympiadSubjects/reportPrintPapers/$1";
$route['olympiad_print_report_all_books'] = "olympiadSubjects/reportPrintBooks";
$route['olympiad_print_report_all_books/(:num)'] = "olympiadSubjects/reportPrintBooks/$1";
/* Olympiad 2018 */




$route['schools/new'] = "school/newListing";





$route['school/edit/(:num)'] = "schools/edit/$1";
$route['school/editSchool'] = "schools/editSchool";
$route['school/delete/(:num)'] = "schools";

$route['userListing'] = 'user/userListing';
$route['userListing/(:num)'] = "user/userListing/$1";
$route['addNew'] = "user/addNew";

$route['addNewUser'] = "user/addNewUser";
$route['editOld'] = "user/editOld";
$route['editOld/(:num)'] = "user/editOld/$1";
$route['editUser'] = "user/editUser";
$route['deleteUser'] = "user/deleteUser";
$route['loadChangePass'] = "user/loadChangePass";
$route['changePassword'] = "user/changePassword";
$route['pageNotFound'] = "user/pageNotFound";
$route['checkEmailExists'] = "user/checkEmailExists";

$route['forgotPassword'] = "login/forgotPassword";
$route['resetPasswordUser'] = "login/resetPasswordUser";
$route['resetPasswordConfirmUser'] = "login/resetPasswordConfirmUser";
$route['resetPasswordConfirmUser/(:any)'] = "login/resetPasswordConfirmUser/$1";
$route['resetPasswordConfirmUser/(:any)/(:any)'] = "login/resetPasswordConfirmUser/$1/$2";
$route['createPasswordUser'] = "login/createPasswordUser";

$route['students_list'] = "students/studentsListing";
$route['students_list/(:num)'] = "students/studentsListing/$1";
$route['students_books_details'] = "students/booksDetails";
$route['students_books_details_csv'] = "students/booksDetailsCsv";
$route['students_bulk_upload_index'] = "students/bulkUploadIndex";
$route['students_bulk_upload_process'] = "students/bulkUpload";

// $route['schools_details'] = "schools/studentsDetail";
// $route['school_students_details_csv'] = "schools/studentsDetailsCsv";

$route['reports'] = "reports";

/* End of file routes.php */
/* Location: ./application/config/routes.php */