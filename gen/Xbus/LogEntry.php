<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: xbus/xbus.proto

namespace Xbus;

use Google\Protobuf\Internal\GPBType;
use Google\Protobuf\Internal\RepeatedField;
use Google\Protobuf\Internal\GPBUtil;

/**
 * Protobuf type <code>xbus.LogEntry</code>
 */
class LogEntry extends \Google\Protobuf\Internal\Message
{
    /**
     * <code>bytes envelopeID = 1;</code>
     */
    private $envelopeID = '';
    /**
     * <code>bytes actorID = 2;</code>
     */
    private $actorID = '';
    /**
     * <code>bytes processID = 3;</code>
     */
    private $processID = '';
    /**
     * <code>string nodeID = 4;</code>
     */
    private $nodeID = '';
    /**
     * <code>.xbus.LogMessage message = 5;</code>
     */
    private $message = null;

    public function __construct() {
        \GPBMetadata\Xbus\Xbus::initOnce();
        parent::__construct();
    }

    /**
     * <code>bytes envelopeID = 1;</code>
     */
    public function getEnvelopeID()
    {
        return $this->envelopeID;
    }

    /**
     * <code>bytes envelopeID = 1;</code>
     */
    public function setEnvelopeID($var)
    {
        GPBUtil::checkString($var, False);
        $this->envelopeID = $var;
    }

    /**
     * <code>bytes actorID = 2;</code>
     */
    public function getActorID()
    {
        return $this->actorID;
    }

    /**
     * <code>bytes actorID = 2;</code>
     */
    public function setActorID($var)
    {
        GPBUtil::checkString($var, False);
        $this->actorID = $var;
    }

    /**
     * <code>bytes processID = 3;</code>
     */
    public function getProcessID()
    {
        return $this->processID;
    }

    /**
     * <code>bytes processID = 3;</code>
     */
    public function setProcessID($var)
    {
        GPBUtil::checkString($var, False);
        $this->processID = $var;
    }

    /**
     * <code>string nodeID = 4;</code>
     */
    public function getNodeID()
    {
        return $this->nodeID;
    }

    /**
     * <code>string nodeID = 4;</code>
     */
    public function setNodeID($var)
    {
        GPBUtil::checkString($var, True);
        $this->nodeID = $var;
    }

    /**
     * <code>.xbus.LogMessage message = 5;</code>
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * <code>.xbus.LogMessage message = 5;</code>
     */
    public function setMessage(&$var)
    {
        GPBUtil::checkMessage($var, \Xbus\LogMessage::class);
        $this->message = $var;
    }

}

