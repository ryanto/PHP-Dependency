<?php

class Pd_Container_Maps {

    private $_maps = array();

    /**
     * Add/set a map to the container by name
     *
     * @param string $name
     * @param Base_Di_Map $map
     */
    public function set($name, $map) {
        $this->_maps[$name] = $map;
    }

    /**
     * Returns a dependency Map given a name
     *
     * @param string $name
     * @return Base_Di_Map
     */
    public function get($name) {
        if (isset($this->_maps[$name])) {
            return $this->_maps[$name];
        } else {
            return new Base_Di_Map();
        }
    }



}
