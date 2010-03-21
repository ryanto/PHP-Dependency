<?php

/**
 * A map is just a bunch of items
 *
 */

class Pd_Map {

    /**
     * Holds an array of items
     *
     * @var array
     */
    private $_items = array();

    /**
     * @param Base_Di_Map_Item $item
     */
    public function add($item) {
        $this->_items[] = $item;
    }

    /**
     * @return array
     */
    public function items() {
        return $this->_items;
    }

    /**
     * Returns an array of items
     *
     * @param string injectWith return an array of only items that match injectWith
     * @return array
     */
    public function map($injectWith = null) {
        if (is_null($type)) {
            return $this->_items;
        } else {

            $return = array();
            foreach ($this->_items as $item) {
                if ($item->injectWith() == $injectWith) {
                    $return[] = $item;
                }
            }
            return $return;

        }
    }


    public function has($type) {
        if (count($this->map($injectWith)) > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function count() {
        return count($this->_items);
    }

}

