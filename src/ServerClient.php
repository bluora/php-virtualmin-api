<?php

namespace HnhDigital\Virtualmin;

use Symfony\Component\Yaml\Exception\ParseException;
use Symfony\Component\Yaml\Yaml;

class ServerClient extends VirtualminClient
{
    /**
     * Get the info from the client.
     *
     * @return array
     */
    public function info()
    {
        $parameters = [];

        $data = $this->call('info', $parameters);
        $data = str_replace('    * ', '    - ', $data);
        $callback = function($matches) {
            return 'desc: '.str_replace(':', '-', $matches[0]);
        };
        $data = preg_replace_callback("/desc: (.*?)$/sm", $callback, $data);
        $parsed_data = Yaml::parse($data);

        return $parsed_data;
    }

    /**
     * Get the IP address from the server.
     *
     * @return string
     */
    public function ip()
    {
        $parameters = [];
        $parameters['name-only'] = true;

        return $this->call('list-shared-addresses', $parameters);
    }
}
