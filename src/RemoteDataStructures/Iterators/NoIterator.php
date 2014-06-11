<?php

namespace RemoteDataStructures\Iterators;

/**
 *
 * @author angel
 */
class NoIterator extends RemoteIterator {
 public function  current() { throw new \Exception('Iterator not implemented');} 
 public function  key() { throw new \Exception('Iterator not implemented');}
 public function  next() { throw new \Exception('Iterator not implemented');}
 public function  rewind() { throw new \Exception('Iterator not implemented');}
 public function  valid() { throw new \Exception('Iterator not implemented');}
}
