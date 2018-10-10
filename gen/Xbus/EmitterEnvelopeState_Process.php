<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: xbus/xbus.proto

namespace Xbus;

use Google\Protobuf\Internal\GPBType;
use Google\Protobuf\Internal\RepeatedField;
use Google\Protobuf\Internal\GPBUtil;

/**
 * Protobuf type <code>xbus.EmitterEnvelopeState.Process</code>
 */
class EmitterEnvelopeState_Process extends \Google\Protobuf\Internal\Message
{
    /**
     * <code>bytes id = 1;</code>
     */
    private $id = '';
    /**
     * <code>.xbus.Process.Status status = 2;</code>
     */
    private $status = 0;
    /**
     * <code>repeated .xbus.LogMessage errors = 3;</code>
     */
    private $errors;

    public function __construct() {
        \GPBMetadata\Xbus\Xbus::initOnce();
        parent::__construct();
    }

    /**
     * <code>bytes id = 1;</code>
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * <code>bytes id = 1;</code>
     */
    public function setId($var)
    {
        GPBUtil::checkString($var, False);
        $this->id = $var;
    }

    /**
     * <code>.xbus.Process.Status status = 2;</code>
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * <code>.xbus.Process.Status status = 2;</code>
     */
    public function setStatus($var)
    {
        GPBUtil::checkEnum($var, \Xbus\Process_Status::class);
        $this->status = $var;
    }

    /**
     * <code>repeated .xbus.LogMessage errors = 3;</code>
     */
    public function getErrors()
    {
        return $this->errors;
    }

    /**
     * <code>repeated .xbus.LogMessage errors = 3;</code>
     */
    public function setErrors(&$var)
    {
        GPBUtil::checkRepeatedField($var, \Google\Protobuf\Internal\GPBType::MESSAGE, \Xbus\LogMessage::class);
        $this->errors = $var;
    }

}

