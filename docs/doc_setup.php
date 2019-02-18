<?php

/**
 * @OA\Info(
 *   title=PROJECT_TITLE,
 *   description=PROJECT_DESCRIPTION,
 *   version=PROJECT_VERSION,
 *   @OA\Contact(
 *     email=AUTHOR_EMAIL,
 *     name=AUTHOR_NAME,
 *     url=AUTHOR_URL
 *   )
 * ),
 * @OA\OpenApi(
 *   @OA\Server(
 *       url=API_BASE_PATH,
 *       description=SERVER_DESCRIPTION
 *   )
 * )
 * @OA\SecurityScheme(
 *      securityDefinition="Bearer",
 *     type="apiKey",
 *     in="header",
 *     securityScheme="api_key",
 *     name=AUTH_HEADER_NAME
 * )
 */