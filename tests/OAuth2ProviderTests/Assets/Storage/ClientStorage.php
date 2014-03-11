<?php
namespace OAuth2ProviderTests\Assets\Storage;

use OAuth2\Storage\ClientInterface;

class ClientStorage implements ClientInterface
{
    /**
     * Get client details corresponding client_id.
     *
     * OAuth says we should store request URIs for each registered client.
     * Implement this function to grab the stored URI for a given client id.
     *
     * @param $client_id
     * Client identifier to be check with.
     *
     * @return array
     * Client details. The only mandatory key in the array is "redirect_uri".
     * This function MUST return FALSE if the given client does not exist or is
     * invalid. "redirect_uri" can be space-delimited to allow for multiple valid uris.
     * @code
     * return array(
     *     "redirect_uri" => REDIRECT_URI,      // REQUIRED redirect_uri registered for the client
     *     "client_id"    => CLIENT_ID,         // OPTIONAL the client id
     *     "grant_types"  => GRANT_TYPES,       // OPTIONAL an array of restricted grant types
     * );
     * @endcode
     *
     * @ingroup oauth2_section_4
     */
    public function getClientDetails($client_id)
    {

    }

    /**
     * Check restricted grant types of corresponding client identifier.
     *
     * If you want to restrict clients to certain grant types, override this
     * function.
     *
     * @param $client_id
     * Client identifier to be check with.
     * @param $grant_type
     * Grant type to be check with
     *
     * @return
     * TRUE if the grant type is supported by this client identifier, and
     * FALSE if it isn't.
     *
     * @ingroup oauth2_section_4
     */
    public function checkRestrictedGrantType($client_id, $grant_type)
    {

    }

    /**
     * Get the scope associated with this client
     *
     * @return
     * STRING the space-delineated scope list for the specified client_id
     */
    public function getClientScope($client_id)
    {

    }
}