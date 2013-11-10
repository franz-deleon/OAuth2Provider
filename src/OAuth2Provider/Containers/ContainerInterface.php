<?php
namespace OAuth2Provider\Containers;

interface ContainerInterface
{
    /**
     * Retrieves the contents of a specific server
     * The returned array should be off below:
     *
     * array(
     *     'OAuth_Server1' => array(
     *          'content_key' => new SomeObject,
     *     ),
     *     'OAuth_Server2' => array(
     *          'content_key' => new SomeObject,
     *     ),
     * )
     *
     * @param  string $server
     * @return array
     */
    public function getServerContents($server);

    /**
     * Retrieves the contents of a server for a specific content key.
     *
     * array(
     *     'OAuth_Server1' => array(
     *          'content_key1' => new SomeObject1,
     *     ),
     *     'OAuth_Server2' => array(
     *          'content_key' => new SomeObject1,
     *     ),
     * )
     *
     * With the data above:
     *
     * ContainerInterface::getServerContentsFromKey('OAuth_Server1', 'content_key1')
     * returns: new SomeObject1
     *
     * @param  string $server
     * @return mixed The data to return
     */
    public function getServerContentsFromKey($server, $key);
}
