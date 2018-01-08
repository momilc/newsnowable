<?php
/**
 * Created by IntelliJ IDEA.
 * User: lsm
 * Date: 05/01/18
 * Time: 03:19
 */

namespace App\Security\Context;


use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;

interface SecurityContextInterface
{
    public const ACCESS_DENIED_ERROR  = '_security.403_error';
    public const AUTHENTICATION_ERROR = '_security.last_error';
    public const LAST_USERNAME        = '_security.last_username';
    /**
     * Returns the current security token.
     *
     * @return TokenInterface|null A TokenInterface instance or null if no authentication information is available
     */
    public function getToken(): ?TokenInterface;
    /**
     * Sets the authentication token.
     *
     * @param TokenInterface $token
     */
    public function setToken(TokenInterface $token = null);
    /**
     * Checks if the attributes are granted against the current authentication token and optionally supplied object.
     *
     * @param array $attributes
     * @param mixed $object
     *
     * @return Boolean
     */
    public function isGranted($attributes, $object = null): bool;
}