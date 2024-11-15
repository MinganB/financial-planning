<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use CodeIgniter\HTTP\CLIRequest;
use CodeIgniter\HTTP\IncomingRequest;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;

/**
 * Class BaseController
 *
 * BaseController provides a convenient place for loading components
 * and performing functions that are needed by all your controllers.
 * Extend this class in any new controllers:
 *     class Home extends BaseController
 *
 * For security be sure to declare any new methods as protected or private.
 */
abstract class BaseController extends Controller
{
    /**
     * Instance of the main Request object.
     *
     * @var CLIRequest|IncomingRequest
     */
    protected $request;

    /**
     * An array of helpers to be loaded automatically upon
     * class instantiation. These helpers will be available
     * to all other controllers that extend BaseController.
     *
     * @var list<string>
     */
    protected $helpers = [];

    /**
     * Be sure to declare properties for any property fetch you initialized.
     * The creation of dynamic property is deprecated in PHP 8.2.
     */
    // protected $session;

    /**
     * @return void
     */
    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        // Do Not Edit This Line
        parent::initController($request, $response, $logger);

        // Preload any models, libraries, etc, here.

        // E.g.: $this->session = \Config\Services::session();
    }

    /**
     * Wraps a given view with the header and footer templates for the app.
     *
     * @return view The View to render.
     */
    public function getPreparedView($view, $showNavbar = true, $showFooter = true)
    {
        $header = view('templates/header');
        $footer = view('templates/footer');
        $noFooter = view('templates/no-footer');

        if ($showNavbar)
            $header .=  view('templates/navbar');
        else
            $header .=  view('templates/no-navbar');
        $view = $header . $view;

        if ($showFooter)
            $view .= $footer;
        else
            $view .= $noFooter;

        return $view;
    }

    public function getPreparedFrontendView($view)
    {
        $header = view('frontend/header');
        $footer = view('templates/footer');

        $view = $header . $view . $footer;

        return $view;
    }
}
