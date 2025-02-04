<?php
declare(strict_types=1);

namespace Ctasca\MageBundle\Model\Template;

use Ctasca\MageBundle\Logger\Logger;

/**
 * Data provider class for template makers
 */
class DataProvider
{
    private Logger $logger;
    protected array $data = [];

    /**
     * @param Logger $logger
     */
    public function __construct(Logger $logger)
    {
        $this->logger = $logger;
    }

    /**
     * Set/Get attribute wrapper
     *
     * @param   string $method
     * @param   array $args
     * @return  string|null
     * @throws LocalizedException
     */
    public function __call(string $method, array $args)
    {
        $methodType = strtolower(substr($method, 0, 3));
        $dataKey = $this->_underscore(substr($method, 3));
        $this->logger->logInfo(__METHOD__ . " __call method:", [$method]);
        $this->logger->logInfo(__METHOD__ . " __call extracted key:", [$dataKey]);
        switch ($methodType) {
            case 'get':
                $this->logger->logInfo(__METHOD__ . " get data:", $this->data);
                return $this->getData($dataKey);
            case 'set':
                $value = $args[0] ?? null;
                $this->data[$dataKey] = $value;
                $this->logger->logInfo(__METHOD__ . " set data:", $this->data);
                break;
            default:
                return null;
        }
    }

    /**
     * @param string $key
     * @return mixed
     */
    public function getData(string $key)
    {
        return $this->data[$key] ?? null;
    }

    /**
     * @param array $customData
     * @return void
     */
    public function setCustomData(array $customData): void
    {
        $this->logger->logInfo(__METHOD__ . " custom data loaded", $customData);
        $customDataIterator = new \ArrayIterator($customData);
        while ($customDataIterator->valid()) {
            $currentCustomDataSetter = $customDataIterator->key();
            $currentCustomDataValue = $customDataIterator->current();
            $this->{$currentCustomDataSetter}($currentCustomDataValue);
            $customDataIterator->next();
        }
    }

    /**
     * Converts field names for setters and getters
     *
     * E.g. $this->setMyField($value)
     *
     * @param string $name
     * @return string
     */
    protected function _underscore(string $name): string
    {
        return strtolower(trim(preg_replace('/([A-Z]|[0-9]+)/', "_$1", $name), '_'));
    }
}
