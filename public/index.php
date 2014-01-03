<?php

error_reporting(E_ALL);
define('APPPATH', '../app/');
try {

    $config = new \Phalcon\Config\Adapter\Ini("../app/config/config.ini");
    //Register an autoloader
    $loader = new \Phalcon\Loader();
    $loader->registerDirs(
        array(
            '../app/controllers/',
            '../app/models/',
            '../app/libraries/'
        )
    )->register();

    //Create a DI
    $di = new Phalcon\DI\FactoryDefault();

    $di->set('config',function() use($config){
        return $config;
    });
    
    //Setting up the view component
    $di->set('view', function(){
        $view = new \Phalcon\Mvc\View();
        $view->setViewsDir('../app/views/');
        return $view;
    });

   $di->set('url', function() use ($config){
        $url = new \Phalcon\Mvc\Url();
        $url->setBaseUri($config->application->baseUri);
        return $url;
   });

  /**
   * Register the flash service with custom CSS classes
   */
   $di->set('flash', function(){
       return new Phalcon\Flash\Direct(array(
         'error' => 'alert alert-error',
         'success' => 'alert alert-success',
         'notice' => 'alert alert-info',
       ));
   });

  $di->setShared('dispatcher', function() {
     $eventsManager = new Phalcon\Events\Manager();
     //Attach a listener
     $eventsManager->attach("dispatch", function($event, $dispatcher, $exception) {
        //The controller exists but the action not
        if ($event->getType() == 'beforeNotFoundAction') {
            $dispatcher->forward(array(
                'controller' => 'maindex',
                'action' => 'show404'
            ));
            return false;
        }
        //Alternative way, controller or action doesn't exist
        if ($event->getType() == 'beforeException') {
            switch ($exception->getCode()) {
                case Phalcon\Dispatcher::EXCEPTION_HANDLER_NOT_FOUND:
                case Phalcon\Dispatcher::EXCEPTION_ACTION_NOT_FOUND:
                    $dispatcher->forward(array(
                        'controller' => 'maindex',
                        'action' => 'show404'
                    ));
                    return false;
            }
        }
     });
     $dispatcher = new Phalcon\Mvc\Dispatcher();
     //Bind the EventsManager to the dispatcher
     $dispatcher->setEventsManager($eventsManager);
     return $dispatcher;
   });

   $di->set('router',function(){
      $router = new Phalcon\Mvc\Router();
      $router->setDefaultController("maindex");
      $router->add("/vols/{coverpid:[0-9]+}/{pagenum:[0-9]+}/?","vols::index");
      $router->add("/vols/{coverpid:[0-9]+}/{pagenum:[0-9]+}/{isFullScreen:[0-9]}/?","vols::index");
      $router->add("/lists/{cid:[0-9]+}/?","lists::index");
      $router->add("/lists/{cid:[0-9]+}/{order:[a-z]+}/?","lists::index");
      $router->add("/lists/{cid:[0-9]+}/{order:[a-z]+}/{nowpage:[0-9]+}/?","lists::index");
      $router->add("/comic/{comicid:[0-9]+}/?","comic::index");
      $router->add("/comic/{comicid:[0-9]+}/{voltype:[0-9]}/?","comic::index");
      $router->add("/comic/{comicid:[0-9]+}/{voltype:[0-9]}/{nowpage:[0-9]+}/?","comic::index");
      $router->add("/comic/{comicid:[0-9]+}/{voltype:[0-9]}/{order:[0a-z]+}/{nowpage:[0-9]+}/?","comic::index");
      $router->add("/resetcomiccache/{comicid:[0-9]+}/?","comic::resetcomiccache");
      $router->add("/weeklylists/{wkday:[0-9]}/?","maindex::weeklylists");
      $router->add("/weeklylists/{wkday:[0-9]}/{nowpage:[0-9]+}/?","maindex::weeklylists");
      $router->add("/weeklylists[/]?","maindex::weeklylists");
      $router->add("/rank[/]?","maindex::rank");
      $router->add("/hotcomic/{nowpage:[0-9]+}/?","maindex::hotcomic");
      $router->add("/randomcomic/{nowpage:[0-9]+}/?","maindex::randomcomic");
      $router->add("/comicstaglist/{tagname:.+}/?","comic::comicstaglist");
      $router->add("/comicstaglist/{tagname:.+}/{nowpage:[0-9]+}/?","comic::comicstaglist");
      $router->add("/fav/{nowpage:[0-9]+}/?","fav::index");
      $router->add("/fav/addCollection/{cid:[0-9]+}/?","fav::addCollection");
      $router->add("/bookmark/{nowpage:[0-9]+}/?","bookmark::index");
      $router->add("/history/{nowpage:[0-9]+}/?","history::index");
      return $router;
   });

    //Handle the request
   $application = new \Phalcon\Mvc\Application();
   $application->setDI($di);
   echo $application->handle()->getContent();

} catch(\Phalcon\Exception $e) {
  echo "PhalconException: ", $e->getMessage();
} catch (PDOException $e){
  echo $e->getMessage();
}
