<h1>PHP Registry class</h1>

A simple PHP storage registry.

<h2>Usage</h2>

<pre>
<code>
    require_once 'registry.php';
</code>
</pre>

<h3> As an Object </h3>

<pre>
<code>
    // store a value
    $value = 'Hello World!' // mixed, can be anything
    $reg = new registry();
    $reg->set('mykey', $value);

    // retrieve a value
    $myvar =  $reg->get('mykey');
</code>
</pre>

<h3>As a singleton:</h3>

<pre>
<code>
    // store a value
    $value = 'Hello World!' // mixed, can be anything
    registry::getInstance()->set('mykey', $value);
    
    // retrieve a value
    $myvar = registry::getInstance()->get('mykey');
</code>
</pre>

<h3>Method Chaining</h3>

<pre>
<code>
    // store a value
    $value1 = 'Hello World!'
    $value2 = "It's a great day."
    registry::getInstance()
        ->set('mykey1', $value1)
        ->set('mykey2', $value2)
    ;
</code>
</pre>

<h3>Query</h3>

<pre>
<code>
    if (registry::contains('mykey'))
    {
        // do something
    }
</code>
</pre>
