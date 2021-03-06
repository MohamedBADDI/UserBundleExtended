<?php
/**
 * Created by PhpStorm.
 * User: avanloock
 * Date: 12.01.15
 * Time: 16:40
 */
namespace Avl\UserBundle\Twig\Extension;

use Avl\UserBundle\Entity\User as User;

/**
 * Class UserProfileImagePathExtension
 * @package Avl\UserBundle\Twig\Extension
 */
class UserProfileImageExtension extends \Twig_Extension
{
    /**
     * @var
     */
    protected $container;

    /**
     * @var User
     */
    protected $user;

    /**
     * @param $container
     */
    public function __construct($container)
    {
        $this->container = $container;
        $this->user = new User();
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'profile_image_extension';
    }

    /**
     * @return array
     */
    public function getFunctions()
    {
        return array(
            new \Twig_SimpleFunction('getUserProfileImage', array($this, 'getUserProfileImage'))
        );
    }

    /**
     * @param $profilePicturePath
     * @param $with
     * @param $height
     * @return mixed
     */
    public function getUserProfileImage($profilePicturePath, $with, $height)
    {
        $cacheManager = $this->container->get('liip_imagine.cache.manager');

        $image =
            is_file($this->user->getUploadRootDir() . '/' . $profilePicturePath)
                ? $this->user->getUploadDir() . '/' . $profilePicturePath
                : $this->user->getUploadDir() . '/default-avatar.png';

        if (null !== $height || null !== $height) {
            $runtimeConfig = array("thumbnail" => array("size" => array($with, $height)));
        } else {
            $runtimeConfig = null;
        }

        return $cacheManager->getBrowserPath(
            $image,
            'user_thumb',
            $runtimeConfig
        );
    }
}
