<?php

namespace Riazxrazor\Payumoney;

class PayumoneyResponse
{
    const STATUS_COMPLETED = 'Completed';
    const STATUS_PENDING = 'Pending';
    const STATUS_FAILED = 'Failed';
    const STATUS_TAMPERED = 'Tampered';

    /** @var PayUMoney */
    private $client;

    /** @var array */
    private $params;

    public function __construct(Payumoney $client, array $params)
    {
        $this->client = $client;
        $this->params = $params;
    }

    /**
     * @return array
     */
    public function getParams()
    {
        return $this->params;
    }

    /**
     * @return string
     */
    public function getStatus()
    {
        if ($this->checksumIsValid()) {
            switch (strtolower($this->getTransactionStatus())) {
                case 'success':
                    return self::STATUS_COMPLETED;
                    break;
                case 'pending':
                    return self::STATUS_PENDING;
                    break;
                case 'failure':
                default:
                    return self::STATUS_FAILED;
            }
        }

        return self::STATUS_TAMPERED;
    }

    public function isSuccess()
    {
        return $this->getStatus() === self::STATUS_COMPLETED;
    }

    /**
     * @return string|null
     */
    public function getTransactionId()
    {
        return isset($this->params['mihpayid']) ? (string) $this->params['mihpayid'] : null;
    }

    /**
     * @return string|null
     */
    public function getTransactionStatus()
    {
        return isset($this->params['status']) ? (string) $this->params['status'] : null;
    }

    /**
     * @return string|null
     */
    public function getChecksum()
    {
        return isset($this->params['hash']) ? (string) $this->params['hash'] : null;
    }

    /**
     * @return bool
     */
    public function checksumIsValid()
    {
        $checksumParams = array_reverse(array_merge(['key'], $this->client->getChecksumParams(), ['status', 'salt']));

        $params = array_merge($this->params, ['salt' => $this->client->getMerchantSalt()]);

        $values = array_map(
            function ($paramName) use ($params) {
                return array_key_exists($paramName, $params) ? $params[$paramName] : '';
            },
            $checksumParams
        );

        return hash('sha512', implode('|', $values)) === $this->getChecksum();
    }
}
