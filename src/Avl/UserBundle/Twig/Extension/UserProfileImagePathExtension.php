<?php

namespace Avl\UserBundle\Twig\Extension;

use Symfony\Component\HttpFoundation\Session\Session;
use Avl\UserBundle\Entity\User as User;

/**
 * Class UserProfileImagePathExtension
 * @package Avl\UserBundle\Twig\Extension
 */
class UserProfileImagePathExtension extends \Twig_Extension {

    /**
     * @var User
     */
    protected $user;

    /**
     * @var Session
     */
    private $session;

    /**
     * Contructor
     */
    public function __construct() {
        $this->session = new Session();
        $this->user = new User();
    }

    /**
     * @return string
     */
    public function getName() {
        return 'profile_image_extension';
    }

    /**
     * @return array
     */
    public function getFunctions() {
        return array(
            'UserProfileImagePath' => new \Twig_Function_Method($this, 'UserProfileImagePath')
        );
    }

    /**
     * @return string
     */
    public function UserProfileImagePath($profilePicturePath) {

        return true
            //&& null != $this->session->get('profilePicturePath')
            &&
            is_file($this->user->getUploadRootDir().'/'.$profilePicturePath)
            ? $this->user->getUploadDir().'/'.$profilePicturePath
            : $this->user->getUploadDir().'/default-avatar.png';
    }
}