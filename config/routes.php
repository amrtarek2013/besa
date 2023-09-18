<?php

use Cake\ORM\TableRegistry;
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

        $builder->connect('/pages/points', ['controller' => 'Pages', 'action' => 'points']);
        $builder->connect('/courses', 'UniversityCourses::results');

        // $builder->connect('/logout', ['controller' => 'Users', 'action' => 'logout', 'user' => true, 'prefix' => 'User']);
        // $builder->connect('/login', ['controller' => 'Users', 'action' => 'login', 'user' => true, 'prefix' => 'User']);
        // $builder->connect('/register', ['controller' => 'Users', 'action' => 'register', 'user' => true, 'prefix' => 'User']);
        $builder->connect('/apply', ['controller' => 'Users', 'action' => 'register', 'user' => true, 'prefix' => 'User']);

        $DynamicRoutes = TableRegistry::getTableLocator()->get('DynamicRoutes');

        $dynamicRoutes = $DynamicRoutes->find()->where(['is_active' => 1,])->cache('dynamic_routes_route')->all();

        foreach ($dynamicRoutes as $routePage) {
            if ($routePage['has_params'])
                $routePage['slug'] = $routePage['slug'] . '/*';

            $redirectTo = ['controller' => $routePage['controller'], 'action' => $routePage['action']];
            if(!empty($routePage['prefix'])){
                $redirectTo['prefix'] = ucwords($routePage['prefix']);
                
                $redirectTo[$routePage['prefix']] = true;
            }
            $builder->connect('/' . $routePage['slug'], $redirectTo);
        }
        /*
         * ...and connect the rest of 'Pages' controller's URLs.
         */
        $builder->connect('/content/*', ['controller' => 'Pages', 'action' => 'view']);


        $builder->connect('/services', 'Services::index');
        $builder->connect('/service-details/*', 'Services::details');
        $builder->connect('/events', 'Events::index');
        $builder->connect('/school-tour', 'Events::schoolTour');
        $builder->connect('/education-fairs', 'Events::eventDetails');
        $builder->connect('/event-details/*', 'Events::eventDetails');
        $builder->connect('/blog-details/*', 'Blogs::details');
        $builder->connect('/destinations/*', 'Countries::index');
        $builder->connect('/country-details/*', 'Countries::details');
        $builder->connect('/university-details/*', 'Universities::details');
        $builder->connect('/universities/*', 'Universities::index');

        $builder->connect('/contact-us', 'Enquiries::contactUs');
        $builder->connect('/visitors-application', 'Enquiries::visitorsApplication');
        $builder->connect('/educational-institution', 'Enquiries::educationalInstitution');
        $builder->connect('/british-trophy-subscription', 'Enquiries::britishTrophySubscription');
        $builder->connect('/book-appointment', 'Enquiries::bookAppointment');
        $builder->connect('/about-us', 'Pages::aboutUs');

        $builder->connect('/partnership-with-besa', 'Pages::partnershipWithBesa');

        $builder->connect('/partner-institutions', 'Pages::partnerInstitutions');
        $builder->connect('/app-support', 'Pages::appSupport');
        $builder->connect('/career-apply', 'Pages::careerApply');
        $builder->connect('/career-apply/*', 'Pages::careerApply');
        $builder->connect('/where-to-study', 'Pages::whereToStudy');

        $builder->connect('/service-details', 'Services::serviceDetails');
        $builder->connect('/b2b-services', 'Services::b2bServices');
        $builder->connect('/event-details', 'Events::eventDetails');

        $builder->connect('/study', 'UniversityCourses::study');
        $builder->connect('/results', 'UniversityCourses::results');
        $builder->connect('/course-details/*', 'UniversityCourses::details');
        $builder->connect('/courses/*', 'UniversityCourses::index');

        $builder->connect('/pages/*', 'Pages::display');
        $builder->connect('/pages/*', 'Pages::display');
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
        $routes->connect('/dashboard', ['controller' => 'Users', 'action' => 'dashboard']);
        $routes->connect('/profile', ['controller' => 'Users', 'action' => 'profile']);
        $routes->connect('/login', ['controller' => 'Users', 'action' => 'login']);
        $routes->connect('/logout', ['controller' => 'Users', 'action' => 'logout']);
        $routes->connect('/apply', ['controller' => 'Users', 'action' => 'register']);
        $routes->connect('/register', ['controller' => 'Users', 'action' => 'register']);
        $routes->connect('/forgot-password', ['controller' => 'Users', 'action' => 'forgotPassword']);
        // $routes->connect('/forgotPassword', ['controller' => 'Users', 'action' => 'forgotPassword']);
        $routes->connect('/forgot-password-success', ['controller' => 'Users', 'action' => 'forgotPasswordSuccess']);
        $routes->connect('/reset-password/*', ['controller' => 'Users', 'action' => 'resetPassword']);
        $routes->fallbacks(DashedRoute::class);
    });
    Router::prefix('counselor', function (RouteBuilder $routes) {
        $routes->connect('/locale/*', ['controller' => 'Localizations', 'action' => 'setLocale']);
        $routes->connect('/', ['controller' => 'Counselors', 'action' => 'index']);
        $routes->connect('/dashboard', ['controller' => 'Applications', 'action' => 'index']);
        $routes->connect('/users', ['controller' => 'Users', 'action' => 'index']);
        $routes->connect('/profile', ['controller' => 'Counselors', 'action' => 'profile']);
        $routes->connect('/points', ['controller' => 'Counselors', 'action' => 'points']);
        $routes->connect('/security', ['controller' => 'Counselors', 'action' => 'security']);
        $routes->connect('/login', ['controller' => 'Counselors', 'action' => 'login']);
        $routes->connect('/logout', ['controller' => 'Counselors', 'action' => 'logout']);
        $routes->connect('/register', ['controller' => 'Counselors', 'action' => 'register']);
        $routes->connect('/forgot-password', ['controller' => 'Counselors', 'action' => 'forgotPassword']);
        $routes->connect('/forgot-password-success', ['controller' => 'Counselors', 'action' => 'forgotPasswordSuccess']);
        $routes->connect('/reset-password/*', ['controller' => 'Counselors', 'action' => 'resetPassword']);
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
