<?php

class Pd_Container_Dependencies {

    private $_dependencies = array();

    public function get($name) {

        if (isset($this->_dependencies[$name])) {
            return $this->_dependencies[$name]['instance'];
        } else {
            return null;
        }

    }

    public function set($name, $dependency) {
        $this->_dependencies[$name] = array(
            'instance' => $dependency,
        );
    }

}