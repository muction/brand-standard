<?php declare(strict_types=1);

/*
 * This file is part of the Monolog package.
 *
 * (c) Jordi Boggiano <j.boggiano@seld.be>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Brand\Standard\Driver\Processor;

use Monolog\Processor\ProcessorInterface;
/**
 * Injects url/method and remote IP of the current web request in all records
 *
 * @author Jordi Boggiano <j.boggiano@seld.be>
 */
class BrandProcessor implements ProcessorInterface
{
    public function __construct()
    {
    }

    public function __invoke(array $record): array
    {
        $record['datetime'] = date('Y-m-d H:i:s');
        $record['request_id']  = requestId();
        unset($record['extra']) ;
        return $record;
    }

}
