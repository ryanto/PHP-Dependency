<?php


class PdTests_stubs_Something {

   public function aMethod() {
       return 'a method from the something class';
   }
   
   /**
    * @PdInject Apple
    */
   public function setApple($apple) {
       $this->apple = $apple;
   }
   
   public function apple() {
       return $this->apple;
   }

}
