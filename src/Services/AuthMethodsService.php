<?php

namespace Scalekit\Services;

use Scalekit\ScalekitClient;

/**
 * Authentication methods service
 * 
 * This service provides methods for passwordless authentication including
 * sending, verifying, and resending passwordless emails with OTP or magic links.
 */
class AuthMethodsService
{
    private ScalekitClient $client;

    public function __construct(ScalekitClient $client)
    {
        $this->client = $client;
    }

   

   

   

    /**
     * Create passwordless connection
     */
    public function createPasswordlessConnection(string $organizationId, array $data): array
    {
        return $this->client->request('POST', "/api/v1/organizations/{$organizationId}/auth-methods/passwordless/connections", [
            'json' => $data
        ]);
    }

    /**
     * Update passwordless connection
     */
    public function updatePasswordlessConnection(string $organizationId, string $connectionId, array $data): array
    {
        return $this->client->request('PATCH', "/api/v1/organizations/{$organizationId}/auth-methods/passwordless/connections/{$connectionId}", [
            'json' => $data
        ]);
    }

    /**
     * Enable passwordless connection
     */
    public function enablePasswordlessConnection(string $organizationId, string $connectionId): array
    {
        return $this->client->request('POST', "/api/v1/organizations/{$organizationId}/auth-methods/passwordless/connections/{$connectionId}:enable");
    }

    /**
     * Send passwordless email with verification code or magic link
     * 
     * Send a verification email containing either a verification code (OTP), 
     * magic link, or both to a user's email address.
     * 
     * @param array $data Request data containing:
     *   - email (string): Email address where credentials will be sent
     *   - template (string): 'SIGNIN' for existing users, 'SIGNUP' for new users
     *   - expires_in (int, optional): Expiration time in seconds (default: 300)
     *   - magiclink_auth_uri (string, optional): Callback URL for magic link
     *   - state (string, optional): Custom state parameter
     *   - template_variables (array, optional): Variables for email template
     * 
     * @return array Response containing:
     *   - auth_request_id (string): ID for subsequent verification
     *   - email (string): Email address
     *   - expires_at (string): Expiration timestamp
     *   - expires_in (int): Seconds until expiration
     *   - passwordless_type (string): Type of authentication sent
     */
    public function sendPasswordlessEmail(array $data): array
    {
        return $this->client->request('POST', '/api/v1/passwordless/email/send', [
            'json' => $data
        ]);
    }

    /**
     * Verify passwordless email authentication
     * 
     * Verify a user's identity using either a verification code or magic link token.
     * 
     * @param array $data Request data containing:
     *   - auth_request_id (string): ID from sendPasswordlessEmail response
     *   - code (string, optional): OTP verification code
     *   - link_token (string, optional): Magic link token
     * 
     * @return array Response containing:
     *   - email (string): Verified email address
     *   - passwordless_type (string): Type of authentication verified
     *   - state (string): Custom state parameter if provided
     *   - template (string): Template type used
     */
    public function verifyPasswordlessEmail(array $data): array
    {
        return $this->client->request('POST', '/api/v1/passwordless/email/verify', [
            'json' => $data
        ]);
    }

    /**
     * Resend passwordless email
     * 
     * Resend a verification email if the user didn't receive it or if 
     * the previous code/link has expired.
     * 
     * @param array $data Request data containing:
     *   - auth_request_id (string): ID from original sendPasswordlessEmail response
     * 
     * @return array Response containing updated authentication request details
     */
    public function resendPasswordlessEmail(array $data): array
    {
        return $this->client->request('POST', '/api/v1/passwordless/email/resend', [
            'json' => $data
        ]);
    }

    /**
     * Send passwordless email with email parameter
     * 
     * Convenience method that accepts email as first parameter.
     * 
     * @param string $email Email address to send to
     * @param array $options Additional options (template, expires_in, etc.)
     * 
     * @return array Response from sendPasswordlessEmail
     */
    public function sendPasswordlessToEmail(string $email, array $options = []): array
    {
        $data = array_merge(['email' => $email], $options);
        return $this->sendPasswordlessEmail($data);
    }

    /**
     * Verify passwordless code
     * 
     * Convenience method for verifying OTP codes.
     * 
     * @param string $authRequestId Authentication request ID
     * @param string $code OTP verification code
     * 
     * @return array Response from verifyPasswordlessEmail
     */
    public function verifyPasswordlessCode(string $authRequestId, string $code): array
    {
        return $this->verifyPasswordlessEmail([
            'auth_request_id' => $authRequestId,
            'code' => $code
        ]);
    }

    /**
     * Verify passwordless magic link
     * 
     * Convenience method for verifying magic link tokens.
     * 
     * @param string $authRequestId Authentication request ID
     * @param string $linkToken Magic link token
     * 
     * @return array Response from verifyPasswordlessEmail
     */
    public function verifyPasswordlessMagicLink(string $authRequestId, string $linkToken): array
    {
        return $this->verifyPasswordlessEmail([
            'auth_request_id' => $authRequestId,
            'link_token' => $linkToken
        ]);
    }

    /**
     * Resend passwordless email by auth request ID
     * 
     * Convenience method that accepts auth request ID as parameter.
     * 
     * @param string $authRequestId Authentication request ID
     * 
     * @return array Response from resendPasswordlessEmail
     */
    public function resendPasswordlessById(string $authRequestId): array
    {
        return $this->resendPasswordlessEmail([
            'auth_request_id' => $authRequestId
        ]);
    }
}
