# Config Directory


### 
The config directory containts one file that hold the the PDO object. It's initialized by a constructor that take tree parameters (host , username and password) 

###
 
```php
<?php
  try {
    $pdo = new PDO($host, $username, $password);
  } catch (PDOException $e) {
    echo "Erreur de connexion : " . $e->getMessage();
  }

```
