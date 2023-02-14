<?php

/**
 * @file
 * Contains Drupal\restful_token_auth\Plugin\resource\AccessToken__1_0.
 */

namespace Drupal\restful_token_auth\Plugin\resource;

use Drupal\restful\Http\RequestInterface;
use Drupal\restful\Plugin\resource\ResourceInterface;
use Drupal\restful\Plugin\resource\DataProvider\DataProviderEntityInterface;

/**
 * Class AccessToken__1_0
 * @package Drupal\restful_token_auth\Plugin\resource
 *
 * @Resource(
 *   name = "access_token:1.0",
 *   resource = "access_token",
 *   label = "Access token authentication",
 *   description = "Export the access token authentication resource.",
 *   authenticationTypes = {
 *     "cookie",
 *     "basic_auth"
 *   },
 *   authenticationOptional = FALSE,
 *   dataProvider = {
 *     "entityType": "restful_token_auth",
 *     "bundles": {
 *       "access_token"
 *     },
 *   },
 *   formatter = "single_json",
 *   menuItem = "login-token",
 *   majorVersion = 1,
 *   minorVersion = 0
 * )
 */
class AccessToken__1_0 extends TokenAuthenticationBase implements ResourceInterface {

  /**
   * {@inheritdoc}
   */
  public function controllersInfo() {
    return array(
      '' => array(
        // Get or create a new token.
        RequestInterface::METHOD_GET => 'createToken',
        RequestInterface::METHOD_OPTIONS => 'discover',
      ),
    );
  }

  /**
   * Create a token for a user, and return its value.
   */
  public function createToken() {
    $account = $this->getAccount();

    /* @var \Drupal\restful_token_auth\Entity\RestfulTokenAuthController $controller */
    $controller = entity_get_controller($this->getEntityType());
    $access_token = $controller->generateAccessToken($account->uid);
    $id = $access_token->id;

    $output = $this->view($id);

    return $output;
  }

}
