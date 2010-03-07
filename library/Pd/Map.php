<?php

	class Base_Di_Map  {

        /**
         * Holds an array of items
         * 
         * @var array
         */
		private $_map = array();

        /**
         * @param Base_Di_Map_Item $item
         */
        public function add($item) {
            $this->_map[] = $item;
        }
		
		/**
		 * Returns the map
		 *
		 * @return array
		 */
		public function map($type = null) {
            if (is_null($type)) {
                return $this->_map;
            } else {

                $return = array();
                foreach ($this->_map as $item) {
                    if ($item->type() == $type) {
                        $return[] = $item;
                    }
                }
                return $return;

            }
		}
       
        public function has($type) {
            if (count($this->map($type)) > 0) {
                return true;
            } else {
                return false;
            }
        }

        public function count() {
            return count($this->_map);
        }
		
	}

