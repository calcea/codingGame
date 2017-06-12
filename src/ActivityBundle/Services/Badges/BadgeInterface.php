<?php

namespace ActivityBundle\Services\Badges;
/**
 * Date: 5/26/2016
 * Time: 19:01
 * @copyright (c) Zitec COM
 * @author George Calcea <george.calcea@zitec.com>
 */
interface BadgeInterface
{

    public function isAvailable();

    public function toArray();


}