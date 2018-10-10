<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: xbus/xbus.proto

namespace Xbus;

use Google\Protobuf\Internal\GPBType;
use Google\Protobuf\Internal\RepeatedField;
use Google\Protobuf\Internal\GPBUtil;

/**
 * Protobuf type <code>xbus.ActorProcessRequest</code>
 */
class ActorProcessRequest extends \Google\Protobuf\Internal\Message
{
    /**
     * <code>.xbus.ProcessingContext context = 1;</code>
     */
    private $context = null;
    /**
     * <code>repeated .xbus.ActorProcessRequest.Input inputs = 2;</code>
     */
    private $inputs;

    public function __construct() {
        \GPBMetadata\Xbus\Xbus::initOnce();
        parent::__construct();
    }

    /**
     * <code>.xbus.ProcessingContext context = 1;</code>
     */
    public function getContext()
    {
        return $this->context;
    }

    /**
     * <code>.xbus.ProcessingContext context = 1;</code>
     */
    public function setContext(&$var)
    {
        GPBUtil::checkMessage($var, \Xbus\ProcessingContext::class);
        $this->context = $var;
    }

    /**
     * <code>repeated .xbus.ActorProcessRequest.Input inputs = 2;</code>
     */
    public function getInputs()
    {
        return $this->inputs;
    }

    /**
     * <code>repeated .xbus.ActorProcessRequest.Input inputs = 2;</code>
     */
    public function setInputs(&$var)
    {
        GPBUtil::checkRepeatedField($var, \Google\Protobuf\Internal\GPBType::MESSAGE, \Xbus\ActorProcessRequest_Input::class);
        $this->inputs = $var;
    }

}

