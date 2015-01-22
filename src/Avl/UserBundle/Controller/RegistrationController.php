<?php
/**
 * Created by PhpStorm.
 * User: avanloock
 * Date: 10.01.15
 * Time: 21:52
 */
namespace Avl\UserBundle\Controller;

use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;

use FOS\UserBundle\Controller\RegistrationController as BaseRegistrationController;

/**
 * Class RegistrationController
 * @package Avl\UserBundle\Controller
 */
class RegistrationController extends BaseRegistrationController
{
    /**
     * @var null
     */
    private $session = null;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->session = new Session();
    }

    /**
     * Overriding register to add custom logic.
     *
     * @param Request $request
     * @return null|RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function registerAction(Request $request)
    {
        /**
         * Check if user is loggin. If yes they cannot
         * register accounts....
         */
        if ($this->container->get('security.context')->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
            $this->session->getFlashBag()->add('notice', 'Please logout before register.');
            return new RedirectResponse(
                $this->container->get('router')->generate('fos_ext_avl_user_dashboard_show',
                array())
            );
        }

        return parent::registerAction($request);
    }
}