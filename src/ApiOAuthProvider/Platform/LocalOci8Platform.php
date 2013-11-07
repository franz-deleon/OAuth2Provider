<?php
namespace ApiOAuthProvider\Platform;

use Doctrine\DBAL\Platforms\OraclePlatform;

/**
 * This platform is a hack because my local oracle has a weird
 * datetime stamp.
 *
 * @author fleo
 */
class LocalOci8Platform extends OraclePlatform
{
    public function getDateTimeFormatString()
    {
        return 'd-M-y h.i.s A';
    }
}