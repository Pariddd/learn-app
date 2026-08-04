<?php

use CodeIgniter\Router\RouteCollection;

/** @var RouteCollection $routes */
// $routes->get('/', 'Home::index');
$routes->get('/', 'Auth::showLogin');
$routes->get('/register', 'Auth::showRegister');
$routes->post('/register', 'Auth::register');
$routes->get('/login', 'Auth::showLogin');
$routes->post('/login', 'Auth::login');
$routes->get('/logout', 'Auth::logout');


$routes->group('', ['filter' => 'auth'], function ($routes) {
  $routes->get('dashboard', 'Dashboard::index');

  $routes->get('basic-course', 'BasicCourse::index');

  $routes->get('video/(:num)', 'Video::player/$1');
  $routes->post('video/update-progress', 'Video::updateProgress');

  $routes->get('quiz-role', 'QuizRole::index');
  $routes->post('quiz-role/submit', 'QuizRole::submit');
  $routes->get('quiz-role/mulai/(:num)', 'QuizRole::mulaiRole/$1');

  $routes->get('role/jelajahi', 'Role::jelajahi');
  $routes->get('role/roadmap/(:num)', 'Role::roadmap/$1');

  $routes->get('all-class', 'AllClass::index');

  $routes->get('learning-paths', 'LearningPaths::index');
  $routes->get('learning-paths/hapus/(:num)', 'LearningPaths::hapus/$1');

  $routes->get('riwayat-quiz', 'RiwayatQuiz::index');

  $routes->get('profil', 'Profil::index');
  $routes->post('profil/update', 'Profil::update');
});

$routes->group('admin', ['filter' => 'admin', 'namespace' => 'App\Controllers\Admin'], function ($routes) {
  $routes->get('dashboard', 'DashboardController::index');

  $routes->get('role', 'RoleController::index');
  $routes->get('role/create', 'RoleController::create');
  $routes->post('role/store', 'RoleController::store');
  $routes->get('role/edit/(:num)', 'RoleController::edit/$1');
  $routes->post('role/update/(:num)', 'RoleController::update/$1');
  $routes->get('role/delete/(:num)', 'RoleController::delete/$1');
  $routes->get('roles/select/(:num)', 'QuizRole::mulaiRole/$1');
  $routes->get('role/select/(:num)', 'QuizRole::mulaiRole/$1');

  $routes->get('kategori', 'KategoriController::index');
  $routes->post('kategori/store', 'KategoriController::store');
  $routes->post('kategori/update/(:num)', 'KategoriController::update/$1');
  $routes->get('kategori/delete/(:num)', 'KategoriController::delete/$1');

  $routes->get('video', 'VideoController::index');
  $routes->get('video/create', 'VideoController::create');
  $routes->post('video/store', 'VideoController::store');
  $routes->get('video/show/(:num)', 'VideoController::show/$1');
  $routes->get('video/edit/(:num)', 'VideoController::edit/$1');
  $routes->post('video/update/(:num)', 'VideoController::update/$1');
  $routes->get('video/delete/(:num)', 'VideoController::delete/$1');

  $routes->get('quiz', 'QuizController::index');
  $routes->post('quiz/store', 'QuizController::store');
  $routes->post('quiz/update/(:num)', 'QuizController::update/$1');
  $routes->get('quiz/delete/(:num)', 'QuizController::delete/$1');

  $routes->get('bobot', 'BobotController::index');
  $routes->post('bobot/store', 'BobotController::store');
  $routes->post('bobot/update/(:num)', 'BobotController::update/$1');
  $routes->get('bobot/delete/(:num)', 'BobotController::delete/$1');

  $routes->get('link', 'LinkController::index');
  $routes->post('link/store', 'LinkController::store');
  $routes->post('link/update/(:num)', 'LinkController::update/$1');
  $routes->get('link/delete/(:num)', 'LinkController::delete/$1');
});
