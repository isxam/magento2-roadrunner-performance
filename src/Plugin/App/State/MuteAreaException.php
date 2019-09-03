<?php

namespace Isxam\M2RoadRunner\Plugin\App\State;

use Magento\Framework\App\State;

/**
 * Plugin to mute exception in setAreaCode
 */
class MuteAreaException
{
    /**
     * @param State $subject
     * @param \Closure $proceed
     * @param $code
     */
    public function aroundSetAreaCode(State $subject, \Closure $proceed, $code)
    {
        try {
            // throws Exception there is no code
            $subject->getAreaCode();
        } catch (\Exception $e) {
            $proceed($code);
        }
    }
}
