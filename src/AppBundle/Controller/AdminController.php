<?php

namespace AppBundle\Controller;

use JavierEguiluz\Bundle\EasyAdminBundle\Controller\AdminController as BaseAdminController;

class AdminController extends BaseAdminController
{


//	Usuario

    public function listUsuarioAction()
    {
        if (!$this->isGranted("ROLE_ADMIN")) {

            return $this->redirectToRoute('admin', ['entity' => 'Usuario', 'action' => 'edit', 'id' => $this->getUser()->getId()]);
        }

        return $this->listAction();
    }

    public function createNewUsuarioEntity()
    {
        return $this->get('fos_user.user_manager')->createUser();
    }

    public function prePersistUsuarioEntity($user)
    {
        $this->get('fos_user.user_manager')->updateUser($user, false);
    }

    public function preUpdateUsuarioEntity($user)
    {
        $this->get('fos_user.user_manager')->updateUser($user, false);
    }

}