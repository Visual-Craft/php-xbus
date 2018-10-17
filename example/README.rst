A php-xbus example
==================

Start the webserver
-------------------

In a terminal, start a web server that serves the page.php page:

.. code-block:: bash

    php -S localhost:9876


Setup the xbus environment
--------------------------

In a terminal, run the following command to set the environment:

.. code-block:: bash

    xbus-fullenv run fullenv.yaml --target fullenv

After a few seconds, xbus-fullenv should prompt a
``< OK: /path/to/the/target/fullenv`` followed by ``> ``.

In a second terminal, run the following commands to setup the webhook:

.. code-block:: bash

    xbusctl --config fullenv/xbusctl/xbusctl.yaml actor config set php-consumer \
        http.webhook.url=http://localhost:9876/page.php
    xbusctl --config fullenv/xbusctl/xbusctl.yaml actor config set php-consumer \
        http.webhook.content-type=application/x-protobuf


We can now start the http gateway:

.. code-block:: bash

    xbus-http --config fullenv/http-gw/xbus-http.yaml serve


In the firt terminal, on the ``> `` prompt, type, ``startup`` to start the
printer consumer that will receive the replies from the example page.


Send a test envelope
--------------------

Send an envelope that will trigger the 'in' graph and as a consequence,
the configured webhook:

.. code-block:: bash

    xbus-client --config fullenv/client-tests/xbus-client.yaml \
        emit test-emitter < envelope.json


A this point, the webserver should print some logs:

.. code-block::

    [Wed Oct 17 08:19:22 2018] 127.0.0.1:34132 [200]: /page.php


And the printer consumer should print this in the xbus-fullenv console (be
careful, the xbus-fullenv console is verbose and you may need to scroll back
to find those lines):

.. code-block::

    [20523] [INF] -- client-printer:err -- [21283] [INF] print-to-console - msg.reply: item1
    [20523] [INF] -- client-printer:err -- [21283] [INF] print-to-console - msg.reply: item2
