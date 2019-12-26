<?php

namespace Project\AdminBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class ProjectAdminBundle extends Bundle
{
    public function getParent()
    {
        return 'FOSUserBundle';
    }

}
