<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: xbus/xbus.proto

namespace Xbus;

use Google\Protobuf\Internal\GPBType;
use Google\Protobuf\Internal\RepeatedField;
use Google\Protobuf\Internal\GPBUtil;

/**
 * Protobuf type <code>xbus.ConfigEntry</code>
 */
class ConfigEntry extends \Google\Protobuf\Internal\Message
{
    /**
     * <code>string key = 1;</code>
     */
    private $key = '';
    /**
     * <code>string value = 2;</code>
     */
    private $value = '';

    public function __construct() {
        \GPBMetadata\Xbus\Xbus::initOnce();
        parent::__construct();
    }

    /**
     * <code>string key = 1;</code>
     */
    public function getKey()
    {
        return $this->key;
    }

    /**
     * <code>string key = 1;</code>
     */
    public function setKey($var)
    {
        GPBUtil::checkString($var, True);
        $this->key = $var;
    }

    /**
     * <code>string value = 2;</code>
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * <code>string value = 2;</code>
     */
    public function setValue($var)
    {
        GPBUtil::checkString($var, True);
        $this->value = $var;
    }

}

