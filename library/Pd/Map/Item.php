<?php
/**
 * Items define how each dependency should be injected.
 *
 * Options
 *  Name - name of the dependency
 *  InjectWith - method, property, constructor
 *  InjectAs - depends on with param
 *  Force - bool, force injection
 *
 * @author ryan
 */
class Pd_Map_Item {

    private $_dependencyName;
    private $_injectWith;
    private $_injectAs;
    private $_force = false;

    public function setDependencyName($dependencyName) {
        $this->_dependencyName = $dependencyName;
        return $this;
    }

    public function setInjectWith($injectWith) {
        $this->_injectWith = $injectWith;
        return $this;
    }

    public function setInjectAs($injectAs) {
        $this->_injectAs = $injectAs;
        return $this;
    }

    public function setForce($force) {
        $this->_force = $force;
        return $this;
    }

    public function dependencyName() {
        return $this->_dependencyName;
    }

    public function injectWith() {
        return $this->_injectWith;
    }

    public function injectAs() {
        return $this->_injectAs;
    }
    
    public function force() {
        return $this->_force;
    }


}
