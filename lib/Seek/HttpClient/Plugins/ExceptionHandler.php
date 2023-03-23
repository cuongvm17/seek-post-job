<?php namespace Seek\HttpClient\Plugins;

use Http\Client\Common\Plugin;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Seek\Exceptions\ApiErrorException;
use Seek\Exceptions\BadRequestException;
use Seek\Exceptions\ForbiddenException;
use Seek\Exceptions\NotFoundException;
use Seek\Exceptions\UnauthorizedException;
use Seek\Exceptions\UnprocessableEntityException;
use Seek\HttpClient\Utilities\Response;

/**
 * Response exception handler class.
 */
class ExceptionHandler implements Plugin
{
    /**
     * @param RequestInterface $request
     * @param callable $next
     * @param callable $first
     * @return mixed
     */
    public function handleRequest(RequestInterface $request, callable $next, callable $first)
    {
        return $next($request)->then(
            function (ResponseInterface $response) use ($request) {
                $statusCode = $response->getStatusCode();
                $content = Response::getContent($response);
                $error = isset($content['errors']) ? $content['errors'][0]['message'] : null;
                //print_r($content);
                //echo $statusCode . ' : ' . $response->getBody()->__toString();
                //exit;
                if ($statusCode < 400 || $statusCode > 600) {
                    return $response;
                } elseif ($statusCode == 400) {
                    throw new BadRequestException(empty($content['message']) ? 'Bad request' : $content['message']);
                } elseif ($statusCode == 401) {
                    throw new UnauthorizedException($error === null ? 'Unauthorized' : $error);
                } elseif ($statusCode == 403) {
                    throw new ForbiddenException($error === null ? 'Forbidden' : $error);
                } elseif ($statusCode == 404) {
                    throw new NotFoundException('Resource not found');
                } elseif ($statusCode == 422) {
                    throw new UnprocessableEntityException($error === null ? 'Unprocessable entity' : $error);
                }
                throw new ApiErrorException($error === null ? 'Unknown server error' : $error);
            }
        );
    }
}
