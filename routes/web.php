<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\laravel_example\UserManagement;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\Report_HRD_Controller;
use App\Http\Controllers\ReportSecurityController;
use App\Http\Controllers\BeritaAcaraController;
use App\Http\Controllers\tr_candidateController;
use App\Http\Controllers\LoginCompanyController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\UserssController;
use App\Http\Controllers\MS_Type_SP_Controller;
use App\Http\Controllers\MS_Company_Controller;
use App\Http\Controllers\MsLocationController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Tr_Sp_Controller;
use App\Http\Controllers\import_dataController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ForgotPasswordController;
use App\Http\Controllers\Tr_AssasmenController;
use App\Http\Controllers\MentoringController;
use App\Http\Controllers\PutusHubunganKerjaController;
use App\Http\Controllers\Kategori_BA_Controller;
use App\Http\Controllers\Kasus_Head_Controller;
use App\Http\Controllers\Detail_Kasus_Controller;
use App\Http\Controllers\PDFController;
use App\Http\Controllers\Master_MultiDetailKasus_Controller;
use App\Http\Controllers\Tr_PICA_Controller;
use App\Http\Controllers\MasterKategoriController;
use App\Http\Controllers\MasterPicaController;
use App\Http\Controllers\MasterCekMappingController;
use App\Http\Controllers\MasterDocWorkflowController;
use App\Http\Controllers\MasterPermissionController;
use App\Http\Controllers\HelpController;
use App\Http\Controllers\BeritaAcaraV2Controller;
use App\Http\Controllers\PicaV2Controller;

use Illuminate\Support\Facades\Auth;


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


$controller_path = 'App\Http\Controllers';

Route::get('/', function () {
  return view('home', ['title' => 'Home']);
})->name('home')->middleware('auth');
Auth::routes();

Auth::routes();
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');


//tes login
Route::get('/', [LoginController::class, 'login'])->name('login');
Route::post('actionlogin', [LoginController::class, 'actionlogin'])->name('actionlogin');

Route::get('home', [HomeController::class, 'index'])->name('home')->middleware('auth');
Route::get('actionlogout', [LoginController::class, 'actionlogout'])->name('actionlogout')->middleware('auth');

Route::get('ForgotPassword', [ForgotPasswordController::class, 'index'])->name('ForgotPassword');
Route::post('ForgotPassword/action', [ForgotPasswordController::class, 'actionForgotPassword'])->name('actionForgotPassword');
Route::get('forgotpassword/update/{verifykey}', [ForgotPasswordController::class, 'resetpassword'])->name('ResetPassword');
Route::post('ForgotPassword/updatepassword', [ForgotPasswordController::class, 'updatepassword'])->name('updatepassword');

Route::get('register-employee-hgs', [RegisterController::class, 'register'])->name('register');
Route::post('register/action', [RegisterController::class, 'actionregister'])->name('actionregister');
Route::get('register/verify/{verify_key}', [RegisterController::class, 'verify'])->name('verify');
//


// Route::get('register', [UserssController::class, 'register'])->name('register');
// Route::post('register', [UserssController::class, 'register_action'])->name('register.action');
// Route::get('login', [UserssController::class, 'login'])->name('login');
Route::post('login', [UserssController::class, 'login_action'])->name('login.action');
Route::get('password', [UserssController::class, 'password'])->name('password');
Route::post('password', [UserssController::class, 'password_action'])->name('password.action');
Route::get('logout', [UserssController::class, 'logout'])->name('logout');

// Main Page Route

// Route::get('/', $controller_path . '\dashboard\Analytics@index')->name('dashboard-analytics')->middleware('auth');
Route::get('/dashboard/analytics', $controller_path . '\dashboard\Analytics@index')->name('dashboard-analytics');
Route::get('/dashboard/crm', $controller_path . '\dashboard\Crm@index')->name('dashboard-crm');
Route::get('/dashboard/ecommerce', $controller_path . '\dashboard\Ecommerce@index')->name('dashboard-ecommerce');

// locale
Route::get('lang/{locale}', $controller_path . '\language\LanguageController@swap');

// layout
Route::get('/layouts/collapsed-menu', $controller_path . '\layouts\CollapsedMenu@index')->name('layouts-collapsed-menu');
Route::get('/layouts/content-navbar', $controller_path . '\layouts\ContentNavbar@index')->name('layouts-content-navbar');
Route::get('/layouts/content-nav-sidebar', $controller_path . '\layouts\ContentNavSidebar@index')->name('layouts-content-nav-sidebar');
Route::get('/layouts/navbar-full', $controller_path . '\layouts\NavbarFull@index')->name('layouts-navbar-full');
Route::get('/layouts/navbar-full-sidebar', $controller_path . '\layouts\NavbarFullSidebar@index')->name('layouts-navbar-full-sidebar');
Route::get('/layouts/horizontal', $controller_path . '\layouts\Horizontal@index')->name('dashboard-analytics');
Route::get('/layouts/vertical', $controller_path . '\layouts\Vertical@index')->name('dashboard-analytics');
Route::get('/layouts/without-menu', $controller_path . '\layouts\WithoutMenu@index')->name('layouts-without-menu');
Route::get('/layouts/without-navbar', $controller_path . '\layouts\WithoutNavbar@index')->name('layouts-without-navbar');
Route::get('/layouts/fluid', $controller_path . '\layouts\Fluid@index')->name('layouts-fluid');
Route::get('/layouts/container', $controller_path . '\layouts\Container@index')->name('layouts-container');
Route::get('/layouts/blank', $controller_path . '\layouts\Blank@index')->name('layouts-blank');

// apps
Route::get('/app/email', $controller_path . '\apps\Email@index')->name('app-email');
Route::get('/app/chat', $controller_path . '\apps\Chat@index')->name('app-chat');
Route::get('/app/calendar', $controller_path . '\apps\Calendar@index')->name('app-calendar');
Route::get('/app/kanban', $controller_path . '\apps\Kanban@index')->name('app-kanban');
Route::get('/app/invoice/list', $controller_path . '\apps\InvoiceList@index')->name('app-invoice-list');
Route::get('/app/invoice/preview', $controller_path . '\apps\InvoicePreview@index')->name('app-invoice-preview');
Route::get('/app/invoice/print', $controller_path . '\apps\InvoicePrint@index')->name('app-invoice-print');
Route::get('/app/invoice/edit', $controller_path . '\apps\InvoiceEdit@index')->name('app-invoice-edit');
Route::get('/app/invoice/add', $controller_path . '\apps\InvoiceAdd@index')->name('app-invoice-add');
Route::get('/app/user/list', $controller_path . '\apps\UserList@index')->name('app-user-list');
Route::get('/app/user/view/account', $controller_path . '\apps\UserViewAccount@index')->name('app-user-view-account');
Route::get('/app/user/view/security', $controller_path . '\apps\UserViewSecurity@index')->name('app-user-view-security');
Route::get('/app/user/view/billing', $controller_path . '\apps\UserViewBilling@index')->name('app-user-view-billing');
Route::get('/app/user/view/notifications', $controller_path . '\apps\UserViewNotifications@index')->name('app-user-view-notifications');
Route::get('/app/user/view/connections', $controller_path . '\apps\UserViewConnections@index')->name('app-user-view-connections');
Route::get('/app/access-roles', $controller_path . '\apps\AccessRoles@index')->name('app-access-roles');
Route::get('/app/access-permission', $controller_path . '\apps\AccessPermission@index')->name('app-access-permission');

// pages
Route::get('/pages/profile-user', $controller_path . '\pages\UserProfile@index')->name('pages-profile-user');
Route::get('/pages/profile-teams', $controller_path . '\pages\UserTeams@index')->name('pages-profile-teams');
Route::get('/pages/profile-projects', $controller_path . '\pages\UserProjects@index')->name('pages-profile-projects');
Route::get('/pages/profile-connections', $controller_path . '\pages\UserConnections@index')->name('pages-profile-connections');
Route::get('/pages/account-settings-account', $controller_path . '\pages\AccountSettingsAccount@index')->name('pages-account-settings-account');
Route::get('/pages/account-settings-security', $controller_path . '\pages\AccountSettingsSecurity@index')->name('pages-account-settings-security');
Route::get('/pages/account-settings-billing', $controller_path . '\pages\AccountSettingsBilling@index')->name('pages-account-settings-billing');
Route::get('/pages/account-settings-notifications', $controller_path . '\pages\AccountSettingsNotifications@index')->name('pages-account-settings-notifications');
Route::get('/pages/account-settings-connections', $controller_path . '\pages\AccountSettingsConnections@index')->name('pages-account-settings-connections');
Route::get('/pages/faq', $controller_path . '\pages\Faq@index')->name('pages-faq');
Route::get('/pages/help-center-landing', $controller_path . '\pages\HelpCenterLanding@index')->name('pages-help-center-landing');
Route::get('/pages/help-center-categories', $controller_path . '\pages\HelpCenterCategories@index')->name('pages-help-center-categories');
Route::get('/pages/help-center-article', $controller_path . '\pages\HelpCenterArticle@index')->name('pages-help-center-article');
Route::get('/pages/pricing', $controller_path . '\pages\Pricing@index')->name('pages-pricing');
// Removed: pricing-front route — controller App\Http\Controllers\pages\PricingFront does not exist (Sneat template demo, dead reference)
Route::get('/pages/misc-error', $controller_path . '\pages\MiscError@index')->name('pages-misc-error');
Route::get('/pages/misc-under-maintenance', $controller_path . '\pages\MiscUnderMaintenance@index')->name('pages-misc-under-maintenance');
Route::get('/pages/misc-comingsoon', $controller_path . '\pages\MiscComingSoon@index')->name('pages-misc-comingsoon');
Route::get('/pages/misc-not-authorized', $controller_path . '\pages\MiscNotAuthorized@index')->name('pages-misc-not-authorized');

// authentication (Sneat template demo routes — only Basic & Cover variants installed)
// Removed: *Front variant routes (LoginFront, RegisterFront, VerifyEmailFront, ResetPasswordFront,
//          ForgotPasswordFront, TwoStepsFront) — controllers tidak terinstall, break route:list.
Route::get('/auth/login-basic', $controller_path . '\authentications\LoginBasic@index')->name('auth-login-basic');
Route::get('/auth/login-cover', $controller_path . '\authentications\LoginCover@index')->name('auth-login-cover');
Route::get('/auth/register-basic', $controller_path . '\authentications\RegisterBasic@index')->name('auth-register-basic');
Route::get('/auth/register-cover', $controller_path . '\authentications\RegisterCover@index')->name('auth-register-cover');
Route::get('/auth/register-multisteps', $controller_path . '\authentications\RegisterMultiSteps@index')->name('auth-register-multisteps');
Route::get('/auth/verify-email-basic', $controller_path . '\authentications\VerifyEmailBasic@index')->name('auth-verify-email-basic');
Route::get('/auth/verify-email-cover', $controller_path . '\authentications\VerifyEmailCover@index')->name('auth-verify-email-cover');
Route::get('/auth/reset-password-basic', $controller_path . '\authentications\ResetPasswordBasic@index')->name('auth-reset-password-basic');
Route::get('/auth/reset-password-cover', $controller_path . '\authentications\ResetPasswordCover@index')->name('auth-reset-password-cover');
Route::get('/auth/forgot-password-basic', $controller_path . '\authentications\ForgotPasswordBasic@index')->name('auth-reset-password-basic');
Route::get('/auth/forgot-password-cover', $controller_path . '\authentications\ForgotPasswordCover@index')->name('auth-forgot-password-cover');
Route::get('/auth/two-steps-basic', $controller_path . '\authentications\TwoStepsBasic@index')->name('auth-two-steps-basic');
Route::get('/auth/two-steps-cover', $controller_path . '\authentications\TwoStepsCover@index')->name('auth-two-steps-cover');

// wizard example
Route::get('/wizard/ex-checkout', $controller_path . '\wizard_example\Checkout@index')->name('wizard-ex-checkout');
Route::get('/wizard/ex-property-listing', $controller_path . '\wizard_example\PropertyListing@index')->name('wizard-ex-property-listing');
Route::get('/wizard/ex-create-deal', $controller_path . '\wizard_example\CreateDeal@index')->name('wizard-ex-create-deal');

// modal
Route::get('/modal-examples', $controller_path . '\modal\ModalExample@index')->name('modal-examples');

// cards
Route::get('/cards/basic', $controller_path . '\cards\CardBasic@index')->name('cards-basic');
Route::get('/cards/advance', $controller_path . '\cards\CardAdvance@index')->name('cards-advance');
Route::get('/cards/statistics', $controller_path . '\cards\CardStatistics@index')->name('cards-statistics');
Route::get('/cards/analytics', $controller_path . '\cards\CardAnalytics@index')->name('cards-analytics');
Route::get('/cards/gamifications', $controller_path . '\cards\CardGamifications@index')->name('cards-gamifications');
Route::get('/cards/actions', $controller_path . '\cards\CardActions@index')->name('cards-actions');

// User Interface
Route::get('/ui/accordion', $controller_path . '\user_interface\Accordion@index')->name('ui-accordion');
Route::get('/ui/alerts', $controller_path . '\user_interface\Alerts@index')->name('ui-alerts');
Route::get('/ui/badges', $controller_path . '\user_interface\Badges@index')->name('ui-badges');
Route::get('/ui/buttons', $controller_path . '\user_interface\Buttons@index')->name('ui-buttons');
Route::get('/ui/carousel', $controller_path . '\user_interface\Carousel@index')->name('ui-carousel');
Route::get('/ui/collapse', $controller_path . '\user_interface\Collapse@index')->name('ui-collapse');
Route::get('/ui/dropdowns', $controller_path . '\user_interface\Dropdowns@index')->name('ui-dropdowns');
Route::get('/ui/footer', $controller_path . '\user_interface\Footer@index')->name('ui-footer');
Route::get('/ui/list-groups', $controller_path . '\user_interface\ListGroups@index')->name('ui-list-groups');
Route::get('/ui/modals', $controller_path . '\user_interface\Modals@index')->name('ui-modals');
Route::get('/ui/navbar', $controller_path . '\user_interface\Navbar@index')->name('ui-navbar');
Route::get('/ui/offcanvas', $controller_path . '\user_interface\Offcanvas@index')->name('ui-offcanvas');
Route::get('/ui/pagination-breadcrumbs', $controller_path . '\user_interface\PaginationBreadcrumbs@index')->name('ui-pagination-breadcrumbs');
Route::get('/ui/progress', $controller_path . '\user_interface\Progress@index')->name('ui-progress');
Route::get('/ui/spinners', $controller_path . '\user_interface\Spinners@index')->name('ui-spinners');
Route::get('/ui/tabs-pills', $controller_path . '\user_interface\TabsPills@index')->name('ui-tabs-pills');
Route::get('/ui/toasts', $controller_path . '\user_interface\Toasts@index')->name('ui-toasts');
Route::get('/ui/tooltips-popovers', $controller_path . '\user_interface\TooltipsPopovers@index')->name('ui-tooltips-popovers');
Route::get('/ui/typography', $controller_path . '\user_interface\Typography@index')->name('ui-typography');

// extended ui
Route::get('/extended/ui-avatar', $controller_path . '\extended_ui\Avatar@index')->name('extended-ui-avatar');
Route::get('/extended/ui-blockui', $controller_path . '\extended_ui\BlockUI@index')->name('extended-ui-blockui');
Route::get('/extended/ui-drag-and-drop', $controller_path . '\extended_ui\DragAndDrop@index')->name('extended-ui-drag-and-drop');
Route::get('/extended/ui-media-player', $controller_path . '\extended_ui\MediaPlayer@index')->name('extended-ui-media-player');
Route::get('/extended/ui-perfect-scrollbar', $controller_path . '\extended_ui\PerfectScrollbar@index')->name('extended-ui-perfect-scrollbar');
Route::get('/extended/ui-star-ratings', $controller_path . '\extended_ui\StarRatings@index')->name('extended-ui-star-ratings');
Route::get('/extended/ui-sweetalert2', $controller_path . '\extended_ui\SweetAlert@index')->name('extended-ui-sweetalert2');
Route::get('/extended/ui-text-divider', $controller_path . '\extended_ui\TextDivider@index')->name('extended-ui-text-divider');
Route::get('/extended/ui-timeline-basic', $controller_path . '\extended_ui\TimelineBasic@index')->name('extended-ui-timeline-basic');
Route::get('/extended/ui-timeline-fullscreen', $controller_path . '\extended_ui\TimelineFullscreen@index')->name('extended-ui-timeline-fullscreen');
Route::get('/extended/ui-tour', $controller_path . '\extended_ui\Tour@index')->name('extended-ui-tour');
Route::get('/extended/ui-treeview', $controller_path . '\extended_ui\Treeview@index')->name('extended-ui-treeview');
Route::get('/extended/ui-misc', $controller_path . '\extended_ui\Misc@index')->name('extended-ui-misc');

// icons
Route::get('/icons/boxicons', $controller_path . '\icons\Boxicons@index')->name('icons-boxicons');
Route::get('/icons/font-awesome', $controller_path . '\icons\FontAwesome@index')->name('icons-font-awesome');

// form elements
Route::get('/forms/basic-inputs', $controller_path . '\form_elements\BasicInput@index')->name('forms-basic-inputs');
Route::get('/forms/input-groups', $controller_path . '\form_elements\InputGroups@index')->name('forms-input-groups');
Route::get('/forms/custom-options', $controller_path . '\form_elements\CustomOptions@index')->name('forms-custom-options');
Route::get('/forms/editors', $controller_path . '\form_elements\Editors@index')->name('forms-editors');
Route::get('/forms/file-upload', $controller_path . '\form_elements\FileUpload@index')->name('forms-file-upload');
Route::get('/forms/pickers', $controller_path . '\form_elements\Picker@index')->name('forms-pickers');
Route::get('/forms/selects', $controller_path . '\form_elements\Selects@index')->name('forms-selects');
Route::get('/forms/sliders', $controller_path . '\form_elements\Sliders@index')->name('forms-sliders');
Route::get('/forms/switches', $controller_path . '\form_elements\Switches@index')->name('forms-switches');
Route::get('/forms/extras', $controller_path . '\form_elements\Extras@index')->name('forms-extras');

// form layouts
Route::get('/form/layouts-vertical', $controller_path . '\form_layouts\VerticalForm@index')->name('form-layouts-vertical');
Route::get('/form/layouts-horizontal', $controller_path . '\form_layouts\HorizontalForm@index')->name('form-layouts-horizontal');
Route::get('/form/layouts-sticky', $controller_path . '\form_layouts\StickyActions@index')->name('form-layouts-sticky');

// form wizards
Route::get('/form/wizard-numbered', $controller_path . '\form_wizard\Numbered@index')->name('form-wizard-numbered');
Route::get('/form/wizard-icons', $controller_path . '\form_wizard\Icons@index')->name('form-wizard-icons');
Route::get('/form/validation', $controller_path . '\form_validation\Validation@index')->name('form-validation');

// tables
Route::get('/tables/basic', $controller_path . '\tables\Basic@index')->name('tables-basic');
Route::get('/tables/datatables-basic', $controller_path . '\tables\DatatableBasic@index')->name('tables-datatables-basic');
Route::get('/tables/datatables-advanced', $controller_path . '\tables\DatatableAdvanced@index')->name('tables-datatables-advanced');
Route::get('/tables/datatables-extensions', $controller_path . '\tables\DatatableExtensions@index')->name('tables-datatables-extensions');

// charts
Route::get('/charts/apex', $controller_path . '\charts\ApexCharts@index')->name('charts-apex');
Route::get('/charts/chartjs', $controller_path . '\charts\ChartJs@index')->name('charts-chartjs');

// maps
Route::get('/maps/leaflet', $controller_path . '\maps\Leaflet@index')->name('maps-leaflet');

// laravel example
Route::get('/laravel/user-management', [UserManagement::class, 'UserManagement'])->name('laravel-example-user-management');
Route::resource('/user-list', UserManagement::class);

//Report
Route::get('/report', [ReportController::class, 'index_report'])->middleware('auth');

//Report HRD CREATE
Route::get('/report', [Report_HRD_Controller::class, 'ReportHRD'])->middleware('auth');
Route::get('/report_call', [Report_HRD_Controller::class, 'ReportCall'])->middleware('auth');
Route::get('/report_interview', [Report_HRD_Controller::class, 'ReportInterview'])->middleware('auth');
Route::post('/report', [Report_HRD_Controller::class, 'store'])->middleware('auth');
Route::post('/report/report_interview/{id}',[Report_HRD_Controller::class, 'post_interview'])->middleware('auth');
//Report HRD List
Route::get('/list_report', [Report_HRD_Controller::class, 'index_report'])->middleware('auth');
Route::get('/list_report_daily', [Report_HRD_Controller::class, 'index_report_daily'])->middleware('auth');
Route::get('/list_report_weekly', [Report_HRD_Controller::class, 'index_report_weekly'])->middleware('auth');
Route::get('/list_report_monthly', [Report_HRD_Controller::class, 'index_report_monthly'])->middleware('auth');
Route::get('/CandidateRegister', [Report_HRD_Controller::class, 'index_register'])->middleware('auth');
Route::get('/report/show_detail/{Tr_report_hrd_main_code}', [Report_HRD_Controller::class, 'view_detail'])->middleware('auth');
Route::get('/report/detail_closing/{Ms_User_Code}', [Report_HRD_Controller::class, 'view_detail_closing'])->middleware('auth');


//Dashboard
Route::get('/list_report_all_history_new_perday', [Report_HRD_Controller::class, 'index_list_report_all_history_new_perday'])->middleware('auth');
Route::get('/list_report_all_history_new_weekly', [Report_HRD_Controller::class, 'index_list_report_all_history_new_weekly'])->middleware('auth');
Route::get('/list_report_all_history_new_monthly', [Report_HRD_Controller::class, 'index_list_report_all_history_new_monthly'])->middleware('auth');
Route::get('/report_laka', [BeritaAcaraController::class, 'report_laka'])->middleware('auth');
Route::get('/list_report_opening', [Report_HRD_Controller::class, 'index_report_opening'])->middleware('auth');
Route::get('/list_report_all_history', [Report_HRD_Controller::class, 'index_report_all_history'])->middleware('auth');
Route::get('/list_report_all_history_weekly', [Report_HRD_Controller::class, 'index_report_all_history_weekly'])->middleware('auth');
Route::get('/list_report_all_history_monthly', [Report_HRD_Controller::class, 'index_report_all_history_monthly'])->middleware('auth');
Route::get('/list_report_call', [Report_HRD_Controller::class, 'index_report_call'])->middleware('auth');
// Route::post('/list_report_call', [Report_HRD_Controller::class, 'imports']);
Route::get('/list_report_interview', [Report_HRD_Controller::class, 'index_report_interview'])->middleware('auth');
Route::get('/list_report_dashboard', [Report_HRD_Controller::class, 'index_report_dashboard'])->middleware('auth');
// Route::get('/show_detail/{Tr_report_hrd_main_code}', [Report_HRD_Controller::class, 'view_detail']);

//Report Security
Route::get ('/report_memo', [ReportSecurityController::class, 'create_memo'])->middleware('auth');
Route::get ('/temuan', [ReportSecurityController::class, 'create_temuan'])->middleware('auth');
Route::post ('/report_memo', [ReportSecurityController::class, 'store'])->middleware('auth');

//Berita Acara
Route::get ('/input_berita_acara_spv', [BeritaAcaraController::class, 'index_berita_acara_spv'])->middleware('auth');
Route::post ('/input_berita_acara_spv', [BeritaAcaraController::class, 'store_berita_acara_spv'])->middleware('auth');

Route::get ('/ba_laka', [BeritaAcaraController::class, 'ba_laka'])->middleware('auth');
Route::post ('/ba_laka', [BeritaAcaraController::class, 'store_ba_laka'])->middleware('auth');

Route::get ('/beritaacara', [BeritaAcaraController::class, 'index_ba'])->middleware('auth');
Route::get ('/berita_acara_laka', [BeritaAcaraController::class, 'index_ba_laka'])->middleware('auth');
Route::post ('/berita_acara_laka', [BeritaAcaraController::class, 'store_ba'])->middleware('auth');
// Route::get('/berita_acara/print_berita_acara_salahisi/{Tr_BA_Code}', [BeritaAcaraController::class, 'print_ba'])->middleware('auth');
Route::get('/berita_acara/print_berita_acara_salahisi/{id}', [BeritaAcaraController::class, 'print_ba'])->middleware('auth');
Route::get('pdf', [BeritaAcaraController::class, 'exportPDF'])->name('export_pdf')->middleware('auth');
Route::get('/berita_acara/print_berita_acara_laka/{Tr_BA_Code}', [BeritaAcaraController::class, 'print_ba_laka'])->middleware('auth');
Route::get('/berita_acara/report_ba', [BeritaAcaraController::class, 'report_ba'])->middleware('auth');
// Route::post('search_report_ba/report_ba', [BeritaAcaraController::class, 'search_report_ba'])->middleware('auth');
Route::get('search_report_ba', [BeritaAcaraController::class, 'search_report_ba'])->name('search_report_ba')->middleware('auth');
Route::post('search_report_laka/report_ba', [BeritaAcaraController::class, 'search_report_laka'])->middleware('auth');
Route::post('search_report_revisi/report_ba', [BeritaAcaraController::class, 'search_report_revisi'])->middleware('auth');

//dashboard
Route::get ('/dashboard_ba_laka', [BeritaAcaraController::class, 'dashboard_ba_laka'])->middleware('auth');
// Route::get ('/dashboard_ba', [BeritaAcaraController::class, 'dashboard_ba'])->middleware('auth');
Route::get ('/dashboard_ba', [BeritaAcaraController::class, 'dashboard_ba'])->middleware('auth');


// BA
Route::get('/home_ba', [BeritaAcaraController::class, 'home_ba'])->middleware('auth');
Route::get('/input_berita_acara', [BeritaAcaraController::class, 'index_all_ba'])->middleware('auth');
Route::post('/input_berita_acara_data', [BeritaAcaraController::class, 'store_all_ba'])->middleware('auth');
Route::get('/input_berita_acara/{Tr_BA_Code}', [BeritaAcaraController::class, 'print_ba_user'])->middleware('auth');

// Request Revisi
Route::get('/request_revisi', [BeritaAcaraController::class, 'index_request_revisi'])->middleware('auth');
Route::post('/request_revisi', [BeritaAcaraController::class, 'store_request_revisi'])->middleware('auth');
Route::get('/request_revisi/{Tr_BA_Code}', [BeritaAcaraController::class, 'print_request_revisi'])->middleware('auth');
Route::get('/list_request', [BeritaAcaraController::class, 'list_request'])->middleware('auth');
Route::get('/dashboard_revisi', [BeritaAcaraController::class, 'dashboard_revisi'])->middleware('auth');
Route::get('/list_request_koord', [BeritaAcaraController::class, 'list_request_untuk_koord'])->middleware('auth');


//Validasi Koord.
Route::get('/validasi_koord', [BeritaAcaraController::class, 'validasi_ba_koord'])->middleware('auth');
Route::get('/detail_validasi_koord/{Tr_BA_Code}', [BeritaAcaraController::class, 'detail_validasi_koord'])->middleware('auth');
Route::post('/detail_validasi_koord/{id}', [BeritaAcaraController::class, 'store_validasi1_koord'])->middleware('auth');
//Validasi spv
Route::get('/validasi_ba', [BeritaAcaraController::class, 'validasi_ba'])->middleware('auth');
Route::get('/detail_validasi/{Tr_BA_Code}', [BeritaAcaraController::class, 'detail_validasi'])->middleware('auth');
Route::post('/detail_validasi/{id}', [BeritaAcaraController::class, 'store_validasi1'])->middleware('auth');
//Validasi hrd
Route::get('/validasi_ba2', [BeritaAcaraController::class, 'validasi_ba2'])->middleware('auth');
Route::get('/detail_validasi2/{Tr_BA_Code}', [BeritaAcaraController::class, 'detail_validasi2'])->middleware('auth');
Route::post('/detail_validasi2/{id}', [BeritaAcaraController::class, 'store_validasi2'])->middleware('auth');
//Validasi finance
Route::get('/validasi_ba3', [BeritaAcaraController::class, 'validasi_ba3'])->middleware('auth');
Route::get('/detail_validasi3/{Tr_BA_Code}', [BeritaAcaraController::class, 'detail_validasi3'])->middleware('auth');
Route::post('/detail_validasi3/{id}', [BeritaAcaraController::class, 'store_validasi3'])->middleware('auth');

//Validasi manager
Route::get('/validasi_manager', [BeritaAcaraController::class, 'validasi_manager'])->middleware('auth');
Route::get('/detail_validasi_mngr/{Tr_BA_Code}', [BeritaAcaraController::class, 'detail_validasi_manager'])->middleware('auth');
Route::post('/detail_validasi_mngr/{id}', [BeritaAcaraController::class, 'store_validasi_manager'])->middleware('auth');

//Validasi GM
Route::get('/validasi_gm', [BeritaAcaraController::class, 'validasi_gm'])->middleware('auth');
Route::get('/detail_validasi_gm/{Tr_BA_Code}', [BeritaAcaraController::class, 'detail_validasi_gm'])->middleware('auth');
Route::post('/detail_validasi_gm/{id}', [BeritaAcaraController::class, 'store_validasi_gm'])->middleware('auth');

//Validasi IT
Route::get('/validasi_it', [BeritaAcaraController::class, 'validasi_it'])->middleware('auth');
Route::get('/detail_validasi_it/{Tr_BA_Code}', [BeritaAcaraController::class, 'detail_validasi_it'])->middleware('auth');
Route::post('/detail_validasi_it/{id}', [BeritaAcaraController::class, 'store_validasi_it'])->middleware('auth');

//Validasi BOD
Route::get('/validasi_bod', [BeritaAcaraController::class, 'validasi_bod'])->middleware('auth');
Route::get('/detail_validasi_bod/{Tr_BA_Code}', [BeritaAcaraController::class, 'detail_validasi_bod'])->middleware('auth');
Route::post('/detail_validasi_bod/{id}', [BeritaAcaraController::class, 'store_validasi_bod'])->middleware('auth');

//Test
Route::get('/testdobel', [BeritaAcaraController::class, 'testdobel'])->middleware('auth');


Route::get('/route2', function () {
    return "Ini adalah Tautan 2";
})->name('route_name_2');

//candidate create cv
Route::get('/tr_candidates/candidate_apply', [tr_candidateController::class, 'index_cv']);
Route::post('/tr_candidates/candidate_apply', [tr_candidateController::class, 'store_cv']);
Route::post('/tr_candidates/validasi_jobportal', [tr_candidateController::class, 'store_from_erika']);

//candidate all
Route::get('/tr_candidates/all_candidates',[LoginCompanyController::class, 'kandidat_all'])->middleware('auth');
Route::get('/detail_kandidat/detail_kandidat_progress/{Handphone}',[tr_candidateController::class, 'detail_kandidat_progress'])->middleware('auth');
Route::get('/detail_kandidat/download_cv/{Handphone}',[tr_candidateController::class, 'download_cv'])->middleware('auth');
Route::post('/tr_candidates/all_candidates/{Email}',[LoginCompanyController::class, 'update_candidate_by_email'])->middleware('auth');
Route::post('/all_candidates', [LoginCompanyController::class, 'update_candidate_by_email'])->name('all_candidates');

Route::get('edit_status/{Email}', [LoginCompanyController::class, 'editstatus'])->middleware('auth');
Route::post('update_status', [LoginCompanyController::class, 'update_status'])->middleware('auth');


Route::get('/tr_candidates/edit_from_jobportal/{Email}',[tr_candidateController::class, 'edit_from_erika'])->middleware('auth');

//candidate belum shortlist
Route::get('/tr_candidates/kandidat_belum_short',[LoginCompanyController::class, 'kandidat_belum'])->middleware('auth');
Route::get('/detail_kandidat/detail_kandidat_belum_short/{Handphone}',[tr_candidateController::class, 'detail_belum_short'])->middleware('auth');

//candidate lolos shortlist
Route::get('/tr_candidates/kandidat_lolos_short',[LoginCompanyController::class, 'kandidat_lolos_shortlist'])->middleware('auth');
Route::get('/detail_kandidat/detail_kandidat_lolos_short/{Handphone}',[LoginCompanyController::class, 'detail_kandidat_lolos_shortlist'])->middleware('auth');

//candidate tidak lolos shortlist
Route::get('/tr_candidates/kandidat_gagal_short',[LoginCompanyController::class, 'kandidat_gagal_shortlist'])->middleware('auth');
Route::get('/detail_kandidat/detail_kandidat_gagal_short/{Handphone}',[LoginCompanyController::class, 'detail_kandidat_gagal_shortlist'])->middleware('auth');

//Candidate shortlist
Route::get('/tr_candidates/Shortlist/{id}', [tr_candidateController::class, 'shortlist1'])->middleware('auth');
Route::post('/tr_candidates/Shortlist/{id}', [tr_candidateController::class, 'shortlistPost'])->middleware('auth');

//candidate Belum Dihubungi
Route::get('/tr_candidates/kandidat_belum_dihubungi',[LoginCompanyController::class, 'kandidat_belum_dihubungi'])->middleware('auth');
Route::get('/detail_kandidat/detail_kandidat_belum_dihubungi/{Handphone}',[LoginCompanyController::class, 'detail_kandidat_belum_dihubungi'])->middleware('auth');

//Candidate Panggil HRD
Route::get('/tr_candidates/candidate_Call/{Handphone}',[tr_candidateController::class, 'validasipanggilhrd'])->middleware('auth');
Route::post('/tr_candidates/kandidat_belum_dihubungi/{id}',[tr_candidateController::class, 'post_panggil'])->middleware('auth');

//candidate Panggilan Terhubung
Route::get('/tr_candidates/kandidat_dapat_dihubungi',[LoginCompanyController::class, 'kandidat_terhubung'])->middleware('auth');
Route::get('/detail_kandidat/detail_kandidat_terhubung/{Handphone}',[LoginCompanyController::class, 'detail_kandidat_terhubung'])->middleware('auth');

//candidate Panggilan Tidak Terhubung
Route::get('/tr_candidates/kandidat_tidak_dapat_dihubungi',[LoginCompanyController::class, 'kandidat_tidak_terhubung'])->middleware('auth');
// Route::get('/detail_kandidat/detail_kandidat_tidak_terhubung/{Handphone}',[LoginCompanyController::class, 'detail_kandidat_tidak_terhubung'])->middleware('auth');
Route::get('/detail_kandidat/detail_kandidat_tidak_terhubung/{Handphone}',[LoginCompanyController::class, 'detail_kandidat_tidak_terhubung'])->middleware('auth');

//candidate Belum Interview
Route::get('/tr_candidates/kandidat_belum_interview',[LoginCompanyController::class, 'kandidat_belum_interview'])->middleware('auth');
Route::get('/detail_kandidat/detail_kandidat_belum_interview/{Handphone}',[LoginCompanyController::class, 'detail_kandidat_belum_interview'])->middleware('auth');

//Candidate Interview
Route::get('/tr_candidates/candidate_interview/{Handphone}',[tr_candidateController::class, 'validasi_interview'])->middleware('auth');
Route::post('/tr_candidates/candidate_interview/{id}',[tr_candidateController::class, 'post_interview'])->middleware('auth');

//Interview 2
Route::get('/tr_candidates/kandidat_interview2',[LoginCompanyController::class, 'kandidat_belum_interview2'])->middleware('auth');
Route::get('/detail_kandidat/detail_kandidat_belum_interview2/{Handphone}',[LoginCompanyController::class, 'detail_kandidat_belum_interview2'])->middleware('auth');
Route::post('/tr_candidates/candidate_interview2/{id}',[tr_candidateController::class, 'post_interview2'])->middleware('auth');
//Interview 3
Route::get('/tr_candidates/kandidat_interview3',[LoginCompanyController::class, 'kandidat_belum_interview3'])->middleware('auth');
Route::get('/detail_kandidat/detail_kandidat_belum_interview3/{Handphone}',[LoginCompanyController::class, 'detail_kandidat_belum_interview3'])->middleware('auth');
Route::post('/tr_candidates/candidate_interview3/{id}',[tr_candidateController::class, 'post_interview3'])->middleware('auth');

//candidate Lolos Interview
Route::get('/tr_candidates/kandidat_lolos_interview',[LoginCompanyController::class, 'kandidat_lolos_interview'])->middleware('auth');
Route::get('/detail_kandidat/detail_kandidat_lolos_interview/{Handphone}',[LoginCompanyController::class, 'detail_kandidat_lolos_interview'])->middleware('auth');

//candidate Tidak Lolos Interview
Route::get('/tr_candidates/kandidat_tidak_lolos_interview',[LoginCompanyController::class, 'kandidat_tidak_lolos_interview'])->middleware('auth');
Route::get('/detail_kandidat/detail_kandidat_tidak_lolos_interview/{Handphone}',[LoginCompanyController::class, 'detail_kandidat_tidak_lolos_interview'])->middleware('auth');

//SP
//Type SP
Route::get('/sp/master_type', [MS_Type_SP_Controller::class, 'index'])->middleware('auth');
Route::post('add-update-type', [MS_Type_SP_Controller::class, 'store'])->middleware('auth');
Route::post('edit-type', [MS_Type_SP_Controller::class, 'edit'])->middleware('auth');
Route::post('delete-type', [MS_Type_SP_Controller::class, 'destroy'])->middleware('auth');

//MS Lokasi
// Removed: 4 routes (kir/master_lokasi, add-update-branch, edit-branch, delete-branch) — controller
// App\Http\Controllers\MSBranchPasswordController does not exist (legacy dead reference, no view referencing).
// Functional equivalent ada di routes /lokasi/master_lokasi (MsLocationController) di bawah.
//master lokasi
Route::get('/lokasi/master_lokasi', [MsLocationController::class, 'index'])->middleware('auth');
Route::post('add-update-lokasi', [MsLocationController::class, 'store'])->middleware('auth');
Route::post('edit-lokasi', [MsLocationController::class, 'edit'])->middleware('auth');
Route::post('delete-lokasi', [MsLocationController::class, 'destroy'])->middleware('auth');

//Company
Route::get('/lokasi/company', [MS_Company_Controller::class, 'index'])->middleware('auth');
Route::post('add-update-branch', [MS_Company_Controller::class, 'store'])->middleware('auth');
Route::post('edit-branch', [MS_Company_Controller::class, 'edit'])->middleware('auth');
Route::post('delete-branch', [MS_Company_Controller::class, 'destroy'])->middleware('auth');

// SP1
Route::get ('/sp/form_sp1',[Tr_Sp_Controller::class, 'index_sp1'])->middleware('auth');
Route::post('/form_sp1', [Tr_Sp_Controller::class, 'store_sp1'])->middleware('auth');

Route::get ('/sp_history',[Tr_Sp_Controller::class, 'history'])->middleware('auth');
Route::get ('/sp/detail_sp/{sp_main_code}', [Tr_Sp_Controller::class, 'detail_view_sp'])->middleware('auth');


Route::get('/import_data',[import_dataController::class, 'import_data'])->middleware('auth');
Route::post('/import_data',[import_dataController::class, 'import'])->middleware('auth');

Route::get('/isi_kandidat',[tr_candidateController::class, 'isi_kandidat'])->middleware('auth');
Route::post('/tr_candidates/isi_kandidat', [tr_candidateController::class, 'store_from_isi_kandidat']);
Route::get('/jadwal_interview',[tr_candidateController::class, 'lihat_jadwal'])->middleware('auth');

//JOB PORTAL
Route::get('/cv_jobportal',[LoginCompanyController::class, 'kandidat_all_jobportal'])->middleware('auth');
Route::get('/detail_kandidat/detail_kandidat_progress_jobportal/{Handphone}',[tr_candidateController::class, 'detail_kandidat_progress_jobportal'])->middleware('auth');
Route::get('/kandidat_belum_dihubungi_jobportal',[LoginCompanyController::class, 'kandidat_belum_dihubungi_jobportal'])->middleware('auth');
Route::get('/detail_kandidat/detail_kandidat_belum_dihubungi_jobportal/{Handphone}',[LoginCompanyController::class, 'detail_kandidat_belum_dihubungi_jobportal'])->middleware('auth');
Route::post('/kandidat_belum_dihubungi_jobportal/{id}',[tr_candidateController::class, 'post_panggiljobportal'])->middleware('auth');
Route::get('/kandidat_belum_interview_jobportal',[LoginCompanyController::class, 'kandidat_belum_interview_jobportal'])->middleware('auth');
Route::get('/detail_kandidat_belum_interview_jobportal/{Handphone}',[LoginCompanyController::class, 'detail_kandidat_belum_interview_jobportal'])->middleware('auth');
Route::post('/tr_candidates/candidate_interview_jobportal/{id}',[tr_candidateController::class, 'post_interview_jobportal'])->middleware('auth');
Route::get('/kandidat_belum_short_jobportal',[LoginCompanyController::class, 'kandidat_belum_short_portal'])->middleware('auth');

Route::get('/driver_apply', [tr_candidateController::class, 'driver_apply']);
Route::post('/tr_candidates/candidate_apply_driver', [tr_candidateController::class, 'store_cv_driver']);

Route::get('/dashboard_semua_ba', [BeritaAcaraController::class, 'dashboard_semua_ba'])->middleware('auth');
Route::get('/detail_pelaku/{Tr_report_hrd_main_code}', [BeritaAcaraController::class, 'view_detail_pelaku'])->middleware('auth');
Route::get('/detail_pelaku_week/{Tr_report_hrd_main_code}', [BeritaAcaraController::class, 'view_detail_pelaku_week'])->middleware('auth');
Route::get('/detail_pelaku_month/{Tr_report_hrd_main_code}', [BeritaAcaraController::class, 'view_detail_pelaku_month'])->middleware('auth');

//Baru yongky
Route::get('/viewkategoriday/{id}', [BeritaAcaraController::class, 'viewkategoriday'])->middleware('auth');
Route::get('/viewkategoriweek/{id}', [BeritaAcaraController::class, 'viewkategoriweek'])->middleware('auth');
Route::get('/viewkategorimonth/{id}', [BeritaAcaraController::class, 'viewkategorimonth'])->middleware('auth');


Route::get ('/dashboard_weekly', [DashboardController::class, 'get_weekly'])->middleware('auth');
Route::get ('/dashboard_monthly', [DashboardController::class, 'get_monthly'])->middleware('auth');


//Asasmen

Route::get ('/asasmen/all_staff', [Tr_AssasmenController::class, 'all_staff'])->middleware('auth');
Route::get ('/asasmen/create_asasmen_basic', [Tr_AssasmenController::class, 'create_basic'])->middleware('auth');
Route::get ('/asasmen/create_asasmen_basic/{emp_name}', [Tr_AssasmenController::class, 'create_spv'])->middleware('auth');
Route::post ('/asasmen/asasmen_basics', [Tr_AssasmenController::class, 'simpan_basic'])->middleware('auth');
Route::get ('/history_asasmen', [Tr_AssasmenController::class, 'history_basic'])->middleware('auth');
Route::get ('/print_asasmen/{Tr_Emp_Asses_Code}', [Tr_AssasmenController::class, 'print_basic'])->middleware('auth');
// assasmen report
Route::get('/report_asesmen_data', [Tr_AssasmenController::class, 'report_asesmen_data'])->name('Attendance')->middleware('auth');
Route::get('report_asesmen_pot/{verify_key}', [Tr_AssasmenController::class, 'report_asesmen_pot'])->name('report_asesmen_pot');

//basic
Route::post ('/asasmen/asasmen_save_basics', [Tr_AssasmenController::class, 'savedata_basic'])->middleware('auth');
Route::post ('/asasmen/asasmen_save_basics_hrd', [Tr_AssasmenController::class, 'savedata_basic_hrd'])->middleware('auth');
Route::post ('/asasmen/asasmen_save_basics_spv', [Tr_AssasmenController::class, 'savedata_basic_spv'])->middleware('auth');
Route::get ('/asasmen/asasmen_leaderships', [Tr_AssasmenController::class, 'asasmen_leaderships'])->middleware('auth');
Route::post ('/asasmen/asasmen_leaderships_seve', [Tr_AssasmenController::class, 'asasmen_leaderships_seve'])->name('store_disiplin')->middleware('auth');
Route::get ('/asasmen_leaderships_print/{Tr_Emp_Asses_Code}', [Tr_AssasmenController::class, 'asasmen_leaderships_print'])->middleware('auth');

Route::get('/asasmen_basics_edit/{post}/edit', [Tr_AssasmenController::class, 'asasmen_basics_edit'])->middleware('auth');
Route::get('/asasmen_basics_edit_spv/{post}/edit', [Tr_AssasmenController::class, 'asasmen_basics_edit_spv'])->middleware('auth');
Route::get('/asasmen_basics_edit_hrd/{post}/edit', [Tr_AssasmenController::class, 'asasmen_basics_edit_hrd'])->middleware('auth');


//leaderships
Route::get ('/asasmen/leaderships_staf', [Tr_AssasmenController::class, 'leaderships_staf'])->middleware('auth');
Route::get ('/asasmen/create_ld_asasmen/{emp_name}', [Tr_AssasmenController::class, 'create_ld_asasmen'])->middleware('auth');
Route::post ('/asasmen/asesmen_ld_save_leadership', [Tr_AssasmenController::class, 'save_leadership'])->middleware('auth');
Route::get ('/print_leadership/{Tr_Emp_Asses_Code}', [Tr_AssasmenController::class, 'print_leadership'])->middleware('auth');
Route::get('/asasmen_leadership_edit_hrd/{post}/edit', [Tr_AssasmenController::class, 'asasmen_leadership_edit_hrd'])->middleware('auth');
Route::post ('/asasmen/save_leadership_hrd', [Tr_AssasmenController::class, 'save_leadership_hrd'])->middleware('auth');
Route::get ('/print_ld_asasmen_hrd/{Tr_Emp_Asses_Code}/{test}', [Tr_AssasmenController::class, 'print_leadership_hrd'])->middleware('auth');

Route::get('/asasmen_leadership_edit_spv/{post}/edit', [Tr_AssasmenController::class, 'asasmen_leadership_edit_spv'])->middleware('auth');
Route::post ('/asasmen/save_leadership_spv', [Tr_AssasmenController::class, 'save_leadership_spv'])->middleware('auth');
Route::get ('/print_ld_asasmen_spv/{Tr_Emp_Asses_Code}/{test}', [Tr_AssasmenController::class, 'print_leadership_spv'])->middleware('auth');

Route::get ('/asasmen/create_leadership_asas/{emp_name}', [Tr_AssasmenController::class, 'create_leadership_asas'])->middleware('auth');
Route::post ('/asasmen/asasmen_save_leadership', [Tr_AssasmenController::class, 'save_leadership_asas'])->middleware('auth');
Route::get ('/print_leadership_asas/{Tr_Emp_Asses_Code}', [Tr_AssasmenController::class, 'print_leadership_asas'])->middleware('auth');

//discipline
Route::get ('/asasmen/create_discipline_asas/{emp_name}', [Tr_AssasmenController::class, 'create_discipline_asas'])->middleware('auth');
Route::post ('/asasmen/asasmen_save_discipline', [Tr_AssasmenController::class, 'save_discipline_asas'])->middleware('auth');
Route::get ('/print_discipline_asas/{Tr_Emp_Asses_Code}', [Tr_AssasmenController::class, 'print_discipline_asas'])->middleware('auth');
Route::get('/asasmen_discipline_edit_hrd/{post}/edit', [Tr_AssasmenController::class, 'asasmen_discipline_edit_hrd'])->middleware('auth');
Route::post ('/asasmen/save_discipline_hrd', [Tr_AssasmenController::class, 'save_discipline_hrd'])->middleware('auth');
Route::get ('/print_discipline_asasmen_hrd/{Tr_Emp_Asses_Code}/{test}', [Tr_AssasmenController::class, 'print_discipline_hrd'])->middleware('auth');
Route::get('/asasmen_discipline_edit_spv/{post}/edit', [Tr_AssasmenController::class, 'asasmen_discipline_edit_spv'])->middleware('auth');
Route::post ('/asasmen/save_discipline_spv', [Tr_AssasmenController::class, 'save_discipline_spv'])->middleware('auth');
Route::get ('/print_discipline_asasmen_spv/{Tr_Emp_Asses_Code}/{test}', [Tr_AssasmenController::class, 'print_discipline_spv'])->middleware('auth');


Route::get ('/asasmen/asasmen_leaderships', [Tr_AssasmenController::class, 'asasmen_leaderships'])->middleware('auth');
//Histori
Route::get ('/print_history/{Tr_Emp_Asses_Code}/{Tr_Emp_Asses_Code2}', [Tr_AssasmenController::class, 'print_history'])->middleware('auth');

// updates a post
Route::post('/asasmen_basics_update', [Tr_AssasmenController::class, 'asasmen_basics_update'])->middleware('auth');

Route::get ('/print_asasmen_spv/{Tr_Emp_Asses_Code}/{test}', [Tr_AssasmenController::class, 'print_basic_spv'])->middleware('auth');
Route::get ('/print_asasmen_hrd/{Tr_Emp_Asses_Code}/{test}', [Tr_AssasmenController::class, 'print_basic_hrd'])->middleware('auth');


//Asasmen basic 1
Route::get ('/asasmen/create_asasmen', [Tr_AssasmenController::class, 'create'])->middleware('auth');
Route::post ('/asasmen/create_asasmen_basic_1', [Tr_AssasmenController::class, 'store_assasment_basic1'])->middleware('auth');
Route::get ('/asasmen/create_asasmen_kedisiplinan', [Tr_AssasmenController::class, 'create_disiplin'])->middleware('auth');
Route::get ('/asasmen/history_basic1', [Tr_AssasmenController::class, 'index_assasment1'])->middleware('auth');

//Asasmen basic 2
Route::get ('/asasmen/create_asasmen_basic_2', [Tr_AssasmenController::class, 'create_asasmen2'])->middleware('auth');
Route::post ('/asasmen/asasmen_basic_detail2', [Tr_AssasmenController::class, 'asasmen_basic_detail2'])->middleware('auth');
Route::post ('/asasmen/detail_employee2', [Tr_AssasmenController::class, 'store_assasment_basic2'])->middleware('auth');

//Asasmen basic3
Route::get ('/asasmen/create_asasmen_basic_3', [Tr_AssasmenController::class, 'create_asasmen3'])->middleware('auth');
Route::get ('/asasmen/detail_employee3/{Tr_Job_Assesment_all_code}', [Tr_AssasmenController::class, 'asasmen_basic_detail3'])->middleware('auth');
Route::post ('/asasmen/detail_employee3/{id}', [Tr_AssasmenController::class, 'store_assasment_basic3'])->middleware('auth');

//Asasmen basic4
Route::get ('/asasmen/create_asasmen_basic_4', [Tr_AssasmenController::class, 'create_asasmen4'])->middleware('auth');
Route::get ('/asasmen/detail_employee4/{Tr_Job_Assesment_all_code}', [Tr_AssasmenController::class, 'asasmen_basic_detail4'])->middleware('auth');
Route::post ('/asasmen/detail_employee4/{id}', [Tr_AssasmenController::class, 'store_assasment_basic4'])->middleware('auth');

// Asasmen Leadership 1
Route::get ('/asasmen/create_asasmen_leadership', [Tr_AssasmenController::class, 'create_leader'])->middleware('auth');
Route::post ('/asasmen/create_asasmen_leadership', [Tr_AssasmenController::class, 'store_leadership_1'])->middleware('auth');

// Asasmen Leadership 2
Route::get ('/asasmen/create_asasmen_leadership_2', [Tr_AssasmenController::class, 'create_leadership2'])->middleware('auth');
Route::post ('/asasmen/asasmen_leadership_detail2', [Tr_AssasmenController::class, 'asasmen_leadership_detail2'])->middleware('auth');
Route::post ('/asasmen/detail_leadership_employee2', [Tr_AssasmenController::class, 'store_assasment_leadership2'])->middleware('auth');

// Asasmen Leadership 3
Route::get ('/asasmen/create_asasmen_leadership_3', [Tr_AssasmenController::class, 'create_leadership3'])->middleware('auth');
Route::get ('/asasmen/detail_leadership_employee3/{Tr_Job_Assesment_all_code}', [Tr_AssasmenController::class, 'asasmen_leadership_detail3'])->middleware('auth');
Route::post ('/asasmen/detail_leadership_employee3/{id}', [Tr_AssasmenController::class, 'store_assasment_leadership3'])->middleware('auth');

// Asasmen Leadership 4
Route::get ('/asasmen/create_asasmen_leadership_4', [Tr_AssasmenController::class, 'create_leadership4'])->middleware('auth');
Route::get ('/asasmen/detail_leadership_employee4/{Tr_Job_Assesment_all_code}', [Tr_AssasmenController::class, 'asasmen_leadership_detail4'])->middleware('auth');
Route::post ('/asasmen/detail_leadership_employee4/{id}', [Tr_AssasmenController::class, 'store_assasment_leadership4'])->middleware('auth');

//Assasment Disiplin 1
Route::get ('/asasmen/create_asasmen_kedisiplinan1', [Tr_AssasmenController::class, 'create_disiplin'])->name('create_disiplin')->middleware('auth');
Route::post ('/asasmen/create_asasmen_kedisiplinan1', [Tr_AssasmenController::class, 'store_disiplin'])->name('store_disiplin')->middleware('auth');

//Assesmen Disiplin 2
Route::get ('/asasmen/create_asasmen_kedisiplinan2', [Tr_AssasmenController::class, 'create_disiplin2'])->middleware('auth');
Route::post ('/asasmen/asasmen_disiplin_detail2', [Tr_AssasmenController::class, 'asasmen_disiplin_detail2'])->middleware('auth');
Route::post ('/asasmen/detail_Kedisiplinan_employee2', [Tr_AssasmenController::class, 'store_assasment_disiplin2'])->middleware('auth');

// Asasmen Disiplin 3
Route::get ('/asasmen/create_asasmen_kedisiplinan_3', [Tr_AssasmenController::class, 'create_kedisiplinan3'])->middleware('auth');
Route::get ('/asasmen/detail_employee_disiplin3/{Tr_Job_Assesment_all_code}', [Tr_AssasmenController::class, 'asasmen_kedisiplinan_detail3'])->middleware('auth');
Route::post ('/asasmen/detail_kedisiplinan_employee3/{id}', [Tr_AssasmenController::class, 'store_assasment_kedisiplinan3'])->middleware('auth');

// Asasmen History
Route::get ('/asasmen/history_main', [Tr_AssasmenController::class, 'view_history'])->middleware('auth');
Route::get ('/asasmen/detail_asasmen_history/{Tr_Job_Assesment_all_code}', [Tr_AssasmenController::class, 'detail_view_history'])->middleware('auth');

Route::get('/sp/form_sp1/{id}', [Tr_Sp_Controller::class, 'index_sp1'])->middleware('auth');
Route::post('/form_sp1', [Tr_Sp_Controller::class, 'store_sp1'])->middleware('auth');

Route::get('/mentoring/{id}', [MentoringController::class, 'mentor'])->middleware('auth');
Route::post('/form_mentor', [MentoringController::class, 'store_mentoring'])->middleware('auth');

Route::get('/putushubungankerja/{id}', [PutusHubunganKerjaController::class, 'putushubungankerja'])->middleware('auth');
Route::post('/form_phk', [PutusHubunganKerjaController::class, 'store_putushubungankerja'])->middleware('auth');

//Kategori BA
Route::get('/kategori_ba', [Kategori_BA_Controller::class, 'index'])->middleware('auth');
Route::post('add-update-kategori', [Kategori_BA_Controller::class, 'store'])->middleware('auth');
Route::post('edit-kategori', [Kategori_BA_Controller::class, 'edit'])->middleware('auth');
Route::post('delete-kategori', [Kategori_BA_Controller::class, 'destroy'])->middleware('auth');

//Kasus BA
Route::get('/kasus_ba', [Kasus_Head_Controller::class, 'index'])->middleware('auth');
Route::post('add-update-kasus', [Kasus_Head_Controller::class, 'store'])->middleware('auth');
Route::post('edit-kasus', [Kasus_Head_Controller::class, 'edit'])->middleware('auth');
Route::post('delete-kasus', [Kasus_Head_Controller::class, 'destroy'])->middleware('auth');

//Detail BA
Route::get('/detail_kasus_ba', [Detail_Kasus_Controller::class, 'index'])->middleware('auth');
Route::post('add-update-detail_kasus_ba', [Detail_Kasus_Controller::class, 'store'])->middleware('auth');
Route::post('edit-detail_kasus_ba', [Detail_Kasus_Controller::class, 'edit'])->middleware('auth');
Route::post('delete-detail_kasus_ba', [Detail_Kasus_Controller::class, 'destroy'])->middleware('auth');

//tambahan asasmen
Route::get ('/tambah_target/{Tr_Emp_Asses_Code}/{Tr_Emp_Asses_Code2}', [Tr_AssasmenController::class, 'tambah_target'])->middleware('auth');
Route::post ('/update_asasmen', [Tr_AssasmenController::class, 'update_basic'])->middleware('auth');

Route::get ('/asasmen/create_asasmen_basic_edit/{Tr_Emp_Asses_Code}', [Tr_AssasmenController::class, 'edit_assassment'])->middleware('auth');
Route::post ('/assassment/update_basic/{Tr_Emp_Asses_Code}', [Tr_AssasmenController::class, 'update_assassment_basic'])->middleware('auth');
Route::get ('/print_history/{Tr_Review_EmpPeriod_Code_h}', [Tr_AssasmenController::class, 'print_history_basic'])->middleware('auth');

Route::post('search_revisit/revisi', [BeritaAcaraController::class, 'search_revisi'])->middleware('auth');
Route::get ('/action_temuan', [BeritaAcaraController::class, 'action_temuan'])->middleware('auth');
Route::post('search_report_ba/temuan', [BeritaAcaraController::class, 'search_temuan'])->middleware('auth');
Route::get('/detail_check_temuan/{Tr_BA_Code}', [BeritaAcaraController::class, 'detail_check_temuan'])->middleware('auth');
// Route::post('/detail_check_temuan/{id}', [BeritaAcaraController::class, 'store_detail_check_temuan'])->middleware('auth');

Route::get ('/berita_acara_all', [BeritaAcaraController::class, 'index_berita_acara_all'])->middleware('auth');
Route::post ('/berita_acara_all', [BeritaAcaraController::class, 'store_berita_acara_all'])->middleware('auth');


Route::get('/master_detail_kasus', [Master_MultiDetailKasus_Controller::class, 'index'])->middleware('auth');
Route::post('add-update-master_detail_kasusa', [Master_MultiDetailKasus_Controller::class, 'store'])->middleware('auth');
Route::post('edit-master_detail_kasus', [Master_MultiDetailKasus_Controller::class, 'edit'])->middleware('auth');
Route::post('delete-master_detail_kasus', [Master_MultiDetailKasus_Controller::class, 'destroy'])->middleware('auth');

Route::get('/priority-note', [BeritaAcaraController::class, 'priority_note']);
Route::post('/add_prioritas_note', [BeritaAcaraController::class, 'add_prioritas_note']);

//Pdf
Route::resource('pdfview', PDFController::class);

Route::get ('indexpdf', [PDFController::class, 'index'])->name('indexpdf');

Route::get('/fun', [App\Http\Controllers\FunController::class, 'document']);

//PICA
Route::get('/create_pica', [Tr_PICA_Controller::class, 'get_form_pika'])->middleware('auth');
Route::post ('/save_pica', [Tr_PICA_Controller::class, 'store_pica'])->middleware('auth');
Route::get('/dashboard_pica', [Tr_PICA_Controller::class, 'get_dashboard_pika'])->middleware('auth');
Route::post('search_report_pica', [Tr_PICA_Controller::class, 'search_pica'])->middleware('auth');
Route::get('/detail_check_pica/{Tr_Pica_Emp_h_Code}', [Tr_PICA_Controller::class, 'detail_check_pica'])->middleware('auth');
Route::post('/detail_check_pica/{id}', [Tr_PICA_Controller::class, 'store_detail_check_temuan'])->middleware('auth');
Route::get('/priority-note', [Tr_PICA_Controller::class, 'priority_note']);
Route::post('/add_prioritas_note', [Tr_PICA_Controller::class, 'add_prioritas_note']);
Route::get('/reprint_pica/{Tr_Pica_Emp_h_Code}', [Tr_PICA_Controller::class, 'reprint_pica'])->middleware('auth');

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified'
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});

// ============================================================
// Master Kategori BA (Fase 2 — admin CRUD)
// ============================================================
Route::middleware('auth')->group(function () {
    Route::prefix('master/kategori')->name('master.kategori.')->group(function () {
        Route::get('/',               [MasterKategoriController::class, 'index'])->name('index');
        Route::get('/create',         [MasterKategoriController::class, 'create'])->name('create');
        Route::post('/',              [MasterKategoriController::class, 'store'])->name('store');
        Route::get('/{id}/edit',      [MasterKategoriController::class, 'edit'])->name('edit');
        Route::put('/{id}',           [MasterKategoriController::class, 'update'])->name('update');
        Route::patch('/{id}/toggle',  [MasterKategoriController::class, 'toggle'])->name('toggle');

        // Konteks mapping per kategori (manage langsung dari edit kategori)
        Route::post('/{id}/konteks',                  [MasterKategoriController::class, 'kategoriBuUpsert'])->name('konteks.upsert');
        Route::delete('/{id}/konteks/{konteks}',      [MasterKategoriController::class, 'kategoriBuDetach'])->name('konteks.detach');

        // Opsi per kategori (nested)
        Route::get('/{kategori}/opsi',                 [MasterKategoriController::class, 'opsiIndex'])->name('opsi.index');
        Route::post('/{kategori}/opsi',                [MasterKategoriController::class, 'opsiStore'])->name('opsi.store');
        Route::put('/{kategori}/opsi/{opsi}',          [MasterKategoriController::class, 'opsiUpdate'])->name('opsi.update');
        Route::patch('/{kategori}/opsi/{opsi}/toggle', [MasterKategoriController::class, 'opsiToggle'])->name('opsi.toggle');
    });

    Route::prefix('master/konteks-mapping')->name('master.mapping.')->group(function () {
        Route::get('/',        [MasterKategoriController::class, 'mappingMatrix'])->name('index');
        Route::post('/update', [MasterKategoriController::class, 'mappingUpdate'])->name('update');
    });

    // Opsi × Konteks matrix (ms_opsi_konteks_mapping)
    Route::prefix('master/opsi-konteks-mapping')->name('master.opsi-mapping.')->group(function () {
        Route::get('/',               [MasterKategoriController::class, 'opsiKonteksMatrix'])->name('index');
        Route::post('/update',        [MasterKategoriController::class, 'opsiKonteksUpdate'])->name('update');
        Route::post('/sync-kategori', [MasterKategoriController::class, 'syncOpsiKategori'])->name('sync-kategori');
        Route::post('/quick-add-opsi',[MasterKategoriController::class, 'quickAddOpsi'])->name('quick-add-opsi');
    });

    // Master Konteks CRUD (ms_konteks)
    Route::prefix('master/konteks')->name('master.konteks.')->group(function () {
        Route::get('/',               [MasterKategoriController::class, 'konteksIndex'])->name('index');
        Route::get('/create',         [MasterKategoriController::class, 'konteksCreate'])->name('create');
        Route::post('/',              [MasterKategoriController::class, 'konteksStore'])->name('store');
        Route::get('/{id}/edit',      [MasterKategoriController::class, 'konteksEdit'])->name('edit');
        Route::put('/{id}',           [MasterKategoriController::class, 'konteksUpdate'])->name('update');
        Route::patch('/{id}/toggle',  [MasterKategoriController::class, 'konteksToggle'])->name('toggle');
    });

    // Master Cek Flag mapping (legacy Tr_Ba_Main_New.Cek* → kategori v2)
    Route::prefix('master/cek-mapping')->name('master.cek-mapping.')->group(function () {
        Route::get('/',                  [MasterCekMappingController::class, 'index'])->name('index');
        Route::put('/{id}',              [MasterCekMappingController::class, 'update'])->name('update');
        Route::patch('/{id}/toggle',     [MasterCekMappingController::class, 'toggle'])->name('toggle');
    });

    // Master Permission System (user level + panel + permission matrix)
    Route::prefix('master/user-level')->name('master.user-level.')->group(function () {
        Route::get('/',              [MasterPermissionController::class, 'levelIndex'])->name('index');
        Route::get('/create',        [MasterPermissionController::class, 'levelCreate'])->name('create');
        Route::post('/',             [MasterPermissionController::class, 'levelStore'])->name('store');
        Route::get('/{id}/edit',     [MasterPermissionController::class, 'levelEdit'])->name('edit');
        Route::put('/{id}',          [MasterPermissionController::class, 'levelUpdate'])->name('update');
        Route::patch('/{id}/toggle', [MasterPermissionController::class, 'levelToggle'])->name('toggle');
    });
    Route::prefix('master/panel')->name('master.panel.')->group(function () {
        Route::get('/',              [MasterPermissionController::class, 'panelIndex'])->name('index');
        Route::get('/create',        [MasterPermissionController::class, 'panelCreate'])->name('create');
        Route::post('/',             [MasterPermissionController::class, 'panelStore'])->name('store');
        Route::get('/{id}/edit',     [MasterPermissionController::class, 'panelEdit'])->name('edit');
        Route::put('/{id}',          [MasterPermissionController::class, 'panelUpdate'])->name('update');
        Route::patch('/{id}/toggle', [MasterPermissionController::class, 'panelToggle'])->name('toggle');
    });
    Route::prefix('master/permission-matrix')->name('master.permission-matrix.')->group(function () {
        Route::get('/',              [MasterPermissionController::class, 'matrix'])->name('index');
        Route::post('/update',       [MasterPermissionController::class, 'matrixUpdate'])->name('update');
    });

    // User Management — assign user-level + toggle active (separate namespace)
    // Phase 2 nanti: migrate UserLevel/Panel/PermissionMatrix CRUD ke namespace ini juga.
    Route::prefix('user-management/users')->name('user-management.users.')->group(function () {
        Route::get('/',                  [\App\Http\Controllers\UserManagement\UserController::class, 'index'])->name('index');
        Route::get('/{id}/edit',         [\App\Http\Controllers\UserManagement\UserController::class, 'edit'])->name('edit');
        Route::put('/{id}',              [\App\Http\Controllers\UserManagement\UserController::class, 'update'])->name('update');
        Route::patch('/{id}/toggle-active', [\App\Http\Controllers\UserManagement\UserController::class, 'toggleActive'])->name('toggle-active');
    });

    // Unified Home V2 — landing page setelah login (gabung KPI BA + PICA)
    Route::get('/home-v2', [\App\Http\Controllers\HomeV2Controller::class, 'index'])->name('home-v2.index');

    // Master Doc Workflow (in-app help/tutorial CRUD)
    Route::prefix('master/doc-workflow')->name('master.doc-workflow.')->group(function () {
        Route::get('/',                  [MasterDocWorkflowController::class, 'index'])->name('index');
        Route::get('/create',            [MasterDocWorkflowController::class, 'create'])->name('create');
        Route::post('/',                 [MasterDocWorkflowController::class, 'store'])->name('store');
        Route::get('/{id}/edit',         [MasterDocWorkflowController::class, 'edit'])->name('edit');
        Route::put('/{id}',              [MasterDocWorkflowController::class, 'update'])->name('update');
        Route::patch('/{id}/toggle',     [MasterDocWorkflowController::class, 'toggle'])->name('toggle');
        Route::delete('/{id}',           [MasterDocWorkflowController::class, 'destroy'])->name('destroy');
    });

    // Public Help Center (viewer)
    Route::prefix('help')->name('help.')->group(function () {
        Route::get('/',          [HelpController::class, 'index'])->name('index');
        Route::get('/{kode}',    [HelpController::class, 'show'])->name('show');
    });

    // ============================================================
    // Master PICA v2 (kategori + pertanyaan)
    // ============================================================
    Route::prefix('master/pica')->name('master.pica.')->group(function () {
        // Kategori PICA
        Route::prefix('kategori')->name('kategori.')->group(function () {
            Route::get('/',              [MasterPicaController::class, 'kategoriIndex'])->name('index');
            Route::get('/create',        [MasterPicaController::class, 'kategoriCreate'])->name('create');
            Route::post('/',             [MasterPicaController::class, 'kategoriStore'])->name('store');
            Route::get('/{id}/edit',     [MasterPicaController::class, 'kategoriEdit'])->name('edit');
            Route::put('/{id}',          [MasterPicaController::class, 'kategoriUpdate'])->name('update');
            Route::patch('/{id}/toggle', [MasterPicaController::class, 'kategoriToggle'])->name('toggle');
        });
        // Pertanyaan master
        Route::prefix('pertanyaan')->name('pertanyaan.')->group(function () {
            Route::get('/',              [MasterPicaController::class, 'pertanyaanIndex'])->name('index');
            Route::get('/create',        [MasterPicaController::class, 'pertanyaanCreate'])->name('create');
            Route::post('/',             [MasterPicaController::class, 'pertanyaanStore'])->name('store');
            Route::get('/{id}/edit',     [MasterPicaController::class, 'pertanyaanEdit'])->name('edit');
            Route::put('/{id}',          [MasterPicaController::class, 'pertanyaanUpdate'])->name('update');
            Route::patch('/{id}/toggle', [MasterPicaController::class, 'pertanyaanToggle'])->name('toggle');
        });
    });

    // ============================================================
    // Berita Acara v2 — Wizard (Fase 3)
    // ============================================================
    Route::prefix('beritaacara/v2')->name('berita-acara-v2.')->group(function () {
        Route::get('/dashboard', [BeritaAcaraV2Controller::class, 'dashboard'])->name('dashboard');
        Route::get('/list',      [BeritaAcaraV2Controller::class, 'list'])->name('list');
        Route::get('/show',      [BeritaAcaraV2Controller::class, 'show'])->name('show');
        Route::get('/{kode}/print', [BeritaAcaraV2Controller::class, 'print'])->name('print');
        Route::post('/{kode}/share-wa',   [BeritaAcaraV2Controller::class, 'shareToWa'])->name('share-wa');
        Route::post('/{kode}/prepare-pdf', [BeritaAcaraV2Controller::class, 'preparePdf'])->name('prepare-pdf');
        Route::get('/create',    [BeritaAcaraV2Controller::class, 'create'])->name('create');
        Route::post('/store',    [BeritaAcaraV2Controller::class, 'store'])->name('store');
        // Edit (admin OR creator+edit_allowed)
        Route::get('/edit',                       [BeritaAcaraV2Controller::class, 'edit'])->name('edit');
        Route::post('/{kode}/update',             [BeritaAcaraV2Controller::class, 'update'])->name('update');
        Route::post('/{kode}/toggle-edit-allowed',[BeritaAcaraV2Controller::class, 'toggleEditAllowed'])->name('toggle-edit');
    });

    // ============================================================
    // PICA v2 — Wizard (Fase 2) + Discussion (Fase 3)
    // ============================================================
    Route::prefix('pica/v2')->name('pica-v2.')->group(function () {
        // Dashboard + List (Fase 5)
        Route::get('/dashboard',      [PicaV2Controller::class, 'dashboard'])->name('dashboard');
        Route::get('/dashboard-data', [PicaV2Controller::class, 'dashboardData'])->name('dashboard.data');
        Route::get('/list',           [PicaV2Controller::class, 'list'])->name('list');
        Route::get('/{kode}/print',   [PicaV2Controller::class, 'print'])->name('print');

        Route::get('/create',         [PicaV2Controller::class, 'create'])->name('create');
        Route::post('/store',         [PicaV2Controller::class, 'store'])->name('store');
        Route::get('/search-ba',      [PicaV2Controller::class, 'searchBa'])->name('search-ba');
        Route::get('/search-users',   [PicaV2Controller::class, 'searchUsers'])->name('search-users');

        // Discussion (Fase 3)
        Route::get('/discussion',                                  [PicaV2Controller::class, 'discussion'])->name('discussion');
        Route::post('/{kode}/pertanyaan',                          [PicaV2Controller::class, 'addPertanyaan'])->name('pertanyaan.add');
        Route::delete('/{kode}/pertanyaan/{id}',                   [PicaV2Controller::class, 'deletePertanyaan'])->name('pertanyaan.delete');
        Route::post('/{kode}/pertanyaan/{id}/jawaban',             [PicaV2Controller::class, 'addJawaban'])->name('jawaban.add');
        Route::patch('/{kode}/jawaban/{id}/final',                 [PicaV2Controller::class, 'setFinal'])->name('jawaban.final');
        Route::post('/{kode}/phase',                               [PicaV2Controller::class, 'togglePhase'])->name('phase.toggle');

        // Meeting documentation (PICA v3 — split PREPARING/MEETING)
        Route::post('/{kode}/agenda',                              [PicaV2Controller::class, 'saveAgenda'])->name('agenda.save');
        Route::post('/{kode}/hasil-meeting',                       [PicaV2Controller::class, 'saveHasilMeeting'])->name('hasil.save');
        Route::post('/{kode}/catatan-pelaku',                      [PicaV2Controller::class, 'saveCatatanPelaku'])->name('catatan.save');
        Route::post('/{kode}/pernyataan',                          [PicaV2Controller::class, 'savePernyataanPelaku'])->name('pernyataan.save');
        Route::post('/{kode}/pernyataan/sign',                     [PicaV2Controller::class, 'signPernyataan'])->name('pernyataan.sign');
        Route::post('/{kode}/pernyataan/unsign',                   [PicaV2Controller::class, 'unsignPernyataan'])->name('pernyataan.unsign');

        // Report (Fase 4 — structured compile sections A-G)
        Route::get('/report',                                      [PicaV2Controller::class, 'report'])->name('report');
        Route::post('/{kode}/report',                              [PicaV2Controller::class, 'saveReport'])->name('report.save');
        Route::post('/{kode}/report/whys',                         [PicaV2Controller::class, 'saveWhys'])->name('report.whys');
        Route::post('/{kode}/report/actions',                      [PicaV2Controller::class, 'saveActions'])->name('report.actions');
        Route::post('/{kode}/report/done',                         [PicaV2Controller::class, 'setDone'])->name('report.done');
        Route::post('/{kode}/report/close',                        [PicaV2Controller::class, 'closePica'])->name('report.close'); // alias
    });

    // AJAX endpoint untuk wizard
    Route::prefix('api')->group(function () {
        Route::get('/konteks/{kode}/kategori', [BeritaAcaraV2Controller::class, 'kategoriByBu']);
        Route::get('/bu/{kode}/kategori',      [BeritaAcaraV2Controller::class, 'kategoriByBu']); // deprecated alias
        Route::get('/kategori/{id}/opsi',      [BeritaAcaraV2Controller::class, 'opsiByKategori']);
        Route::get('/employees/search',        [BeritaAcaraV2Controller::class, 'searchEmployees']);
        Route::get('/opsi/search',             [BeritaAcaraV2Controller::class, 'searchOpsi']);
        Route::get('/kasus/search',            [BeritaAcaraV2Controller::class, 'searchKasus']);
    });

    // Opsi global (lintas kategori — list & create + detail/edit + attach/detach)
    Route::prefix('master/opsi')->name('master.opsi.')->group(function () {
        Route::get('/',  [MasterKategoriController::class, 'opsiGlobalIndex'])->name('index');
        Route::post('/', [MasterKategoriController::class, 'opsiGlobalStore'])->name('store');

        Route::get('/{id}/edit',  [MasterKategoriController::class, 'opsiEdit'])->name('edit');
        Route::put('/{id}',       [MasterKategoriController::class, 'opsiGlobalUpdate'])->name('update');
        Route::post('/{id}/attach', [MasterKategoriController::class, 'opsiAttach'])->name('attach');
        Route::delete('/{id}/detach/{kategori}', [MasterKategoriController::class, 'opsiDetach'])->name('detach');
        Route::put('/{id}/mapping/{kategori}',   [MasterKategoriController::class, 'opsiMappingUpdate'])->name('mapping.update');

        // Tag Konteks langsung ke opsi
        Route::post('/{id}/konteks',                [MasterKategoriController::class, 'opsiAttachBu'])->name('konteks.attach');
        Route::delete('/{id}/konteks/{konteks}',    [MasterKategoriController::class, 'opsiDetachBu'])->name('konteks.detach');
    });
});
