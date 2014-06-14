SPL data structure backed by Redis.


The project provides the standard set of PHP data structures implemented in Redis.

```php

$stack = new \RemoteDataStructures\RedisStack('myStack');
$stack->push(1);
$stack->push(2);


// A default key is given based on where this class was instanced
$heap = new \RemoteDataStructures\RedisMinHeap();
$heap->insert(1);
$heap->insert(2);
$heap->insert(3);

$heap->extract();
> 1

```

## Default key convention

By default assumes that the same data structure is always encapsulated in the same service
and generates a key in redis in function of where the class was created.
In the example below $userStorage would have the redis key 'UserService\RedisObjectStorage'

Generated Redis keys can always be overriden by passing the key in the construction as in
$secondaryUserStorage.

```php

class UserService {

/** @var \RemoteDataStructures\RedisObjectStorage */
private $userStorage;

public function __construct() {
    $this->secondaryUserStorage = new \RemoteDataStructures\RedisObjectStorage('secondary');
}

public function addUser(User $user) {
    $this->userStorage[$user->getId()] = $user;
}

public function getUser($id) {
    return $this->userStorage[$id];
}
```

## Iteration

How iteration should happen over a remote collection it is likely to be a highly dependent  
on each particular use case.
That is why by default iterating over a collection throws an exception. Should you need
to iterate, the strategy for iteration must be explicitly chosen.

```php
// Iterate copying elements in batches of 5
$list->setIteratorType('PrefetchIterator', [5]);

// Will copy the entire collection before iterating
$list->setIteratorType('PrefetchIterator', [count($list)]);


// These two are equivalent
$list->setIteratorType('PrefetchIterator', [1]);
$list->setIteratorType('CursorIterator');
```

## Connection to Redis

Connections work as in https://github.com/nrk/predis#connecting-to-redis, each class can receive
an array of parameters to configure the connection.

Configuration parameters can be specified globally with RedisConfiguration. Each class will
try to find its parameters first with RedisConfiguration when none were provided.


```php

// Define default configuration
RedisConfiguration::setParameters([
            'scheme' => 'tcp',
            'host'   => '10.0.0.1',
            'port'   => 6379,
        ]);

// Only that key will use this params
RedisConfiguration::setParameters([
    'scheme' => 'tcp',
    'host'   => '10.0.0.2',
    'port'   => 6379,
],
'\RemoteDataStructures\RedisMinHeapTest');

```

## Notes

Other collection libraries in PHP:
- http://stackoverflow.com/questions/1580223/java-like-collections-in-php
- https://github.com/schmittjoh/php-collection
