<?php

namespace DMH\UserBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class DMHUserBundle extends Bundle
{
    public function getParent()
    {
        return 'FOSUserBundle';
    }
}
