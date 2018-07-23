<?php

echo "<h1>Hello, " . (getenv('HELLO_NAME') ?: 'world') . "!</h1>";
