<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: xbus/xbus.proto

namespace Xbus;

use Google\Protobuf\Internal\GPBType;
use Google\Protobuf\Internal\RepeatedField;
use Google\Protobuf\Internal\GPBUtil;

/**
 * Protobuf type <code>xbus.EnvelopePosition</code>
 */
class EnvelopePosition extends \Google\Protobuf\Internal\Message
{
    /**
     * <code>bytes envelope_id = 1;</code>
     */
    private $envelope_id = '';
    /**
     * <code>bool start = 2;</code>
     */
    private $start = false;
    /**
     * <code>bool complete = 3;</code>
     */
    private $complete = false;
    /**
     * <code>repeated .xbus.EventPosition eventPositions = 4;</code>
     */
    private $eventPositions;

    public function __construct() {
        \GPBMetadata\Xbus\Xbus::initOnce();
        parent::__construct();
    }

    /**
     * <code>bytes envelope_id = 1;</code>
     */
    public function getEnvelopeId()
    {
        return $this->envelope_id;
    }

    /**
     * <code>bytes envelope_id = 1;</code>
     */
    public function setEnvelopeId($var)
    {
        GPBUtil::checkString($var, False);
        $this->envelope_id = $var;
    }

    /**
     * <code>bool start = 2;</code>
     */
    public function getStart()
    {
        return $this->start;
    }

    /**
     * <code>bool start = 2;</code>
     */
    public function setStart($var)
    {
        GPBUtil::checkBool($var);
        $this->start = $var;
    }

    /**
     * <code>bool complete = 3;</code>
     */
    public function getComplete()
    {
        return $this->complete;
    }

    /**
     * <code>bool complete = 3;</code>
     */
    public function setComplete($var)
    {
        GPBUtil::checkBool($var);
        $this->complete = $var;
    }

    /**
     * <code>repeated .xbus.EventPosition eventPositions = 4;</code>
     */
    public function getEventPositions()
    {
        return $this->eventPositions;
    }

    /**
     * <code>repeated .xbus.EventPosition eventPositions = 4;</code>
     */
    public function setEventPositions(&$var)
    {
        GPBUtil::checkRepeatedField($var, \Google\Protobuf\Internal\GPBType::MESSAGE, \Xbus\EventPosition::class);
        $this->eventPositions = $var;
    }

}

