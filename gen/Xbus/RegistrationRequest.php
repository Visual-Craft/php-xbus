<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: xbus/xbus.proto

namespace Xbus;

use Google\Protobuf\Internal\GPBType;
use Google\Protobuf\Internal\RepeatedField;
use Google\Protobuf\Internal\GPBUtil;

/**
 * Protobuf type <code>xbus.RegistrationRequest</code>
 */
class RegistrationRequest extends \Google\Protobuf\Internal\Message
{
    /**
     * <code>string name = 1;</code>
     */
    private $name = '';
    /**
     * <code>.xbus.Account.Type type = 2;</code>
     */
    private $type = 0;
    /**
     * <code>string csr = 3;</code>
     */
    private $csr = '';
    /**
     * <code>repeated .xbus.Actor actorList = 4;</code>
     */
    private $actorList;

    public function __construct() {
        \GPBMetadata\Xbus\Xbus::initOnce();
        parent::__construct();
    }

    /**
     * <code>string name = 1;</code>
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * <code>string name = 1;</code>
     */
    public function setName($var)
    {
        GPBUtil::checkString($var, True);
        $this->name = $var;
    }

    /**
     * <code>.xbus.Account.Type type = 2;</code>
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * <code>.xbus.Account.Type type = 2;</code>
     */
    public function setType($var)
    {
        GPBUtil::checkEnum($var, \Xbus\Account_Type::class);
        $this->type = $var;
    }

    /**
     * <code>string csr = 3;</code>
     */
    public function getCsr()
    {
        return $this->csr;
    }

    /**
     * <code>string csr = 3;</code>
     */
    public function setCsr($var)
    {
        GPBUtil::checkString($var, True);
        $this->csr = $var;
    }

    /**
     * <code>repeated .xbus.Actor actorList = 4;</code>
     */
    public function getActorList()
    {
        return $this->actorList;
    }

    /**
     * <code>repeated .xbus.Actor actorList = 4;</code>
     */
    public function setActorList(&$var)
    {
        GPBUtil::checkRepeatedField($var, \Google\Protobuf\Internal\GPBType::MESSAGE, \Xbus\Actor::class);
        $this->actorList = $var;
    }

}

