<?php
namespace OAuth2Provider\Containers;

interface ContainerInterface
{
    /**
     * Retrieves the contents of a specific server.
     *
     * <code>
     * array(
     *     'OAuth_Server1' => array(
     *          'content_key1' => new SomeObject1,
     *          'content_key2' => new SomeObject2,
     *     ),
     *     'OAuth_Server2' => array(
     *          'content_key1' => new SomeObject2,
     *     ),
     * )
     * </code>
     *
     * Assuming the container have the contents above.
     * ContainerInterface::getServerContents('OAuth_Server1')
     * returns:
     *
     * <code>
     * array(
     *     'content_key1' => new SomeObject1,
     *     'content_key2' => new SomeObject2,
     * )
     * </code>
     *
     * @param  string $server Server index key
     * @return array
     */
    public function getServerContents($server);

    /**
     * Retrieves the contents of a server for a specific content key.
     *
     * <code>
     * array(
     *     'OAuth_Server1' => array(
     *          'content_key1' => new SomeObject1,
     *     ),
     *     'OAuth_Server2' => array(
     *          'content_key' => new SomeObject2,
     *     ),
     * )
     * </code>
     *
     * Assuming we have the data above stored in the container.
     *
     * ContainerInterface::getServerContentsFromKey('OAuth_Server1', 'content_key1')
     * returns: new SomeObject1
     *
     * @param  string $server Server index
     * @param  string $key    Content key
     * @return mixed The data to return
     */
    public function getServerContentsFromKey($server, $key);

    /**
     * Check if there are contents in the specified server for
     * a specific key.
     *
     * @param string $server Server index
     * @param string $key    Content key
     * @return boolean
     */
    public function isExistingServerContentInKey($server, $key);
}
