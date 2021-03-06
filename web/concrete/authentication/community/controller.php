<?php
namespace Concrete\Authentication\Community;

use Concrete\Core\Authentication\Type\Community\Service\Community;
use Concrete\Core\Authentication\Type\OAuth\OAuth2\GenericOauth2TypeController;

class Controller extends GenericOauth2TypeController
{

    public function supportsRegistration()
    {
        return \Config::get('auth.community.registration_enabled', false);
    }

    public function getAuthenticationTypeIconHTML()
    {
        return '<div class="ccm-concrete-authentication-type-svg" data-src="/concrete/images/authentication/community/concrete.svg">' .
                    file_get_contents(DIR_BASE_CORE . '/images/authentication/community/concrete.svg') .
               '</div>';
    }

    public function getHandle()
    {
        return 'community';
    }

    /**
     * @return Community
     */
    public function getService()
    {
        if (!$this->service) {
            $this->service = \Core::make('community_service');
        }
        return $this->service;
    }

    public function saveAuthenticationType($args)
    {
        \Config::save('auth.community.appid', $args['apikey']);
        \Config::save('auth.community.secret', $args['apisecret']);
        \Config::save('auth.community.registration_enabled', $args['registration_enabled']);
    }

    public function edit()
    {
        $this->set('form', \Loader::helper('form'));
        $this->set('apikey', \Config::get('auth.community.appid', ''));
        $this->set('apisecret', \Config::get('auth.community.secret', ''));
    }

    /**
     * @return Array
     */
    public function getAdditionalRequestParameters() {
        return array('state' => time());
    }

    public function getExtractor() {
        try {
            return parent::getExtractor();
        } catch (\Exception $e) {
            dd($e);
        }
    }

}
