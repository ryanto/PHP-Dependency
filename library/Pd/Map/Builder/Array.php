<?php

require_once 'Pd/Map/Builder/Abstract.php';

/**
 * Give it arrays and it will build a map.
 * This class support chaining
 *
 */
class Pd_Map_Builder_Array extends Pd_Map_Builder_Abstract {

    private $_arrayMaps = array();

    protected function _setup() {
        return null;
    }

    protected function _build() {
        foreach ($this->_arrayMaps as $options) {

            $this->map()->add(
                    $this->_makeItemFromOptions($options)
            );
        }

        $this->_arrayMaps = array();
    }


    public function add($mapArray) {
        $this->_arrayMaps[] = $mapArray;
        return $this;
    }



}

