<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');


// API routes
$routes->group("api", ["namespace" => "App\Controllers\Api"], function ($routes) {

  $routes->post('add-student', 'ApiController::addStudent');
  $routes->get('list-students', 'ApiController::listStudent');
  $routes->get("single-studnet/(:num)", 'ApiController::singleStudent/$1');
  $routes->put("update-student/(:num)", 'ApiController::updateStudent/$1');
  $routes->delete("delete-student/(:num)", 'ApiController::deleteStudent/$1');

})
