<?php
namespace Dvelum\Social\Auth\Adapter;

use Dvelum\Social\Auth\Adapter;

class Twitter extends Adapter
{
    protected function requestInfo()
    {
        if (isset($_GET['oauth_token']) && isset($_GET['oauth_verifier'])) {

            $params = array(
                'oauth_token'    => $_GET['oauth_token'],
                'oauth_verifier' => $_GET['oauth_verifier'],
            );

            $params = $this->prepareUrlParams($this->settings['access_token'], $params);
            $accessTokens = $this->request($this->settings['access_token'], $params, false);

            parse_str($accessTokens, $accessTokens);

            if (isset($accessTokens['oauth_token'])) {
                $params = array(
                    'oauth_token' => $accessTokens['oauth_token'],
                    'screen_name' => $accessTokens['screen_name'],
                    'include_entities' => 'false',
                );
                $params = $this->prepareUrlParams($this->settings['user_info_url'], $params, $accessTokens['oauth_token_secret']);
                $userInfo = $this->request($this->settings['user_info_url'], $params);

                if (isset($userInfo['id'])) {
                    return $userInfo;
                }
            }
        }
        return false;
    }

    /**
     * Prepare url-params with signature
     *
     * @return array
     */
    private function prepareUrlParams($url, $params = array(), $oauthToken = '', $type = 'GET')
    {
        $params += array(
            'oauth_consumer_key'     => $this->options['clientId'],
            'oauth_nonce'            => md5(uniqid(rand(), true)),
            'oauth_signature_method' => 'HMAC-SHA1',
            'oauth_timestamp'        => time(),
            'oauth_token'            => $oauthToken,
            'oauth_version'          => '1.0',
        );
        ksort($params);
        $sigBaseStr = $type . '&' . urlencode($url) . '&' . urlencode(http_build_query($params));
        $key = $this->options['clientSecret'] . '&' . $oauthToken;
        $params['oauth_signature'] = base64_encode(hash_hmac("sha1", $sigBaseStr, $key, true));
        $params = array_map('urlencode', $params);
        return $params;
    }

    protected function processInfo($responseInfo)
    {
        $info = parent::processInfo($responseInfo);

        // Add page url
        if (isset($info['screen_name'])) {
            $info['page'] = 'https://twitter.com/' . $info['screen_name'];
        }

        if (isset($info['profile_image_url'])) {
            $info['avatar'] = implode('', explode('_normal', $info['profile_image_url']));
        }
    }
}
