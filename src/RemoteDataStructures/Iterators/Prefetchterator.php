<?php

namespace RemoteDataStructures\Iterators;

/**
 *
 * @author angel
 */
class PrefetchIterator extends RemoteIterator {
 public function  current() { throw Exception('Iterator not implemented');} 
 public function  key() { throw Exception('Iterator not implemented');}
 public function  next() { throw Exception('Iterator not implemented');}
 public function  rewind() { throw Exception('Iterator not implemented');}
 public function  valid() { throw Exception('Iterator not implemented');}
}