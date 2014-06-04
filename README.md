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



