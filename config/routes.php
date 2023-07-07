<?php

use Cake\Routing\Route\DashedRoute;
use Cake\Routing\RouteBuilder;
use Cake\Routing\Router;


return static function (RouteBuilder $routes) {
    /*
     * The default class to use for all routes
     *
     * The following route classes are supplied with CakePHP and are appropriate
     * to set as the default:
     *
     * - Route
     * - InflectedRoute
     * - DashedRoute
     *
     * If no call is made to `Router::defaultRouteClass()`, the class used is
     * `Route` (`Cake\Routing\Route\Route`)
     *
     * Note that `Route` does not do any inflections on URLs which will result in
     * inconsistently cased URLs when used with `{plugin}`, `{controller}` and
     * `{action}` markers.
     */
    $routes->setRouteClass(DashedRoute::class);

    $routes->scope('/', function (RouteBuilder $builder) {
        $builder->connect('/locale/*', ['controller' => 'Localizations', 'action' => 'setLocale']);
        /*
         * Here, we are connecting '/' (base path) to a controller called 'Pages',
         * its action called 'display', and we pass a param to select the view file
         * to use (in this case, templates/Pages/home.php)...
         */
        $builder->connect('/', ['controller' => 'Pages', 'action' => 'main']);
        // $builder->connect('/', ['controller' => 'Pages', 'action' => 'display', 'home']);

        /*
         * ...and connect the rest of 'Pages' controller's URLs.
         */
        $builder->connect('/about', ['controller' => 'Pages', 'action' => 'view']);
        $builder->connect('/content/*', ['controller' => 'Pages', 'action' => 'view']);
        

        $builder->connect('/services', 'Services::index');
        $builder->connect('/service-details/*', 'Services::details');
        $builder->connect('/events', 'Events::index');
        $builder->connect('/event-details/*', 'Events::eventDetails');
        $builder->connect('/destinations/*', 'Countries::index');
        $builder->connect('/country-details/*', 'Countries::details');
        $builder->connect('/university-details/*', 'Universities::details');

        $builder->connect('/contact-us', 'Enquiries::contactUs');
        $builder->connect('/about-us', 'Pages::aboutUs');
        $builder->connect('/pathway-programs', 'Pages::pathwayPrograms');
        $builder->connect('/pathway-placement', 'Pages::pathwayPlacement');
        $builder->connect('/university-placement', 'Pages::universityPlacement');
        $builder->connect('/young-learners', 'Pages::youngLearners');
        $builder->connect('/partnership-with-besa', 'Pages::partnershipWithBesa');
        
        $builder->connect('/partner-institutions', 'Pages::partnerInstitutions');
        $builder->connect('/app-support', 'Pages::appSupport');
        $builder->connect('/pages/*', 'Pages::display');
        // $builder->connect('/register', 'Users::register');
        // $builder->connect('/login', 'Users::login');

        $builder->connect('/where-to-study', 'Pages::whereToStudy');

        $builder->connect('/service-details', 'Services::serviceDetails');
        $builder->connect('/b2b-services', 'Services::b2bServices');
        $builder->connect('/event-details', 'Events::eventDetails');

        $builder->connect('/study', 'UniversityCourses::study');
        $builder->connect('/results', 'UniversityCourses::results');
        $builder->connect('/course-details/*', 'UniversityCourses::details');
        $builder->connect('/courses', 'UniversityCourses::index');


        // $builder->connect('/user', ['controller' => 'Users', 'action' => 'profile', 'user' => true, 'prefix' => 'user']);
        // $builder->connect('/logout', ['controller' => 'Users', 'action' => 'logout', 'user' => true, 'prefix' => 'user']);
        // $builder->connect('/login', ['controller' => 'Users', 'action' => 'login', 'user' => true, 'prefix' => 'user']);
        // $builder->connect('/register', ['controller' => 'Users', 'action' => 'register', 'user' => true, 'prefix' => 'user']);
        
        // $builder->connect('/user/profile', ['controller' => 'Users', 'action' => 'profile', 'user' => true, 'prefix' => 'user']);
        /*
         * Connect catchall routes for all controllers.
         *
         * The `fallbacks` method is a shortcut for
         *
         * ```
         * $builder->connect('/{controller}', ['action' => 'index']);
         * $builder->connect('/{controller}/{action}/*', []);
         * ```
         *
         * You can remove these routes once you've connected the
         * routes you want in your application.
         */
        $builder->fallbacks();
    });

    // Admin scope
    Router::prefix('Admin', function (RouteBuilder $routes) {
        $routes->connect('/locale/*', ['controller' => 'Localizations', 'action' => 'setLocale']);
        $routes->connect('/', ['controller' => 'Enquiries', 'action' => 'index']);
        $routes->connect('/login', ['controller' => 'Admins', 'action' => 'login']);
   
        $routes->fallbacks(DashedRoute::class);
    });
    // Admin scope
    Router::prefix('user', function (RouteBuilder $routes) {
        $routes->connect('/locale/*', ['controller' => 'Localizations', 'action' => 'setLocale']);
        $routes->connect('/', ['controller' => 'Users', 'action' => 'dashboard']);
        // $routes->connect('/', ['controller' => 'Users', 'action' => 'profile']);
        $routes->connect('/profile', ['controller' => 'Users', 'action' => 'profile']);
        $routes->connect('/login', ['controller' => 'Users', 'action' => 'login']);
        $routes->connect('/logout', ['controller' => 'Users', 'action' => 'logout']);
        $routes->connect('/register', ['controller' => 'Users', 'action' => 'register']);
        $routes->connect('/forgot-password', ['controller' => 'Users', 'action' => 'forgotPassword']);
        // $routes->connect('/forgotPassword', ['controller' => 'Users', 'action' => 'forgotPassword']);
        $routes->connect('/forgot-password-success', ['controller' => 'Users', 'action' => 'forgotPasswordSuccess']);
        $routes->connect('/reset-password/*', ['controller' => 'Users', 'action' => 'resetPassword']);
        $routes->fallbacks(DashedRoute::class);
    });
    Router::prefix('councillor', function (RouteBuilder $routes) {
        $routes->connect('/locale/*', ['controller' => 'Localizations', 'action' => 'setLocale']);
        $routes->connect('/', ['controller' => 'Councillors', 'action' => 'dashboard']);
        // $routes->connect('/', ['controller' => 'Councillors', 'action' => 'profile']);
        $routes->connect('/profile', ['controller' => 'Councillors', 'action' => 'profile']);
        $routes->connect('/login', ['controller' => 'Councillors', 'action' => 'login']);
        $routes->connect('/logout', ['controller' => 'Councillors', 'action' => 'logout']);
        $routes->connect('/register', ['controller' => 'Councillors', 'action' => 'register']);
        $routes->connect('/forgot-password', ['controller' => 'Councillors', 'action' => 'forgotPassword']);
        // $routes->connect('/forgotPassword', ['controller' => 'Councillors', 'action' => 'forgotPassword']);
        $routes->connect('/forgot-password-success', ['controller' => 'Councillors', 'action' => 'forgotPasswordSuccess']);
        $routes->connect('/reset-password/*', ['controller' => 'Councillors', 'action' => 'resetPassword']);
        $routes->fallbacks(DashedRoute::class);
    });

    /*
     * If you need a different set of middleware or none at all,
     * open new scope and define routes there.
     *
     * ```
     * $routes->scope('/api', function (RouteBuilder $builder) {
     *     // No $builder->applyMiddleware() here.
     *
     *     // Parse specified extensions from URLs
     *     // $builder->setExtensions(['json', 'xml']);
     *
     *     // Connect API actions here.
     * });
     * ```
     */
};
