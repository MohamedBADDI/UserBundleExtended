<?php
/**
 * Created by PhpStorm.
 * User: avanloock
 * Date: 10.01.15
 * Time: 21:52
 */
namespace Avl\UserBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Session\Session;

use FOS\UserBundle\Controller\ProfileController as BaseProfileController;

/**
 * Class ProfileController
 * @package Avl\UserBundle\Controller
 */
class ProfileController extends BaseProfileController
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
     * Overriding profile edit to add custom logic
     * ot custom variables to the form...
     *
     * @param Request $request
     * @return null|\Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function editAction(Request $request)
    {
        // Get and create the FOSUserbundleForm
        $formFactory = $this->get('fos_user.profile.form.factory');
        $form = $formFactory->createForm();
        // Add Data and the request to the form
        $form->setData($this->getUser());
        $form->handleRequest($request);

        // If method was POST and is valid,
        // then we save and redirect the
        // output.
        if ($request->getMethod() == 'POST' && $form->isValid()) {
            return parent::editAction($request);
        } else {
            // Get and create the FOSUserbundleForm
            // Render my view with additional data
            return $this->render('UserBundle:Profile:edit.html.twig',
                array(
                    'form' => $form->createView(),
                    //'variable' => 'test',
                )
            );
        }
    }

    /**
     * Delete profile-picture
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function deletePictureAction(Request $request) {

        /**
         * Method DELETE?
         */
        if ($request->getMethod() == 'DELETE') {

            // Can i delete the picture?
            if ($this->getUser()->removeProfilePictureFile()) {

                // Update user profile
                $this->get('fos_user.user_manager')->updateUser(
                    $this->getUser()
                );

                $this->session->getFlashBag()->add('notice', 'Picture was deleted.');
            } else {
                $this->session->getFlashBag()->add('notice', 'Cannot delete picture.');
            }
        }

        return new RedirectResponse(
            $this->container->get('router')->generate('fos_user_profile_edit',
                array())
        );
    }
}